var groups = [];
var current_client_position;
var auto_refresh; //auto refresh time out refference
var target_group_index;
/*
  On mouse over the edit or delete buttons
*/
$(document)
  .on("mouseover","span.glyphicon-erase",function(e) {
    $(e.target).css('cursor', 'hand');
  })
  .on("mouseleave","span.glyphicon-erase",function(e) {
    $(e.target).css('cursor', 'pointer');
  });
//initialize page
$(window).on("load",function()
 {
     if(getBrowserCompatibility())
     {
       navigator.geolocation.getCurrentPosition(initializePosition, showError);
     }
     else
     {
       show_notification("error","You browser doesn't support geolocation.",4000);
       setTimeout(function() {
         window.location.replace(webRoot);
       },3000);
     }
 });

 //Sort json by key
 function sortJsonByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key];
        var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
 }
 //try to access on client geolocation
 function getBrowserCompatibility() {
     if (navigator.geolocation) {
         return true;
     } else {
         return false;
     }
 }
 //save client location
 function initializePosition(position) {
     savePlayerLocation(position);
     show_clock("#count-down",moment().add(time_left,'minutes').format("YYYY/MM/DD HH:mm:00"),"","questionnaireTimeCompleted()");
     //change visibility of elements
     $("#questionnaire-name").css("display","block");
     $("#count-down").css("display","block");
     $("#auto-refresh").css("display","block");
     getQuestionGroups();
 }
 //show geolocation errors
 function showError(error) {
     switch(error.code) {
         case error.PERMISSION_DENIED:
             show_notification("error","User denied the request for Geolocation.",4000);
             break;
         case error.POSITION_UNAVAILABLE:
             show_notification("error","Location information is unavailable.",4000);
             break;
         case error.TIMEOUT:
             show_notification("error","The request to get user location timed out.",4000);
             break;
         case error.UNKNOWN_ERROR:
             show_notification("error","An unknown error occurred.",4000);
             break;
     }
     setTimeout(function() {
      window.location.replace(webRoot);
    },3000);
 }
 //change auto refresh status
 function changeAutoRefreshStatus()
 {
   if($("#auto-refresh").css('color') == 'rgb(255, 0, 0)') {
     $("#auto-refresh").css('color','green');
     auto_refresh = navigator.geolocation.watchPosition(refreshAllDistances,showError);
     show_notification("success","Auto refresh enabled successfully.",3000);
   }
   else {
     $("#auto-refresh").css('color','red');
     navigator.geolocation.clearWatch(auto_refresh);
     show_notification("success","Auto refresh disabled successfully.",3000);
   }
 }
 //refresh all question groups
 function refreshAllDistances(position)
 {
   //save user location
   current_client_position = position;
   var i,distance;
   for(i=0;i<groups.length;i++)
   {
     if(groups[i]["address"])
     {
       distance = calculateDistance(i);
     }
     else {
       distance = 0;
     }
     $("#distance" + groups[i].id).html("Distance: " + distance + "m ");
     if(groups[i]["total-questions"] != groups[i]["answered-questions"])
     {
       if(distance > 0) {
         $("#play" + groups[i].id).prop("disabled",true);
       }
       else if($("#play" + groups[i].id).val() != "Completed") {
         $("#play" + groups[i].id).prop("disabled",false);
       }
     }
   }
 }

 //refresh a specific question groups
 function refreshASpecificGroup(position)
 {
   savePlayerLocation(position);
   var distance;
   distance = calculateDistance(target_group_index);
   if(displayDistance(distance))
   {
     //show_notification("success",groups[target_group_index].name + " distance updated successfully",3000);
   }
   else
   {
     show_notification("error","Something going wrong",3000);
   }
 }
  //display distance to target group index
  function displayDistance(distance)
  {
    $("#distance" + groups[target_group_index].id).html("Distance: " + distance + "m ");
    if(groups[target_group_index]["total-questions"] != groups[target_group_index]["answered-questions"])
    {
      if(distance > 0) {
        $("#play" + groups[target_group_index].id).prop("disabled",true);
      }
      else if($("#play" + groups[target_group_index].id).val() != "Completed") {
        $("#play" + groups[target_group_index].id).prop("disabled",false);
      }
    }
    return true;
  }

 //save user location
 function savePlayerLocation(position)
 {
   current_client_position = position;
 }

