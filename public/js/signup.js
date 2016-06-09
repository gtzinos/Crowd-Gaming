	function getUserData()
	{
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

			if(userEmail && userPassword && userFName &&  userLName && userGender && userCountry && userCity && userAcceptLicence)
			{
				let dataToSend = {
					"email": userEmail,
					"password": userPassword,
					"name": userFName,
					"surname": userLName,
					"country": userCountry,
					"city": userCity,
					"gender": userGender,
					"licence": "accepted"
				};

				/*
					Check the Variables before sending them
				*/
				if(userAddress)
				{
					dataToSend["address"] = userAddress;
				}
				if(userPhone)
				{
					dataToSend["phone"] = userPhone;
				}
				return dataToSend;
			}
			else
			{
				return null;
			}
	}

	/*
	  Try to Sign Up Method
  */
	function signUpFromForm() {
		//get user data
		var dataToSend = getUserData();
		if(dataToSend != null)
		{
			$.ajax(
			{
				method: "POST",
				url: webRoot + "signup",
				data: dataToSend
			})
			.done(function(data)
			{
				var target = document.getElementById('signup-spinner');
				//target.removeChild(spinner.el);
				/*
					After spin loaded submit button must be enabled
				*/
				$(document).find('.submit').prop('disabled',false);
				/*
					User can login
				*/
				if(data == "0")
				{
					/* Redirect to home page	*/
					show_notification("success","You have registered successfully!",4000);
					/*
					 Milliseconds which user must wait
					 after register completed successfully
				 */
				 var millisecondsToWait = 3000;
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
				//Something going wrong
				else
				{
					 /*
							If response message == 1
							Email address length problem
					 */
					 if(data == "1")
					 {
						 show_notification("error","Email address length must be 3 - 50 characters.",4000);
					 }
					 /*
							If response message == 2
							First Name length problem
					 */
					 else if(data == "2")
					 {
						 show_notification("error","First Name length must be 2 - 40 characters.",4000);
					 }
					 /*
							If response message == 3
							Last Name length problem
					 */
					 else if(data == "3")
					 {
						 show_notification("error","Last Name length must be 2 - 40 characters.",4000);
					 }
					 /*
							If response message == 4
							Gender value problem
					 */
					 else if(data == "4")
					 {
						 show_notification("error","Gender length must be 0 or 1.",4000);
					 }
					 /*
							If response message == 5
							Country Name length problem
					 */
					 else if(data == "5")
					 {
						show_notification("error","Country name length must be 2 - 40 characters.",4000);
					 }
					 /*
							If response message == 6
							City Name length problem
					 */
					 else if(data == "6")
					 {
						 show_notification("error","City name length must be 2 - 40 characters.",4000);
					 }
					 /*
							If response message == 7
							Password length problem
					 */
					 else if(data == "7")
					 {
						show_notification("error","Password length must be 8 - 50 characters.",4000);
					 }
					 /*
							If response message == 8
							Address Name length problem
					 */
					 else if(data == "8")
					 {
						 show_notification("error","Address name length must be 2 - 40 characters.",4000);
					 }
					 /*
							If response message == 9
							Phone number length problem
					 */
					 else if(data == "9")
					 {
						show_notification("error","Phone number length must be 8 - 15 characters.",4000);
					 }
					 /*
							If response message == 10
							Email address used problem
					 */
					 else if(data == "10")
					 {
						show_notification("error","Email address used by another user.",4000);
					 }
					 /*
						 If response message == 11
						 General database problem
					 */
					 else if(data == "11")
					 {
						show_notification("error","We are sorry about this. Please try Later.",4000);
					 }
					 /*
						If response message == 12
						General database problem
					 */
					 else if(data == "12")
					 {
						show_notification("error","You must accept our licence.",4000);
					 }
					 /*
							 Something going wrong
					 */
						else {
							 show_notification("error","Something going wrong. Please try later!",4000);
						}
				}
			})
			.fail(function(data)
			{

			})
		}
		else {
			show_notification("error","You must fill all fields.",4000);
		}
	}
