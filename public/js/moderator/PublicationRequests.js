var requests_array = [];

$(window).on('load',function()
{
  getPublicationRequests();
});

function getPublicationRequests()
{
  $.post(webRoot + "get-publish-requests",
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
              out = "";
          requests_array = data.requests;
          for(i = 0; i < requests_array.length; i++)
          {
            out += "<div style='margin-top:1.5%;border : 1.7px solid #008080' class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='ritem" + requests_array[i]['request-id'] + "'>" +
                      "<div class='row'>" +
                          "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + requests_array[i]['request-date'].split(" ")[0] + "</div>" +
                          "</div>" +
                          "<div class='col-xs-12 col-sm-7 col-md-8''>" +
                              "<h4 class='list-group-item-heading'><a href='" + questionnaire_page + "/" + requests_array[i]['questionnaire-id'] + "' target='_blank'>" + requests_array[i]['questionnaire-name'] + "</a></h4>" +
                          "</div>" +
                          "<div class='hidden-xs col-sm-offset-1 col-sm-3 col-md-2'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + requests_array[i]['request-date'].split(" ")[0] + "</div>" +
                          "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                        "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                            "<h5 class='list-group-item-heading'>Reason: " + requests_array[i]['request-text'] + "</h5>" +
                        "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                        "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                            "<h5 class='list-group-item-heading'>By: <a target='_blank' style='color:black' href='" + user_page + "/" + requests_array[i]['user-id'] + "'>" + requests_array[i]['user-name'] + " " + requests_array[i]['user-surname'] + "</a></h5>" +
                        "</div>" +
                        "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-3 col-sm-3 col-md-2'>" +
                            "<button type='button' class='btn btn-success' onclick=\"handleQuestionnairePublicRequest(" + requests_array[i]['request-id'] + ",'accept'," + i + ")\"><span class='fa fa-check'></span></button> " +
                            "<button type='button' class='btn btn-danger' onclick=\"handleQuestionnairePublicRequest(" + requests_array[i]['request-id'] + ",'decline'," + i + ")\"><span class='fi-x'></span></button>" +
                        "</div>" +
                      "</div>" +
                  "</div>";
          }
        }
        else
        {
          out = "<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                      "<div class='col-xs-12'>" +
                          "<div class='alert alert-danger text-center'>We don't have any publication request in our database. </div>" +
                      "</div>" +
                  "</a>";
        }
      $("#publication-requests-list").append(out);
    }
  });

}

function handleQuestionnairePublicRequest(request_id,response,request_index)
{
  $.post(webRoot + "handle-questionnaire-public-request",
  {
    'request-id' : request_id,
    'response' : response
  },
  function(data,status)
  {
    if(status == "success")
    {
      if(data == "0")
      {
        if(response == "accept") {
          show_notification("success",requests_array[request_index]['questionnaire-name'] + " was published successfully.",3000);
        }
        else
        {
          show_notification("success",requests_array[request_index]['questionnaire-name'] + " request was declined successfully.",3000);
        }
        $("#ritem" + request_id).remove();
        if($("[id^=ritem]").length == 0)
        {
          $("#publication-requests-list").html("<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                                                    "<div class='col-xs-12'>" +
                                                        "<div class='alert alert-danger text-center'>We don't have any publication request in our database. </div>" +
                                                    "</div>" +
                                                "</a>");
        }
      }
      else if(data == "1")
      {
        show_notification("error","Request does not exists. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
      else if(data == "2")
      {
        show_notification("error","You can only handle publication requests. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
      else if(data == "4")
      {
        show_notification("error","Response must either 'accept' or 'decline'. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
      else if(data == "5")
      {
        show_notification("error","Response was already handled. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
      else if(data == "6")
      {
        show_notification("error","General Database Error. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send any data. (" + requests_array[request_index]['questionnaire-name'] + ")",4000);
      }
    }
  });
}
