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

          this.variables += "&message_required=" + message_required;

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
      }
    }
  }
}

/*
  Update one questionnaire
*/
function updateQuestionnaire(id)
{
  /*
    Initialize the variables
  */
  var name = $(document).find("#qname").val();
  var description = $(document).find("#qeditor").val();
  var required = $(document).find("#mrequired").val();

  /*
    Check the Variables before sending them
  */
  if(name && description && required)
  {
    var Required = {
        Url() { return webRoot + "questionnaire-edit/" + id; },
        SendType() { return "POST"; },
        Parameters() {
          return "name=" + name + "&description=" + description + "&message_required=" + required;
        }
    };
    var Optional = {
      ResponseMethod() { return "responseUpdateQuestionnaire"; },
      ResponseLabel() { return "questionnaire-edit-response"; },
      SubmitButton() { return "edit-questionnaire"; }
    };
    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);

  }
  else
  {
    /*
      Response failed recovery message
    */
    $("#questionnaire-edit-response").show();
    $("#questionnaire-edit-response").html("<div class='alert alert-danger'>Empty fields !!!</div>");
  }
}

/*
  Responsed method (Update Questionnaire)
*/
function responseUpdateQuestionnaire()
{
  /*
    Response code values
    0			: Edited successfully
    1			: Name Validation error
    2			: Description Validation error
    3			: Message Required Error
    4			: Database Error
   */
   /*
 		if Server responsed successfully
 	*/
 	if (xmlHttp.readyState == 4) {
 		if (xmlHttp.status == 200) {
 			/*
 				Debug
 			*/

 			//console.log(xmlHttp.responseText);

 			/*
 			  Enable submit button
 			*/

 			$(document).find('#edit-questionnaire').prop('disabled',false);
 			/*
 				User can login
 			*/
 			if(xmlHttp.responseText.localeCompare("0") == 0)
 			{
 				/*
 					Redirect to home page
 				*/

 				location.reload();
 			}
 			/*
 				Wrong username or password
 			*/
 			else
 			{
 					/*
 						Display an response message
 					*/

 					var response_message = "";
 					/*
 						 If response message == 1
 						 Wrong username or password
 					*/
 					if(xmlHttp.responseText.localeCompare("1") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Questionnaire Name.</div>";
 					}
 					/*
 						 If response message == 2
 						 Not verified (Email verification)
 					*/
 					else if(xmlHttp.responseText.localeCompare("2") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Questionnaire Description.</div>";
 					}
 					/*
 						 If response message == 3
 						 User is deleted
 					*/
 					else if(xmlHttp.responseText.localeCompare("3") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Message Required value.</div>";
 					}
 					/*
 						 If response message == 4
 						 Banned account
 					*/
 					else if(xmlHttp.responseText.localeCompare("4") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>General Database Error.</div>";
 					}
 					/*
 							Something going wrong
 					*/
 					else {
 						response_message += "<div class='alert alert-danger'>Unknown error message. Contact with one administrator!</div>";
 					}

 			 	 $("#questionnaire-edit-response").show();
 				 $("#questionnaire-edit-response").html(response_message);
 			}
 		}

 	}
 	/*
 		Server Problem (Timeout probably)
 	*/
 	else {
 			/*
 				TODO Something like
 			*/
 			$("#questionnaire-edit-response").show();
 			$("#questionnaire-edit-response").html("<div class='alert alert-danger'>Server is offline</div>");
 	}
}
