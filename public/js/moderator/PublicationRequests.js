var questionnaire_id;

getPublicationRequests();

function getPublicationRequests()
{


  $.post(webRoot + "get-publish-requests",
  {
  },
  function(data,status)
  {
    if(status == "success")
    {
      console.log(JSON.stringify(data));
      /*
        0 : All ok
        1 : Invalid Access
      */
      var i = 0,
          out = "",
          requests = data.requests;

      if(requests.length > 0)
      {
          for(i = 0; i < requests.length; i++)
          {
            out += "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='ritem" + requests[i]['request-id'] + "'>" +
                      "<div class='col-xs-12'>" +
                          "<div class='col-xs-12'>" +
                              "<h4 class='list-group-item-heading'><a href='' target='_blank'>" + requests[i]['questionnaire-name'] + "</a></h4>" +
                          "</div>" +
                      "</div>" +
                      "<div class='col-xs-12'>" +
                        "<div class='col-xs-7'>" +
                            "<h5 class='list-group-item-heading'>By : <a target='_blank'>" + requests[i]['user-name'] + " " + requests[i]['user-surname'] + "</a> (" + requests[i]['request-date'] + ")</h5>" +
                        "</div>" +
                          "<div class='col-xs-3 col-sm-offset-2 col-sm-3 col-md-2'>" +
                            "<div class='dropdown'>" +
                                "<span class='dropdown-toggle btn btn-default' type='button' data-toggle='dropdown'>Actions" +
                                "<span class='caret'></span></span>" +
                                "<ul class='dropdown-menu' >" +
                                  "<li class='actionli'><a onclick=\"handleQuestionnairePublicRequest(" + requests[i]['request-id'] + ",'accept')\"><i class='fa fa-thumbs-o-up' ></i> Accept</a></li>" +
                                  "<li class='actionli'><a onclick=\"handleQuestionnairePublicRequest(" + requests[i]['request-id'] + ",'decline'); return false;\"><i class='fa fa-thumbs-o-down'></i> Decline</a></li>" +
                                "</ul>" +
                            "</div>" +
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


function handleQuestionnairePublicRequest(request_id,response)
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
          show_notification("success","Questionnaire published successfully.",3000);
        }
        else
        {
          show_notification("success","Questionnaire public request declined successfully.",3000);
        }
        $("#ritem" + request_id).remove();
        if($("[id~=ritem]").length == 0)
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
        show_notification("error","Request does not exists.",4000);
      }
      else if(data == "2")
      {
        show_notification("error","You can only handle publish requests.",4000);
      }
      else if(data == "4")
      {
        show_notification("error","Response must either 'accept' or 'decline'.",4000);
      }
      else if(data == "5")
      {
        show_notification("error","Response already handled.",4000);
      }
      else if(data == "6")
      {
        show_notification("error","General Database Error.",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data.",4000);
      }
    }
  });
}
