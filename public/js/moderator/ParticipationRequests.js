var questionnaire_id,
    requests = [];

$(window).on('load',function(){
  getParticipationRequests();
});

function getParticipationRequests()
{
  $.post(webRoot + "get-questionnaire-requests",
  {
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
          var i = 0,
              out = "",
              types = { 1 : { 'type' : 'Player', 'color' : '#30ADFF' }, 2 : { 'type' : 'Examiner' , 'color' : 'orange'}};

          requests = data.requests;
          for(i = 0; i < requests.length; i++)
          {
            out += "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' style='border: 2px solid " + types[requests[i]['request-type']]['color'] + "' id='ritem" + requests[i]['request-id'] + "'>" +
                      "<div class='row'>" +
                        "<div class='visible-xs col-xs-offset-7 col-xs-3'>" +
                            "<div style='font-size:15px' class='list-group-item-heading'>" + requests[i]['request-date'] + "</div>" +
                        "</div>" +
                          "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                              "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' style='color:black' target='_blank'>" + requests[i]['user-name'] + " " + requests['user-surname'] + "</a></div>" +
                          "</div>" +
                          "<div class='hidden-xs col-sm-offset-2 col-sm-2'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + requests[i]['request-date'] + "</div>" +
                          "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                        "<div class='col-xs-12'>" +
                            "<div style='font-size:17px' > Type: <span style='color:" + types[requests[i]['request-type']]['color'] + "'>" + types[requests[i]['request-type']]['type'] + "</span></div>" +
                        "</div>" +
                        "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                            "<div style='font-size:17px' > Game: <a class='user_name' style='color:black'>" + requests[i]['questionnaire-id'] + "</a></div>" +
                        "</div>" +
                          "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-4 col-sm-3 col-md-2'>" +
                            "<button type='button' class='btn btn-success' onclick=\"handleQuestionnaireParticipationRequest(" + requests[i]['request-id'] + ",'accept'," + i + ")\"><span class='fa fa-check'></span></button> " +
                            "<button type='button' class='btn btn-danger' onclick=\"handleQuestionnaireParticipationRequest(" + requests[i]['request-id'] + ",'decline'," + i + ")\"><span class='fi-x'></span></button>" +
                          "</div>" +
                      "</div>" +
                  "</div>";
          }
        }
        else {
          out = "<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                      "<div class='col-xs-12'>" +
                          "<div class='alert alert-danger text-center'>We don't have any participation request in our database. </div>" +
                      "</div>" +
                  "</a>";
        }
      $("#participation-requests-list").append(out);
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
      var fullName = requests[request_index]['user-name'] + " " + requests[request_index]['user-surname'];
      if(data == "0")
      {
        if(response == "accept") {
          show_notification("success",fullName + " participation request accepted successfully.",3000);
        }
        else if(response == "decline")
        {
          show_notification("success",fullName + " participation request declined successfully.",3000);
        }
        $("#ritem" + request_id).remove();
        if($("[id~=ritem]").length == 0)
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
        show_notification("error","Response already handled. (" + fullName + ")",4000);
      }else if(data == "6")
      {
        show_notification("error","General Database Error. (" + fullName + ")",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data. (" + fullName + ")",4000);
      }
    }
  });
}
