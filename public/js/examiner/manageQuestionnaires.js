/*
  Create questionnaire
*/
function createQuestionnaire()
{
  /*
    Initialize variables
  */
  var name = $("#questionnaire-name").val();
  var description = $("#questionnaire-description").val();
  var message_required = $("#message-required").val();

  if(name && description)
  {
    var Required = {
        Url() { return webRoot + "create-questionnaire"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "name=" + name + "&description=" +  description;

          if(message_required == "-") {
              message_required = "no";
          }
          this.variables = "&message_required=" + message_required;

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

      }
    }
  }
}
