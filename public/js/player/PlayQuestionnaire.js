var groups = [];
var client_longitude;
var client_latitude;
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
       window.location.replace(webRoot);
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
     show_clock("#count-down",moment().add(time_left,'minutes').format("YYYY/MM/DD hh:mm:ss"));
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
   client_longitude = position.coords.longitude;
   client_latitude = position.coords.latitude;
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
       else {
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
     show_notification("success",groups[target_group_index].name + " distance updated successfully",3000);
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
      else {
        $("#play" + groups[target_group_index].id).prop("disabled",false);
      }
    }
    return true;
  }

 //save user location
 function savePlayerLocation(position)
 {
   client_longitude = position.coords.longitude;
   client_latitude = position.coords.latitude;
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
    (function(i)
    {
        /*
          Get real address name
          #URL : https://maps.googleapis.com/maps/api/geocode/json?address={*latitude,*longitude}

          #No Parameters
        */

        $.post("https://maps.googleapis.com/maps/api/geocode/json?address="+ (groups[i]["latitude"] != null ? groups[i]["latitude"] + ","  : "")  + (groups[i]["longitude"] != null ? groups[i]["longitude"] : ""),
        {

        },
        function(data,status)
        {
            groups[i]["address"] = data["results"][0] != undefined ? data["results"][0]["formatted_address"] : "";
            if(groups[groups.length-1]["address"] != undefined)
            {
              displayData();
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
                            groups[i]["answered-questions"] + "/" + groups[i]["total-questions"] +
                          "</div>" +
                          (groups[i]["address"]
                              ? //if true (groups[i]["address"] != undefined
                                "<div id='location'>" +
                                    "<a href='https://www.google.com/maps/dir//" + groups[i]["latitude"] + "," + groups[i]["longitude"] + "' target='_blank'><span class='fi-map' style='font-size:20px'></span> " + groups[i]["address"] + "</a>" +
                                "</div>" +
                                "<div>" +
                                      "<span id='distance" + groups[i].id + "'>Distance: " + calculateDistance(i) + "m </span><span style='color:#36A0FF' class='fa fa-refresh' onclick='target_group_index = " + i + "; navigator.geolocation.getCurrentPosition(refreshASpecificGroup, showError);'></span>" +
                                "</div>"
                              : //else
                                "<span style='color:red'>No address<span>") +
                          "<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>" +
                              "<input id='play" + groups[i].id + "' class='btn btn-primary round' type='button' " +
                                (groups[i]["answered-questions"] == groups[i]["total-questions"] ? " disabled value='Completed'>" : "value='Play now' onclick='playQuestionGroup(" + i + ")'>") +
                              "</button>"+
                          "</div>" +
                      "</div>" +
                  "</div>" +
                "</div>";

    })(i);

  }
      $("#accordion").html(out);
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
  var R = 6371000; // m
  var dLat = (groups[i]["latitude"]-client_latitude).toRad();
  var dLon = (groups[i]["longitude"]-client_longitude).toRad();
  var lat1 = groups[i]["latitude"].toRad();
  var lat2 = client_latitude.toRad();

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c;

  if(d-groups[i] >= 0)
  {
    d = d - groups[i].radius;
  }
  return d.toFixed(2);
}

//try to get client geolocation
function playQuestionGroup(target)
{
  target_group_index = target;
  navigator.geolocation.getCurrentPosition(getNextQuestion, showError);
}

//try to get questions
function getNextQuestion(position)
{
  $.when(refreshASpecificGroup(position)).done(function() {
    $.post(webRoot +
            "rest_api/questionnaire/" +
            questionnaire_id + "/group/" +
            groups[target_group_index].id + "/question/" +
            groups[target_group_index].latitude + ";" + groups[target_group_index].longitude,
    {
    },
    function(data,status)
    {
      if(status == "success")
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
          								 "<button type='button' class='btn btn-primary btn-md' onclick='confirmAnwser(" + data.question.id + ")'>Confirm</button>" +
          							 "</div>" +
          							 "<div class='col-xs-3 col-sm-2'>" +
          								 "<button type='button' class='btn btn-primary btn-md' data-dismiss='modal' >" +
          									 "Cancel" +
          								 "</button>" +
          							 "</div>" +
          				"</div>";
          $("#play-questionnaire-form").html(out);
          //answer_countdown = data.question['time-to-answer'];
          show_clock("#question-count-down",moment().add(data.question['time-to-answer'],'second').format("YYYY/MM/DD hh:mm:ss"));
        }
        else if(data.code == "603")
        {
          show_notification("Forbidden. Questionnaire is offline.");
        }
        else if(data.code == "604")
        {
          show_notification("Forbidden. You dont have access to that questionnaire.");
        }
        else if(data.code == "606")
        {
          show_notification("Forbidden. Coordinates not provided.");
        }
        else if(data.code == "607")
        {
          show_notification("Forbidden. Invalid location or user not in participation group.");
        }
        else if(data.code == "608")
        {
          show_notification("Forbidden. Group doesnt not exist or doesnt belong to questionnaire.");
        }
        else if(data.code == "609")
        {
          show_notification("Forbidden. Question Group doesnt have any more questions.");
          navigator.geolocation.getCurrentPosition(refreshASpecificGroup, showError);
          $("#play-questionnaire").modal("toggle");
        }
      }
    });
  });
}

function confirmAnwser(question_id)
{
  var selected_answer_id = $("input[name='optradio']:checked").val();
  let data =
  {
    'question-id' : question_id,
    'answer-id' : selected_answer_id,
    'time-answered' : 5
  };
  $.ajax({
    method: "POST",
    url: webRoot + "rest_api/answer",
    headers: {
        "X-Coordinates": groups[target_group_index].latitude + ";" + groups[target_group_index].longitude
    },
    data: data,
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
        show_notification("success","Question anwsered successfully.",3000);
        playQuestionGroup(target_group_index);
      }
      else if(data.code == "603")
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
