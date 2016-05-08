var requests_array = [];

$(window).on('load',function()
{
  getExaminerApplications();
});

function getExaminerApplications()
{
  $.post(webRoot + "get-examiner-applications",
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
      if(data.applications.length > 0)
      {
          var i = 0,
              out = "";
          requests_array = data.applications;

          for(i = 0; i < requests_array.length; i++)
          {
            out += "<div style='margin-top:1.5%;border : 1.7px solid #008080' class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='ritem" + requests_array[i]['request-id'] + "'>" +
                      "<div class='row'>" +
                          "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + requests_array[i]['request-date'].split(" ")[0] + "</div>" +
                          "</div>" +
                          "<div class='col-xs-12 col-sm-7 col-md-8''>" +
                              "<h4 class='list-group-item-heading'><a href='" + user_page + "/" + requests_array[i]['user-id'] + "' target='_blank'>" + requests_array[i]['user-name'] + " " +  requests_array[i]['user-surname'] + "</a></h4>" +
                          "</div>" +
                          "<div class='hidden-xs col-sm-offset-1 col-sm-3 col-md-2'>" +
                              "<div style='font-size:15px' class='list-group-item-heading'>" + requests_array[i]['request-date'].split(" ")[0] + "</div>" +
                          "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                        "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                            "<h5 class='list-group-item-heading'>Message: " + requests_array[i]['request-message'] + "</h5>" +
                        "</div>" +
                        "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-3 col-sm-3 col-md-2'>" +
                            "<button type='button' class='btn btn-success' onclick=\"handleExaminerApplication(" + requests_array[i]['request-id'] + ",'accept'," + i + ")\"><span class='fa fa-check'></span></button> " +
                            "<button type='button' class='btn btn-danger' onclick=\"handleExaminerApplication(" + requests_array[i]['request-id'] + ",'decline'," + i + ")\"><span class='fi-x'></span></button>" +
                        "</div>" +
                      "</div>" +
                  "</div>";
                $("#examiner-applications-list").append(out);
          }
        }
        else
        {
          out = "<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                      "<div class='col-xs-12'>" +
                          "<div class='alert alert-danger text-center'>We don't have any examiner application in our database. </div>" +
                      "</div>" +
                  "</a>";
          $("#examiner-applications-list").append(out);
        }
    }
  });

}

function handleExaminerApplication(request_id,response,request_index)
{
  $.post(webRoot + "handle-examiner-application",
  {
    'application-id' : request_id,
    'response' : response
  },
  function(data,status)
  {
    if(status == "success")
    {
      var fullName = requests_array[request_index]['user-name'] + " " + requests_array[request_index]['user-surname'];
      if(data == "0")
      {
        if(response == "accept") {
          show_notification("success", + " examiner request accepted successfully.",3000);
        }
        else
        {
          show_notification("success",fullName + " request declined successfully.",3000);
        }
        $("#ritem" + request_id).remove();
        if($("[id~=ritem]").length == 0)
        {
          $("#publication-requests-list").html("<a class='col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                                                    "<div class='col-xs-12'>" +
                                                        "<div class='alert alert-danger text-center'>We don't have any examiner application in our database. </div>" +
                                                    "</div>" +
                                                "</a>");
        }
      }
      else if(data == "1")
      {
        show_notification("error","Application does not exists. (" + fullName + ")",4000);
      }
      else if(data == "2")
      {
        show_notification("error","You can only handle publish requests. (" + fullName + ")",4000);
      }
      else if(data == "3")
      {
        show_notification("error","Response can be either 'accept' or 'decline'. (" + fullName + ")",4000);
      }
      else if(data == "4")
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
