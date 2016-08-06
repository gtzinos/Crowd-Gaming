var all_requests_array = [],
    request_offset = 0,
    request_limit = 10;

$(window).on('load',function(){
  getParticipationRequests();
});

var iScrollPos = 0,
    processing = false;
$(window).scroll(function () {
    var iCurScrollPos = $(this).scrollTop();
    if (iCurScrollPos > iScrollPos) {
      if (processing)
      {
        //request_offset += request_limit;
        return false;
      }
      if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.8){
          processing = true; //sets a processing AJAX request flag
          if(request_offset != 0)
          {
            getParticipationRequests();
          }
      }
    }
    iScrollPos = iCurScrollPos;
  });

function getParticipationRequests()
{
  $.post(webRoot + "get-questionnaire-requests",
  {
    offset : request_offset,
    limit : request_limit
  },
  function(data,status)
  {
    if(status == "success")
    {
      /*
        0 : All ok
        1 : Invalid Access
      */
      if(data.requests.length > 0)
      {
          var counter = 0,
              i;

          var out = "",
              types = { 1 : { 'type' : 'Player', 'color' : '#30ADFF' }, 2 : { 'type' : 'Examiner' , 'color' : 'orange'}};

          out = "";
          counter = all_requests_array.length;
          for(i = 0; i < data.requests.length; i++)
          {
            all_requests_array[counter] = data.requests[i];

            out += "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' style='margin-top:1.5%;border: 2px solid " + types[data.requests[i]['request_type']]['color'] + "' id='ritem" + data.requests[i]['request_id'] + "'>" +
                      "<div class='row'>" +
                        "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                            "<div style='font-size:15px' class='list-group-item-heading'>" + data.requests[i]['request_date'].split(" ")[0] + "</div>" +
                        "</div>" +
                          "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                              "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + user_page + "/" + data.requests[i]['user_id'] + "' style='color:black' target='_blank'>" + data.requests[i]['user_name'] + " " + data.requests[i]['user_surname'] + "</a></div>" +
                          "</div>" +
                          "<div class='hidden-xs col-sm-offset-2 col-sm-3 col-md-2'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + data.requests[i]['request_date'].split(" ")[0] + "</div>" +
                          "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                        "<div class='col-xs-12'>" +
                            "<div style='font-size:17px' > Type: <span style='color:" + types[data.requests[i]['request_type']]['color'] + "'>" + types[data.requests[i]['request_type']]['type'] + "</span></div>" +
                        "</div>" +
                        "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                            "<div style='font-size:17px' > Game: <a class='user_name' target='_blank' href='" + questionnaire_page + "/" + data.requests[i]['questionnaire_id'] + "' style='color:black'>" + data.requests[i]['questionnaire_name'] + "</a></div>" +
                        "</div>" +
                          "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-4 col-sm-3 col-md-2'>" +
                            "<button type='button' class='btn btn-success' onclick=\"handleQuestionnaireParticipationRequest(" + data.requests[i]['request_id'] + ",'accept'," + (counter) + ")\"><span class='fa fa-check'></span></button> " +
                            "<button type='button' class='btn btn-danger' onclick=\"handleQuestionnaireParticipationRequest(" + data.requests[i]['request_id'] + ",'decline'," + (counter) + ")\"><span class='fi-x'></span></button>" +
                          "</div>" +
                      "</div>" +
                  "</div>";
                  counter ++;
          }
        }
        else if(request_offset == 0) {
          out = "<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                      "<div class='col-xs-12'>" +
                          "<div class='alert alert-danger text-center'>We don't have any participation request in our database. </div>" +
                      "</div>" +
                  "</a>";
        }

        request_offset += request_limit;
        $("#participation-requests-list").append(out);
        processing = false;
    }
  });
}

function handleQuestionnaireParticipationRequest(request_id,response,request_index)
{
  $.post(webRoot + "handle-questionnaire-request",
  {
    'request-id' : request_id,
    'response' : response //"accept" or "decline"
  },
  function(data,status)
  {
    if(status == "success")
    {
      /*
        0 : All ok
        1 : Request does not exists
        2 : You can only handle player or examiner requests.
        3 : You dont have access to this questionnaire
        4 : response must be either "accept" or "decline"
        5 : Response already handled
        6 : General Database Error
        -1 : No data
      */
      var fullName = all_requests_array[request_index]['user_name'] + " " + all_requests_array[request_index]['user_surname'];
      if(data == "0")
      {
        if(response == "accept") {
          show_notification("success",fullName + " participation request was accepted successfully.",3000);
        }
        else if(response == "decline")
        {
          show_notification("success",fullName + " participation request was declined successfully.",3000);
        }
        $("#ritem" + request_id).remove();
        if($("[id^=ritem]").length == 0)
        {
          $("#participation-requests-list").html("<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                                                    "<div class='col-xs-12'>" +
                                                        "<div class='alert alert-danger text-center'>We don't have any participation request in our database. </div>" +
                                                    "</div>" +
                                                "</a>");
        }
      }
      else if(data == "1")
      {
        show_notification("error","Request does not exists. (" + fullName + ")",4000);
      }
      else if(data == "2")
      {
        show_notification("error","You can only handle player or examiner requests. (" + fullName + ")",4000);
      }
      else if(data == "3")
      {
        show_notification("error","You dont have access to this questionnaire. (" + fullName + ")",4000);
      }
      else if(data == "4")
      {
        show_notification("error","Response must be either 'accept' or 'decline'. (" + fullName + ")",4000);
      }
      else if(data == "5")
      {
        show_notification("error","Response was already handled.(" + fullName + ")",4000);
      }else if(data == "6")
      {
        show_notification("error","General Database Error. (" + fullName + ")",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send any data. (" + fullName + ")",4000);
      }
    }
  });
}
