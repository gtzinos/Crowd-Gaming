function getClientData()
{
	/*
		Store user input to variables
	*/
	var userEmail = $(document).find("#signin-email").val();
	var userPassword = $(document).find("#signin-password").val();
	var userRememberMe = $(document).find("#signin-remember").prop('checked');
	var verify = grecaptcha.getResponse(loginCaptcha);
	if(!userEmail)
	{
		return -1;
	}
	else if(!userPassword)
	{
		return -2;
	}
	else if(verify == "")
	{
		return -3;
	}
	else
	{
		var data = {
			"email": userEmail,
			"password": userPassword,
			"recaptcha": verify
		};

		if(userRememberMe)
		{
			data["remember"] = userRememberMe;
		}
		return data;
	}
}
/*
	Try to Sign In Method
*/
function signInFromForm() {
	  if(notCompletedRequest == true || $("#signin-submit-button").is(':disabled'))
		{
			return;
		}

		/*
			Check the Variables before sending them
		*/
		var dataToSend = getClientData();
		if(dataToSend == -1)
		{
			show_notification("error","Please fill your email address.",3000);
		}
		else if(dataToSend == -2)
		{
			show_notification("error","Please fill your password.",3000);
		}
		else if(dataToSend == -3)
		{
			show_notification("error","Please verify the google captcha.",3000);
		}
		else {
			notCompletedRequest = true;
			show_spinner("signin-spinner");
			$.ajax(
				{
					method: "POST",
					url: webRoot + "signin",
					data: dataToSend
				})
				.done(function(data) {
					/*
						User can login
					*/
					if(data == "0")
					{
						/*
							Redirect to home page
						*/
						location.reload();
					}
					else
					{
							grecaptcha.reset(loginCaptcha);
							/*
								 If response message == 1
								 Wrong username or password
							*/
							if(data == "1")
							{
							 show_notification("error","Wrong username or password.",4000);
							}
							/*
								 If response message == 2
								 Not verified (Email verification)
							*/
							else if(data == "2")
							{
							 show_notification("error","You must verify your email address.",4000);
							}
							/*
								 If response message == 3
								 User is deleted
							*/
							else if(data == "3")
							{
							 show_notification("error","This account has deleted.",4000);
							}
							/*
								 If response message == 4
								 Banned account
							*/
							else if(data == "4")
							{
							 show_notification("error","Your account has banned.",4000);
							}
							/*
								 If response message == 5
								 Verify google recaptcha
							*/
							else if(data == "5")
							{
							 show_notification("error","You must verify recaptcha.",4000);
							}
							/*
									Something going wrong
							*/
							else {
								show_notification("error","Something went wrong, Please try again later!",4000);
							}
							remove_spinner("signin-spinner");
							notCompletedRequest = false;
						}
				})
				.fail(function(xhr,error) {
					displayServerResponseError(xhr,error);
					remove_spinner("signin-spinner");
					notCompletedRequest = false;
					grecaptcha.reset(loginCaptcha);
				});
		}
}
