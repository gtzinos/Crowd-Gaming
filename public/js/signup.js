/*
	Try to Sign Up Method
*/
	function signUpFromForm() {

		/*
			Store user input to variables
		*/
		var userEmail = $(document).find("#signup-email").val();
		var userPassword = $(document).find("#signup-password").val();
		var userFName = $(document).find("#signup-fname").val();
		var userLName = $(document).find("#signup-lname").val();
		var userGender = $(document).find("#signup-gender").val();
		var userCountry = $(document).find("#signup-country").val();
		var userCity = $(document).find("#signup-city").val();
		var userAcceptLicence = $(document).find("#signup-licence").prop('checked');

		var userAddress = $(document).find("#signup-address").val();
		var userPhone =  $(document).find("#signup-phone").val();

		/*
			Check the Variables before sending them
		*/

		if(userEmail && userPassword && userFName &&  userLName && userGender && userCountry && userCity && userAcceptLicence)
		{

			var Required = {
				  Url() { return webRoot + "signup"; },
					SendType() { return "POST"; },
				  variables : "",
			    Parameters() {
						this.variables = "email=" + userEmail + "&password=" + userPassword + "&name=" + userFName +
							"&surname=" + userLName + "&country=" + userCountry + "&city=" + userCity + "&gender="
							+ userGender + "&licence=accepted";

						if(userAddress)
						{
							this.variables += "&address=" + userAddress;
						}
						if(userPhone)
						{
							this.variables += "&phone=" + userPhone;
						}
						return this.variables;
					}
			};
			var Optional = {
				ResponseMethod() { return "responseSignUp"; },
				DelayTime() { return 1500; },
				ResponseLabel() { return "signup-response"; },
				SpinnerLoader() { return "signup-spinner"; },
				SubmitButton() { return ".submit"; }
			};
			/*
				Send ajax request
			*/
			sendAjaxRequest(Required,Optional);
		}
		else {
			$("#signup-response").show();
			$("#signup-response").html("'<div class='alert alert-danger'>You must fill all fields.</div>");
		}
	}
/*
	Method called after response
*/
function responseSignUp() {
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
			var target = document.getElementById('signup-spinner');
			target.removeChild(spinner.el);
			/*
				After spin loaded submit button must be enabled
			*/
			$(document).find('.submit').prop('disabled',false);
			/*
				User can login
			*/
			if(xmlHttp.responseText.localeCompare("TRUE") == 0)
			{

				/*
					Redirect to home page
				*/
				$("signup-response").show();
			//	$(document).find("#signup-response").css('color','green');
				$("signup-response").html("<div class='alert alert-success'>You have registered successfully!</div>");

				/*
				 Milliseconds which user must wait
				 after register completed successfully
			 */
			 var millisecondsToWait = 2000;

			 /*
				After var millisecondsToWait
				we will show results to the client
			*/
			 setTimeout(function() {
				 /*
					 reload to main page
				 */
				 $(location).attr("href", "./signup-success");
			 }, millisecondsToWait);
			}
			/*
				Wrong username or password
			*/
			else
			{
					/*
						Display an error message
						depending on the response message
					*/

				 var error_message="";
				 /*
				 		If error message == 1
						Email address length problem
				 */
				 if(xmlHttp.responseText.localeCompare("1") == 0)
				 {
					 error_message += "<div class='alert alert-danger'>Email address length must be 3 - 50 characters.</div>";
				 }
				 /*
				 		If error message == 2
					  First Name length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("2") == 0)
				 {
					 error_message += "<div class='alert alert-danger'>First Name length must be 2 - 40 characters.</div>";
				 }
				 /*
				 		If error message == 3
						Last Name length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("3") == 0)
				 {
					 error_message += "<div class='alert alert-danger'>Last Name length must be 2 - 40 characters.</div>";
				 }
				 /*
				 		If error message == 4
						Gender value problem
				 */
				 else if(xmlHttp.responseText.localeCompare("4") == 0)
				 {
					 error_message += "<div class='alert alert-danger'>Gender length must be 0 or 1.</div>";
				 }
				 /*
				 		If error message == 5
						Country Name length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("5") == 0)
				 {
				 	error_message += "<div class='alert alert-danger'>Country name length must be 2 - 40 characters.</div>";
				 }
				 /*
				 		If error message == 6
					  City Name length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("6") == 0)
				 {
				 	error_message += "<div class='alert alert-danger'>City name length must be 2 - 40 characters.</div>";
				 }
				 /*
				 		If error message == 7
						Password length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("7") == 0)
				 {
				 	error_message += "<div class='alert alert-danger'>Password length must be 8 - 50 characters.</div>";
				 }
				 /*
				 		If error message == 8
						Address Name length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("8") == 0)
				 {
					 error_message += "<div class='alert alert-danger'>Address name length must be 2 - 40 characters.</div>";
				 }
				 /*
				 		If error message == 9
						Phone number length problem
				 */
				 else if(xmlHttp.responseText.localeCompare("9") == 0)
				 {
				 	error_message += "<div class='alert alert-danger'>Phone number length must be 8 - 15 characters.</div>";
				 }
				 /*
				 		If error message == 10
						Email address used problem
				 */
				 else if(xmlHttp.responseText.localeCompare("10") == 0)
				 {
				 	error_message += "<div class='alert alert-danger'>Email address used by another user.</div>";
				 }
				 /*
				 	 If error message == 11
				 	 General database problem
				 */
				 else if(xmlHttp.responseText.localeCompare("11") == 0)
				 {
				  error_message += "<div class='alert alert-danger'>We are sorry about this. Please try Later.</div>";
				 }
				 /*
				 	If error message == 12
				 	General database problem
				 */
				 else if(xmlHttp.responseText.localeCompare("12") == 0)
				 {
				  error_message += "<div class='alert alert-danger'>You must accept our licence.</div>";
				 }
				 /*
						 Something going wrong
				 */
				 else {
					 error_message += "<div class='alert alert-danger'>Something going wrong. Please try later!</div>";
				 }
				 /*
				 	if(xmlHttp.responseText.localeCompare("") == 0)
					{
						Send us one email with the error message
						mail("to","From","ERROR SIGNUP",xmlHttp.responseText);
						error_message = "Important error. Contact with one admin!";
					}
				 */

				 /*
				 	 Display the message
					 to the wright div
				 */
			 	 $("#signup-response").show();
				 $("#signup-response").html(error_message);

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
			$("#signup-response").hide();
			$("#signup-response").html("<div class='alert alert-danger'>Server is offline</div>");

	}
}