//get question groups
function getQuestionGroups()
{
  $.post(webRoot + "/rest_api/questionnaire/" + questionnaire_id + "/groups",
  {

  },
  function(data,status)
  {
    if(status == "success")
    {
      groups = sortJsonByKey(data["question-group"],"priority");
      getAddresses();
    }
  });
}
//get address from google api
function getAddresses()
{
  var i = 0;
  var out = "";
  //get addresses from google api
  for(i=0; i<groups.length; i++)
  {
    if(groups[i]["latitude"] == null || groups[i]["longitude"] == null) {
      continue;
    }
    (function(i)
    {
        /*
          Get real address name
          #URL : https://maps.googleapis.com/maps/api/geocode/json?address={*latitude,*longitude}

          #No Parameters
        */
        $.post("https://maps.googleapis.com/maps/api/geocode/json?address="+ (groups[i]["latitude"] != null ? groups[i]["latitude"] + ","  : "")  + (groups[i]["longitude"] != null ? groups[i]["longitude"] : "") + "&key=" + googleApiKey,
        {

        },
        function(data,status)
        {
          if(status == "success")
          {
            groups[i]["address"] = data["results"][0] != undefined ? data["results"][0]["formatted_address"] : "";
          }
        });
     })(i);
  }
  displayData();
}
//display data on page
function displayData()
{
  out = "";
  var i = 0;
  for(i=0; i<groups.length; i++)
  {
    (function(i)
    {
          out += "<div class='panel panel-info'>" +
                      "<div class='panel-heading text-center'>" +
                        "<p class='panel-title'>" +
                          "<a data-toggle='collapse' data-parent='#accordion' href='#collapse" + groups[i].id + "'>" +
                            groups[i].name +
                          "</a>" +
                        "</p>" +
                      "</div>" +
                      "<div id='collapse" + groups[i].id + "' class='panel-collapse collapse'>" +
                        "<div class='panel-body'>";
          if(groups[i]["time-to-complete"] > -1)
          {
            out += "<div id='group-count-down" + groups[i].id + "' class='col-xs-offset-10'>" + groups[i]["time-to-complete"] + " seconds</div>";
          }
          out += "<div>Answered: " +
                    "<span id='answered" + groups[i].id + "'>" + groups[i]["answered-questions"] + "</span>" +
                    "/" +
                    "<span id='total-questions" + groups[i].id + "'>" + groups[i]["total-questions"] + "</span>" +
                    " <span style='color:#36A0FF' title='Reset your answers' class='glyphicon glyphicon-erase' onclick='target_group_index = " + i + ";resetQuestionGroupAnswers(" + i + ");'></span>" +
                  "</div>";
          if(groups[i]["priority"] != "-1")
          {
            out += "<div>Priority: " + groups[i]["priority"] + "</div>";
          }
          else {
            out += "<div>Priority: <span style='color:red'> Without</span></div>";
          }
          //if true (groups[i]["address"] != undefined
          if(groups[i]["address"])
          {
            out += "<div id='location'>" +
                    "<a href='https://www.google.com/maps/dir//" + groups[i]["latitude"] + "," + groups[i]["longitude"] + "' target='_blank'><span class='fi-map' style='font-size:20px'></span> " + groups[i]["address"] + "</a>" +
                  "</div>" +
                  "<div>" +
                        "<span id='distance" + groups[i].id + "'>Distance: " + calculateDistance(i) + "m </span><span style='color:#36A0FF' class='fa fa-refresh' onclick='target_group_index = " + i + "; navigator.geolocation.getCurrentPosition(refreshASpecificGroup, showError);'></span>" +
                  "</div>";
          }
          //No address
          else {
            out += "<div style='color:red'>Available everywhere</div>";
          }
          out += "<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>";
          //Question group completed
          if(groups[i]["answered-questions"] == groups[i]["total-questions"] || (groups[i]["is-completed"] != null && groups[i]["is-completed"] == true))
          {
            out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' disabled value='Completed'> ";
          }
          //Question group not completed
          else {
            //With address
            if(groups[i]["address"])
            {
              if(calculateDistance(i) == 0)
              {
                out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' value='Play now' onclick='playQuestionGroup(" + i + ")'>";
              }
              else {
                out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' value='Play now' disabled>";
              }
            }
            //No address
            else {
              out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' value='Play now' onclick='playQuestionGroup(" + i + ")'>";
            }
          }
          out += "</div>" +
            "</div>" +
        "</div>" +
      "</div>";
    })(i);
  }
    $("#accordion").html(out);
    //if auto refresh icon is disabled
    if($("#auto-refresh-icon").css("color") == "rgb(255, 0, 0)")
    {
      $("#auto-refresh-icon").trigger("click");
    }
}
//calculate client distance
function calculateDistance(i)
{
  /** Converts numeric degrees to radians */
  if (typeof(Number.prototype.toRad) === "undefined") {
    Number.prototype.toRad = function() {
      return this * Math.PI / 180;
    }
  }
  var R = 6371; // Radius of the earth in km
  var dLat = (groups[i]["latitude"]-current_client_position.coords.latitude).toRad();
  var dLon = (groups[i]["longitude"]-current_client_position.coords.longitude).toRad();
  var lat1 = groups[i]["latitude"].toRad();
  var lat2 = current_client_position.coords.latitude.toRad();

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c;

  //Convert km to meters
  d = d.toFixed(2) * 1000;

  //Check the final distance
  if(d.toFixed(2) - groups[i].radius >= 0)
  {
    d = d.toFixed(2) - groups[i].radius;
  }
  else
  {
    d = 0;
  }

  //return value formatted with 2 decimals
  return d.toFixed(2);
}

