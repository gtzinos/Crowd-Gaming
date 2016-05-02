<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<style>
.modal:nth-of-type(even) {
    z-index: 1042 !important;
}
.modal-backdrop.in:nth-of-type(even) {
    z-index: 1041 !important;
}

</style>
<body>
  <script>

  function handle_questionnaire_request(request_id,response)
  {
      $.post(webRoot + "handle_questionnaire_request")
      {
        'request-id' : request_id,
        'response' : response
      }
      function(data,status)
      {
        if(data == "0")
        {
          show_notification("success","Questionnaire request handled successfully.",3000);
        }
        else if(data == "1")
        {
          show_notification("error","Request does not exists.",4000);
        }
        else if(data == "2")
        {
          show_notification("error","You can only handle, player or examiner requests.",4000);
        }
        else if(data == "3")
        {
          show_notification("error","You dont have access to this questionnaire.",4000);
        }
        else if(data == "4")
        {
          show_notification("error","Questionnaire must be either accept or decline.",4000);
        }
        else if(data == "5")
        {
          show_notification("error","Response already handled.",4000);
        }
        else if(data == "6")
        {
          show_notification("error","General database error.",4000);
        }
        else if(data == "-1")
        {
          show_notification("error","You didn't send data.",4000);
        }
      }
    }

    function handle_questionnaire_public_request(request_id,response)
    {
      $.post(webRoot + "handle-questionnaire-public-request")
      {
        'request-id' : request_id,
        'response' : response
      }
      function(data,status)
      {
        if(data == "0")
        {
          show_notification("success","Questionnaire publish handled successfully.",3000);
        }
        else if(data == "1")
        {
          show_notification("error","Request does not exists.",4000);
        }
        else if(data == "2")
        {
          show_notification("error","You can only handle publish requests.",4000);
        }
        else if(data == "3")
        {
          show_notification("error","You dont have access to this questionnaire.",4000);
        }
        else if(data == "4")
        {
          show_notification("error","Questionnaire must be either accept or decline.",4000);
        }
        else if(data == "5")
        {
          show_notification("error","Response already handled.",4000);
        }
        else if(data == "6")
        {
          show_notification("error","General database error.",4000);
        }
        else if(data == "-1")
        {
          show_notification("error","You didn't send data.",4000);
        }
      }
    }

    function handle_examiner_application(application_id,response)
    {
      $.post(webRoot + "handle-examiner-application")
      {
        'application-id' : application_id,
        'response' : response
      }
      function(data,status)
      {
        if(data == "0")
        {
          show_notification("success","Examiner application handled successfully.",3000);
        }
        else if(data == "1")
        {
          show_notification("error","Application does not exists.",4000);
        }
        else if(data == "2")
        {
          show_notification("error","Application already handled.",4000);
        }
        else if(data == "3")
        {
          show_notification("error","Response must be either accept or decline.",4000);
        }
        else if(data == "4")
        {
          show_notification("error","General database error.",4000);
        }
        else if(data == "-1")
        {
          show_notification("error","You didn't send data.",4000);
        }
      }
    }

    

  </script>
</body>
</html>
