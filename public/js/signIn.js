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
			$.ajax(
				{
					method: "POST",
					url: webRoot + "signin",
					data:
					{
						"email": userEmail,
						"password": userPassword
					}
				})
				.done(function(data) {
					/*
						Remove spinner loader
					*/
					var target = document.getElementById('signin-spinner');
				  //	target.removeChild(spinner.el);
					/*
						After spin loaded submit button must be enabled
					*/
					$(document).find('.submit').prop('disabled',false);
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
				.fail(function(data) {
					$("#signin-response").show();
					$("#signin-response").html("Server problems. Try again.");
				});
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