//try to get client geolocation
function playQuestionGroup(target)
{
  target_group_index = target;

  var notCompletedFoundPosition = null,
      priorityInfraction = false;

  for(j=0;j<groups.length;j++)
  {
    if(j != target_group_index && groups[j]["priority"] < groups[target_group_index]
        && groups[j]["answered-questions"] != groups[j]["total-questions"]
        && groups[j]["is-completed"] == null)
    {
      priorityInfraction = true;
    }

    if(j != target_group_index && groups[j]["time-left"] != null
      && groups[j]["time-left"] > 0
      && groups[j]["answered-questions"] != groups[j]["total-questions"]
      && groups[j]["is-completed"] == null)
    {
      notCompletedFoundPosition = j;
    }
  }

  if(priorityInfraction) { return; }
  if(notCompletedFoundPosition != null)
  {
    //Questionnaire doesnt allow multiple playthrough
    if(!allow_multiple_groups)
    {
      show_notification("error","You must complete: " + groups[notCompletedFoundPosition]["name"],4000);
      return;
    }
    //else continue get questions
  }

  if(groups[target_group_index].latitude != null && groups[target_group_index].longitude != null)
  {
    getNextQuestionUsingCoordinates(current_client_position);
  }
  //without address
  else
  {
    getNextQuestionWithoutCoordinates();
  }
}

