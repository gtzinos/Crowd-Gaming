function getClientData()
{
	/*
		Store user input to variables
	*/
	var userEmail = $(document).find("#signin-email").val();
	var userPassword = $(document).find("#signin-password").val();
	var userRememberMe = $(document).find("#signin-remember").prop('checked');

	if(userEmail && userPassword)
	{
		let data = {
			"email": userEmail,
			"password": userPassword
		};

		if(userRememberMe)
		{
			data["remember"] = userRememberMe;
		}
		return data;
	}
	else {
		return null;
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
		if(dataToSend != null)
		{
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
							/*
								Display an response message
							*/
							var response_message = "";
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
									Something going wrong
							*/
							else {
								show_notification("error","Something going wrong. Please try later!",4000);
							}
						}
				})
				.fail(function(xhr,error) {
					displayServerResponseError(xhr,error);
				})
				.always(function() {
					notCompletedRequest = false;
					remove_spinner("signin-spinner");
				});
		}
		else
		{
			/*
				Response failed login message
			*/
			show_notification("error","Username or Password cannot be empty.",4000);
		}
}
