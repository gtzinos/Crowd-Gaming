var groups = [];
var current_client_position;
var auto_refresh; //auto refresh time out refference
var target_group_index;
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
     show_clock("#count-down",moment().add(time_left,'minutes').format("YYYY/MM/DD HH:mm:00"));
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
             show_notification("error","User denied the request for Geolocation.",2000);
             break;
         case error.POSITION_UNAVAILABLE:
             show_notification("error","Location information is unavailable.",2000);
             break;
         case error.TIMEOUT:
             show_notification("error","The request to get user location timed out.",2000);
             break;
         case error.UNKNOWN_ERROR:
             show_notification("error","An unknown error occurred.",2000);
             break;
     }
     setTimeout(function() {
      window.location.replace(webRoot);
    },2000);
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
     distance = calculateDistance(i);
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
      groups = data["question-group"];
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
            if(groups[groups.length-1]["address"] != undefined)
            {
              displayData();
            }
          }
        });
     })(i);
  }
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
                        "<div class='panel-body'>" +
                          "<div>Answered " +
                            "<span id='answered" + groups[i].id + "'>" + groups[i]["answered-questions"] + "</span>" +
                            "/" +
                            "<span id='total-questions" + groups[i].id + "'>" + groups[i]["total-questions"] + "</span>" +
                          "</div>";
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
                            out += "<span style='color:red'>No address<span>";
                          }
                          out += "<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>";
                          //Questio group completed
                          if(groups[i]["answered-questions"] == groups[i]["total-questions"])
                          {
                            out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' disabled value='Completed'> ";
                          }
                          //Question group not completed
                          else {
                            if(calculateDistance(i) == 0)
                            {
                              out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' value='Play now' onclick='playQuestionGroup(" + i + ")'>";
                            }
                            else {
                              out += "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' value='Play now' disabled>";
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
        show_clock("#question-count-down",moment().add(data.question['time-to-answer'],'second').format("YYYY/MM/DD HH:mm:ss"),"","Your time expired",false);
      }
    },
    error: function(xhr, status, error) {
        var code = JSON.parse(xhr.responseText).code;
        if(code == "603")
        {
          show_notification("error","Forbidden. Questionnaire is offline.",3000);
        }
        else if(code == "604")
        {
          show_notification("error","Forbidden. You dont have access to that questionnaire.",3000);
        }
        else if(code == "606")
        {
          show_notification("error","Forbidden. Coordinates not provided.",3000);
        }
        else if(code == "607")
        {
          show_notification("error","Forbidden. Invalid location or user not in participation group.",3000);
        }
        else if(code == "608")
        {
          show_notification("error","Forbidden. Group doesnt exist or doesnt belong to questionnaire.",3000);
        }
        else if(code == "609")
        {
          show_notification("warning","Question Group doesnt have any questions.",3000);
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
          show_clock("#question-count-down",moment().add(data.question['time-to-answer'],'second').format("YYYY/MM/DD HH:mm:ss"),"","Your time expired",false);
        }
      },
      error: function(xhr, status, error) {
        var code = JSON.parse(xhr.responseText).code;
        if(code == "603")
        {
          show_notification("error","Forbidden. Questionnaire is offline.",3000);
        }
        else if(code == "604")
        {
          show_notification("error","Forbidden. You dont have access to that questionnaire.",3000);
        }
        else if(code == "606")
        {
          show_notification("error","Forbidden. Coordinates not provided.",3000);
        }
        else if(code == "607")
        {
          show_notification("error","Forbidden. Invalid location or user not in participation group.",3000);
        }
        else if(code == "608")
        {
          show_notification("error","Forbidden. Group doesnt exist or doesnt belong to questionnaire.",3000);
        }
        else if(code == "609")
        {
          show_notification("warning","Question Group doesnt have any questions.",3000);
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
    data: JSON.stringify(data),
    success: function(data)
    {
      /*
        200 : Everything ok.
        603 : Forbidden, Questionnaire offline
        605 : Forbidden, You cant answer this question
        606 : Forbidden, Coordinates not provided.
        607 : Forbidden, Invalid location or user not in participation group.
        500 : Internal server error.
        610 : Invalid Request, question-id and/or answer-id were not given
      */
      if(data.code == "200")
      {
        $('#question-count-down').countdown('stop');
        show_notification("success","Question anwsered successfully.",3000);
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
      }
    },
    error: function(xhr, status, error) {
      var code = JSON.parse(xhr.responseText).code;
      if(data.code == "603")
      {
        show_notification("error","Forbidden, Questionnaire is offline",3000);
      }
      else if(data.code == "605")
      {
        show_notification("error","Forbidden, You cant answer this question",3000);
      }
      else if(data.code == "606")
      {
        show_notification("error","Forbidden, Coordinates not provided.",3000);
      }
      else if(data.code == "607")
      {
        show_notification("error","Forbidden, Invalid location or user not in participation group.",3000);
      }
      else if(data.code == "500")
      {
        show_notification("error","Internal server error.",3000);
      }
      else if(data.code == "610")
      {
        show_notification("error","Invalid Request, question-id and/or answer-id were not given.",3000);
      }
      else
      {
        show_notification("error","Unknow error. Please contact with us.",3000);
      }
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
  //check if question group completed
  if(answered == total_questions)
  {
    $("#play" + id).val("Completed")
                   .prop('disabled',true);
  }
}

//return true if game completed
function completed() {
  return $("input[id^=play][disabled]").length == $("input[id^=play]").length;
}