//try to get questions without coordinates
function getNextQuestionWithoutCoordinates()
{
  $.ajax(
  {
    url: webRoot +
            "rest_api/questionnaire/" +
            questionnaire_id + "/group/" +
            groups[target_group_index].id + "/question",
    dataType: 'json',
    success: function(data)
    {
      if(groups[target_group_index]["time-left"] == null && groups[target_group_index]["time-to-complete"] >= 0)
      {
        groups[target_group_index]["time-left"] = groups[target_group_index]["time-to-complete"];
        show_clock("#group-count-down"+ groups[target_group_index].id,moment().add(groups[target_group_index]["time-left"],'second').format("YYYY/MM/DD HH:mm:ss"),groups[target_group_index]["name"] + " time expired.","questionGroupTimeExpired(" + target_group_index + ")");
      }

      var out = "";
      /*
          200 : Everything ok.
          603 : Forbidden, Questionnaire offline
          604 : Forbidden, You dont have access to that questionnaire
          606 : Forbidden, Coordinates not provided.
          607 : Forbidden, Invalid location or user not in participation group.
          608 : Not Found, Group doesnt not exist or doesnt belong to questionnaire
          609 : Question Group doesnt have any more questions
      */
      if(data.code == "200")
      {
        if(!$("#play-questionnaire").hasClass('in'))
        {
          showModal("play-questionnaire");
        }
        out = " <div class='col-xs-4 col-xs-offset-8 col-sm-offset-9 col-sm-3' id='question-count-down'> </div>" +
                "<div class='form-group'>" +
                    "<div class='col-xs-2 col-sm-offset-1 col-sm-2'>" +
                        "<span class='text-center'><i class='material-icons bigicon'>question_answer</i></span>" +
                    "</div>" +
                    "<div class='col-xs-7 gt-input-group'>" +
                        "<label id='question-game'>" + data.question['question-text'] + "</label>" +
                    "</div>" +
                "</div>";
              var i;
              for(i=0;i<data.answer.length;i++)
              {
                out += "<div class='form-group'>" +
                          "<div class='col-xs-offset-2 col-xs-7 col-sm-offset-3 radio'>" +
                            "<label class='active'><input type='radio' name='optradio' value='" + data.answer[i]['id'] + "'>" + data.answer[i]['answer-text'] + "</label>" +
                          "</div>" +
                       "</div>";
              }
        out += "<br><br><div class='form-group'>" +
                   "<div class='col-xs-4 col-sm-offset-3 col-sm-2'>" +
                     "<button id='confirm-answer-button' type='button' class='btn btn-primary btn-md' onclick='confirmAnwser(" + data.question.id + ",false)'>Confirm</button>" +
                   "</div>" +
                   "<div class='col-xs-3 col-sm-2'>" +
                     "<button type='button' class='btn btn-primary btn-md' data-dismiss='modal' >" +
                       "Cancel" +
                     "</button>" +
                   "</div>" +
                "</div>";
        $("#play-questionnaire-form").html(out);
        //var answer_countdown = parseInt(data.question['time-to-answer']);
        show_clock("#question-count-down",moment().add(data.question['time-to-answer'],'second').format("YYYY/MM/DD HH:mm:ss"),"Your time expired.","questionTimeExpired()");
      }
    },
    error: function(xhr, status, error) {
        var response = JSON.parse(xhr.responseText);

        if(response.code == "609")
        {
          show_notification("warning",response.message,3000);
          $("#play-questionnaire").modal("toggle");
          $("#play"+groups[target_group_index].id).val("Completed")
                                       .prop("disabled",true);
          if(completed())
          {
              $("#play-questionnaire").modal("toggle");
              HoldOn.open({
                 theme:"sk-cube-grid",
                 message: "<br><div class='col-xs-12' style='font-size:16px'>Questionnaire completed successfully. We will redirect you, to your questionnaires page."
              });
              setTimeout(function() {
                window.location.replace(my_questionnaires_page);
              },10000);
          }
        }
        else {
          var response = JSON.parse(xhr.responseText);
          switch(response.code)
          {
            case "603":
            case "604":
            case "606":
            case "607":
            case "608":
            case "609":
            case "611":
            case "616":
            case "617":
            case "618":
              show_notification("error",response.message,4000);
              break;
            default:
              show_notification("error","Unknow error. Please contact with us.",4000);
              break;
          }
        }
    }
  });
}

