var groups = [];
var client_longitude;
var client_latitude;
$(window).on("load",function()
 {
     getGeoLocation();

 });

 function getGeoLocation() {
     if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(showPosition, showError);
     } else {
         window.location.replace(webRoot);
     }
 }

 function showPosition(position) {
     client_longitude = position.coords.longitude;
     client_latitude = position.coords.latitude;
     show_clock("#count-down",moment().add(1441,'minutes').format("YYYY/MM/DD hh:mm:ss"));
     getQuestionGroups();
 }

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

function displayData()
{
  out = "";
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
                                "<div id='distance'>" +
                                      "Distance: " + calculateDistance(i) + "m <span style='color:#36A0FF' class='fa fa-refresh'></span>" +
                                "</div>"
                              : //else
                                "<span style='color:red'>No address<span>") +
                          "<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>" +
                              "<button class='btn btn-primary round' type='button' " +
                                (groups[i]["answered-questions"] == groups[i]["total-questions"] ? " disabled>Completed" : ">Play now") +
                              "</button>"+
                          "</div>" +
                      "</div>" +
                  "</div>" +
                "</div>";

    })(i);
    $("#accordion").html(out);
  }
}

function calculateDistance(i)
{
    /** Converts numeric degrees to radians */
  if (typeof(Number.prototype.toRad) === "undefined") {
    Number.prototype.toRad = function() {
      return this * Math.PI / 180;
    }
  }
  var R = groups[i]["radius"]; // km
  var dLat = (groups[i]["latitude"]-client_latitude).toRad();
  var dLon = (groups[i]["longitude"]-client_longitude).toRad();
  var lat1 = groups[i]["latitude"].toRad();
  var lat2 = client_latitude.toRad();

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c;
  return d;
}
