$("#editor")
/*
  Create questionnaire
*/
function createQuestionnaire()
{
  /*
    Initialize variables
  */
  var name = $("#questionnaire-name").val();
  var descriptionHTML = tinymce.activeEditor.getContent();
  var descriptionClearText = tinymce.activeEditor.getContent({format : 'text'});
  var message_required = $("#message-required").val();

  if(name && descriptionClearText.length >= 31)
  {
    var Required = {
        Url() { return webRoot + "questionnaire-create/ajax"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "name=" + name + "&description=" +  descriptionHTML;

          if(message_required == "-") {
              message_required = "no";
          }
          
          this.variables .= "&message_required=" + message_required;

          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "responseCreateQuestionnaire"; },
        ResponseLabel() { return "questionnaire-create-response"; },
        SubmitButton() { return ".submit"; }
      };

      /*
				Send ajax request
			*/
			sendAjaxRequest(Required,Optional);
    }

  else {
    /*
      Cannot be empty
    */
    $("#questionnaire-create-response").show();
    $("#questionnaire-create-response").html("<div class='alert alert-danger'>Questionnaire name and description cannot be empty. </div>");

  }

}

/*
  Response method Create Questionnaire
*/
function responseCreateQuestionnaire()
{
  /*
		if Server responsed back successfully
	*/
	if (xmlHttp.readyState == 4) {
		if (xmlHttp.status == 200) {
      /*
        0			: Created successfully
        1			: Name Validation error
        2			: Description Validation error
        3			: Message Required Error
        4			: Database Error
      */

			/*
				Debug
			*/
			//console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
			{
  			/*
  				After response submit button must be enabled
  			*/
  			$(document).find('.submit').prop('disabled',false);
  			/*
  				Success message
        */
         $("#questionnaire-create-response").show();
         $("#questionnaire-create-response").html("<div class='alert alert-success'>Your questionnaire created successfully.</div>");
			}

      /*
        If server responsed with an error code
      */
      else {
        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
           Name Validation error
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid questionnaire name.</div>";
        }
        /*
           If response message == 2
           Description Validation error
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid questionnaire description.</div>";
        }
        /*
           If response message == 3
           Message Required Error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid message required option.</div>";
        }
        /*
           If response message == 4
           Database Error
        */
        else if(xmlHttp.responseText.localeCompare("4") == 0)
        {
         response_message += "<div class='alert alert-danger'>General database error. Please try later!</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Something going wrong. Contact with one administrator!</div>";
        }



       $("#questionnaire-create-response").show();
       $("#questionnaire-create-response").html(xmlHttp.responseText);
      }
    }
  }
}