//try to get questions using coordinates
function getNextQuestionUsingCoordinates(position)
{
  $.when(refreshASpecificGroup(position)).done(function() {
    $.ajax(
    {
      url: webRoot +
              "rest_api/questionnaire/" +
              questionnaire_id + "/group/" +
              groups[target_group_index].id + "/question",
      headers: {
        'X-Coordinates': position.coords.latitude +
                          ";" + position.coords.longitude,
      },
      dataType: 'json',
      success: function(data)
      {
        if(groups[target_group_index]["time-left"] == null && groups[target_group_index]["time-to-complete"] >= 0)
        {
          groups[target_group_index]["time-left"] = groups[target_group_index]["time-to-complete"];
          show_clock("#group-count-down"+ groups[target_group_index].id,moment().add(groups[target_group_index]["time-left"],'second').format("YYYY/MM/DD HH:mm:ss"),groups[target_group_index]["name"] + " time expired.","questionGroupTimeExpired(" + target_group_index + ")");
        }

        var out = "";
        /*
            200 : Everything ok.
            603 : Forbidden, Questionnaire offline
            604 : Forbidden, You dont have access to that questionnaire
            606 : Forbidden, Coordinates not provided.
            607 : Forbidden, Invalid location or user not in participation group.
            608 : Not Found, Group doesnt not exist or doesnt belong to questionnaire
            609 : Question Group doesnt have any more questions
        */
        if(data.code == "200")
        {
          if(!$("#play-questionnaire").hasClass('in'))
          {
            showModal("play-questionnaire");
          }
          out = " <div class='col-xs-4 col-xs-offset-8 col-sm-offset-9 col-sm-3' id='question-count-down'> </div>" +
                  "<div class='form-group'>" +
                      "<div class='col-xs-2 col-sm-offset-1 col-sm-2'>" +
                          "<span class='text-center'><i class='material-icons bigicon'>question_answer</i></span>" +
                      "</div>" +
                      "<div class='col-xs-7 gt-input-group'>" +
                          "<label id='question-game'>" + data.question['question-text'] + "</label>" +
                      "</div>" +
                  "</div>";
                var i;
                for(i=0;i<data.answer.length;i++)
                {
                  out += "<div class='form-group'>" +
                            "<div class='col-xs-offset-2 col-xs-7 col-sm-offset-3 radio'>" +
                              "<label class='active'><input type='radio' name='optradio' value='" + data.answer[i]['id'] + "'>" + data.answer[i]['answer-text'] + "</label>" +
                            "</div>" +
                         "</div>";
                }
          out += "<br><br><div class='form-group'>" +
                         "<div class='col-xs-3 col-sm-offset-3 col-sm-2'>" +
                           "<button id='confirm-answer-button' type='button' class='btn btn-primary' onclick='confirmAnwser(" + data.question.id + ",true)'>Confirm</button>" +
                         "</div>" +
                         "<div class='col-xs-4 col-sm-2'>" +
                           "<button type='button' class='btn btn-primary' data-dismiss='modal' >" +
                             "Cancel" +
                           "</button>" +
                         "</div>" +
                  "</div>";
          $("#play-questionnaire-form").html(out);
          //var answer_countdown = parseInt(data.question['time-to-answer']);
          show_clock("#question-count-down",moment().add(data.question['time-to-answer'],'second').format("YYYY/MM/DD HH:mm:ss"),"Your time expired","questionTimeExpired()");
        }
      },
      error: function(xhr, status, error) {
        var response = JSON.parse(xhr.responseText);
        if(response.code == "609")
        {
          show_notification("warning",response.message,3000);
          $("#play-questionnaire").modal("toggle");
          $("#play"+groups[target_group_index].id).val("Completed")
                                       .prop("disabled",true);
          if(completed())
          {
              $("#play-questionnaire").modal("toggle");
              HoldOn.open({
                 theme:"sk-cube-grid",
                 message: "<br><div class='col-xs-12' style='font-size:16px'>Questionnaire completed successfully. We will redirect you, to your questionnaires page."
              });
              setTimeout(function() {
                window.location.replace(my_questionnaires_page);
              },10000);
          }
        }
        else {
          var response = JSON.parse(xhr.responseText);
          switch(response.code)
          {
            case "603":
            case "604":
            case "606":
            case "607":
            case "608":
            case "609":
            case "611":
            case "616":
            case "617":
            case "618":
              show_notification("error",response.message,4000);
              break;
            default:
              show_notification("error","Unknow error. Please contact with us.",4000);
              break;
          }
        }
      }
    });
  });
}

function confirmAnwser(question_id,usingCoordinates)
{
  $("#confirm-answer-button").prop("disabled",true);
  var selected_answer_id = $("input[name='optradio']:checked").val();
  let headersData = { };

  if(usingCoordinates)
  {
    headersData = {
      "X-Coordinates": groups[target_group_index].latitude +
                        ";" + groups[target_group_index].longitude
    }
  }

  let data =
  {
    'question-id' : question_id,
    'answer-id' : selected_answer_id
  };
  $.ajax({
    method: "POST",
    url: webRoot + "rest_api/answer",
    headers: headersData,
    data: JSON.stringify(data)
  })
  .done(function(data)
  {
      /*
        200 : Everything ok. Question answered successfully
        201 : Everything ok. Question answered, Question group completed
        603 : Forbidden, Questionnaire offline
        605 : Forbidden, You cant answer this question
        606 : Forbidden, Coordinates not provided.
        607 : Forbidden, Invalid location or user not in participation group.
        500 : Internal server error.
        610 : Invalid Request, question-id and/or answer-id were not given
      */
        if(data.code == "200")
        {
          show_notification("success",data.message,3000);
        }
        else if(data.code == "201")
        {
          groups[target_group_index]["is-completed"] = 1;
          show_notification("success",data.message,3000);
          $("#play-questionnaire").modal("toggle");
        }
        $('#question-count-down').countdown('stop');
        $.when(refreshAnswers()).done(function() {
          if(!completed())
          {
            playQuestionGroup(target_group_index);
          }
          else
          {
            $("#play-questionnaire").modal("toggle");
            HoldOn.open({
               theme:"sk-cube-grid",
               message: "<br><div class='col-xs-12' style='font-size:16px'>Questionnaire completed successfully. We will redirect you, to your questionnaires page."
            });
            setTimeout(function() {
              window.location.replace(my_questionnaires_page);
            },10000);
          }
        });
    })
    .fail(function(xhr, status, error) {
      var response = JSON.parse(xhr.responseText);
      switch(response.code)
      {
        case "603":
        case "605":
        case "606":
        case "607":
        case "500":
        case "610":
          show_notification("error",response.message,4000);
          break;
        default:
          show_notification("error","Unknow error. Please contact with us.",4000);
          break;
      }
  });
}

