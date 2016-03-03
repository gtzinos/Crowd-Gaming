/*
  Reset user password
*/
function resetPassword()
{
		/*
			Store user input to variables
		*/
		var recoveryEmail = $(document).find("#recovery-email").val();
		/*
			Check the Variables before sending them
		*/

		if(recoveryEmail)
		{
			var Required = {
				  Url() { return webRoot + "recovery-password"; },
					SendType() { return "POST"; },
			    Parameters() {
						return "email=" + recoveryEmail;
					}
			};
			var Optional = {
				ResponseMethod() { return "responseRecovery"; },
				DelayTime() { return 1500; },
				ResponseLabel() { return "recovery-response"; },
				SubmitButton() { return ".submit"; }
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
			$("#recovery-response").show();
			$("#recovery-response").html("<div class='alert alert-danger'>Email address cannot be empty. </div>");
		}
}

/*
	Response called method
*/
function responseRecovery()
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

			/*
				After server responsed submit button must be enabled
			*/
			$(document).find('.submit').prop('disabled',false);
			/*
				User reset password successfully
			*/
			if(xmlHttp.responseText.localeCompare("TRUE") == 0)
			{
				$("#recovery-response").show();
				$("#recovery-response").html("<div class='alert alert-success'>Your password reseted successfully. An email has been sent to your email address. "
				  	+ " Please click the link that has been sent to you and you will type a new password.</div>");
			}
			/*
				Response error
			*/
			else
			{
					/*
						Display an error message
					*/

					var error_message = "";
					/*
						 If error message == 1
						 Invalid email address
					*/
					if(xmlHttp.responseText.localeCompare("1") == 0)
					{
					 error_message += "<div class='alert alert-danger'>This is not a valid email address.</div>";
					}
					/*
							Something going wrong
					*/
					else {
						error_message += "<div class='alert alert-danger'>Something going wrong. Contact with one administrator!</div>";
					}



				 $("#recovery-response").show();
				 $("#recovery-response").html(error_message);
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
			$("#signin-response").show();
			$("#signin-response").html("<div class='alert alert-danger'>Server is offline</div>");
	}
}
