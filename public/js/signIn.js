var xmlHttp;
/*
	Try to Sign In Method
*/
function signInFromForm() {
			/*
			Store user input to variables
		*/
		var userEmail = $(document).find("#signin-email").val();
		var userPassword = $(document).find("#signin-password").val();
		var userRememberMe = $(document).find("#signin-remember").prop('checked');
		/*
			Check the Variables before sending them
		*/

		if(userEmail && userPassword)
		{
			var Required = {
				  Url() { return webRoot + "signin"; },
					SendType() { return "POST"; },
				  variables : "",
			    Parameters() {
						/*
							Variables we will send
						*/
						this.variables = "email=" + userEmail + "&password=" +  userPassword;

						/*
							If user needs to remember him
						*/
						if(userRememberMe == "true")
						{
							this.variables += "&remember=true";
						}

						return this.variables;
					}
			};
			var Optional = {
				ResponseMethod() { return "responseSignIn"; },
				DelayTime() { return 1500; },
				ResponseLabel() { return "signin-response"; },
				SpinnerLoader() { return "signin-spinner"; },
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
				Response failed login message
			*/
			$("#signin-response").show();
			$("#signin-response").html("<div class='alert alert-danger'>Username or Password cannot be empty. </div>");
		}

}
/*
	Method called after response
*/
function responseSignIn() {
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
				Remove spinner loader
			*/
			var target = document.getElementById('signin-spinner');
			target.removeChild(spinner.el);
			/*
				After spin loaded submit button must be enabled
			*/
			$(document).find('.submit').prop('disabled',false);
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
					 response_message += "<div class='alert alert-danger'>Wrong username or password.</div>";
					}
					/*
						 If response message == 2
						 Not verified (Email verification)
					*/
					else if(xmlHttp.responseText.localeCompare("2") == 0)
					{
					 response_message += "<div class='alert alert-danger'>You must verify your email address.</div>";
					}
					/*
						 If response message == 3
						 User is deleted
					*/
					else if(xmlHttp.responseText.localeCompare("3") == 0)
					{
					 response_message += "<div class='alert alert-danger'>This account has deleted.</div>";
					}
					/*
						 If response message == 4
						 Banned account
					*/
					else if(xmlHttp.responseText.localeCompare("4") == 0)
					{
					 response_message += "<div class='alert alert-danger'>Your account has banned.</div>";
					}
					/*
							Something going wrong
					*/
					else {
						response_message += "<div class='alert alert-danger'>Something going wrong. Please try later!</div>";
					}



			 	 $("#signin-response").show();
				 $("#signin-response").html(response_message);
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