//Refresh question groups answers
function refreshAnswers()
{
  //save values
  var id = groups[target_group_index].id;
  var answered = parseInt($("#answered"+id).html()) + 1;
  var total_questions = parseInt($("#total-questions"+id).html());

  //update answered-questions
  $("#answered"+id).html(answered);
  groups[target_group_index]["answered-questions"] = answered;
  //check if question group completed
  if(answered == total_questions || (groups[target_group_index]["is-completed"] != null && groups[target_group_index]["is-completed"] == true))
  {
    $("#play" + id).val("Completed")
                   .prop('disabled',true);
  }
}

//return true if game completed
function completed() {
  return $("input[id^=play][disabled]").length == $("input[id^=play]").length;
}

function resetQuestionGroupAnswers(target)
{
  var id = groups[target].id;
  /*
    200 : Everything ok.
    604 : Forbidden, You dont have access to that questionnaire
    607 : Forbidden , you cant reset this question group.
    608 : Not Found, Group doesnt not exist or doesnt belong to questionnaire
    609 : Question Group doesnt have any more questions
    611 : Maximum times of question group replays reached.
  */
  $.ajax({
    method: "POST",
    url: webRoot + "rest_api/questionnaire/" + questionnaire_id + "/group/" + id + "/reset",
    data: { }
  })
  .done(function(data) {
    if(data.code == "200")
    {
      show_notification("success",data.message,4000);
      groups[target]["answered-questions"] = 0;
      groups[target]["is-completed"] = null;
      groups[target]["time-left"] = null;

      if(groups[target]["time-left"] == null)
      {
        $("#group-count-down"+ groups[target].id).countdown('stop');
        $("#group-count-down"+ groups[target].id).html(groups[target]["time-to-complete"] + " seconds");
      }

      //update answered-questions
      $("#answered"+id).html(groups[target]["answered-questions"]);
      //check if question group completed
      if(answered == total_questions || (groups[target]["is-completed"] != null && groups[target]["is-completed"] == true))
      {
        $("#play" + id).val("Play");
        navigator.geolocation.getCurrentPosition(refreshASpecificGroup, showError);
      }
    }
  })
  .fail(function(xhr, status, error) {
    var response = JSON.parse(xhr.responseText);
    switch(response.code)
    {
      case "604":
      case "607":
      case "608":
      case "609":
      case "611":
        show_notification("error",response.message,4000);
        break;
      default:
        show_notification("error","Unknow error. Please contact with us.",4000);
        break;
    }
  });
}

function questionnaireTimeCompleted() {
  $("#play-questionnaire").modal("toggle");
  HoldOn.open({
     theme:"sk-cube-grid",
     message: "<br><div class='col-xs-12' style='font-size:16px'>Questionnaire time expired. We will redirect you, to your questionnaires page."
  });
  setTimeout(function() {
    window.location.replace(my_questionnaires_page);
  },10000);
}

function questionGroupTimeExpired(target)
{
  $("#play-questionnaire").modal("toggle");
  groups[target]["is-completed"] = 1;
  groups[target]["time-left"] = 0;

  var id = groups[target].id;
  //check if question group completed
  if(groups[target]["is-completed"] == true)
  {
    $("#play" + id).val("Completed")
                   .prop('disabled',true);
  }
}

function questionTimeExpired()
{
  if($("#play-questionnaire").hasClass('in') && $("input[name='optradio']:checked").length == 1)
  {
    $("#confirm-answer-button").trigger("click");
  }
  else if($("#play-questionnaire").hasClass('in')){
    $("#confirm-answer-button").html("Continue")
                               .attr("onclick","playQuestionGroup(" + target_group_index + ")");
  }
}
