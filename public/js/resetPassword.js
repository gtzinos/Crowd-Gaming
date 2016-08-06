/*
  Reset user password
*/
function resetPassword()
{
		if(notCompletedRequest == true || $("#recovery-button").is(":disabled"))
		{
			return;
		}
		notCompletedRequest = true;
		$("#recovery-response").html("").hide();
		/*
			Store user input to variables
		*/
		var recoveryEmail = $(document).find("#recovery-email").val();
		/*
			Check the Variables before sending them
		*/
		if(recoveryEmail)
		{
			show_spinner("recovery-spinner");
			$.ajax(
			{
				method: "POST",
				url: webRoot + "forgot-my-password",
				data: { "email": recoveryEmail }
			})
			.done(function(data) {
				//User reset password successfully
				if(data == "0")
				{
					$("#recovery-response").show();
					$("#recovery-response").html("<div class='alert alert-success'>Your password has been reset successfully. An email has been sent to your email address. "
							+ " Please click the link that has been sent to you and you will asked to type a new password.</div>");
				}
				//Not a valid email address
				else if(data == "1")
				{
				  show_notification("error","This is not a valid email address.",4000);
				}
				//Something going wrong
				else {
					show_notification("error","Unknown error. Contact us for support.",4000);
				}
			})
			.fail(function(xhr,error) {
				displayServerResponseError(xhr,error);
			})
			.always(function() {
				notCompletedRequest = false;
				remove_spinner("recovery-spinner");
			});
		}
		else
		{
			/*
				Response failed recovery message
			*/
			show_notification("error","Email address cannot be empty.",4000);
			notCompletedRequest = false;
		}
}
