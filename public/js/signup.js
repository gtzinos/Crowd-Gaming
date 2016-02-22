var xmlHttp;
/*
	Try to Sign Up Method
*/
function signUp() {
	/*
		Initialize response label
	*/
	 document.getElementById("signup-response").innerHTML = "";
	 document.getElementById("signup-response").style.display = "none";

		if (window.XMLHttpRequest) {
			/*
			 code for IE7+, Firefox, Chrome, Opera, Safari
			*/
			xmlHttp = new XMLHttpRequest();
		} else {
			/*
			 code for IE6, IE5
			*/
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		/*
			Store user input to variables
		*/
		var email = document.getElementById("signup-email").value;
		var password = document.getElementById("signup-password").value;
		var fname = document.getElementById("signup-fname").value;
		var lname = document.getElementById("signup-lname").value;
		var gender = document.getElementById("signup-gender").value;
		var country = document.getElementById("signup-country").value;
		var city = document.getElementById("signup-city").value;
		var address = document.getElementById("signup-address").value;
		var phone = document.getElementById("signup-phone").value;
		var licence = document.getElementById("signup-licence").value;

		/*
			Check the Variables before sending them
		*/

		if(userEmail && userPassword)
		{
			var opts = {
				lines: 11 // The number of lines to draw
			, length: 28 // The length of each line
			, width: 14 // The line thickness
			, radius: 32 // The radius of the inner circle
			, scale: 0.5 // Scales overall size of the spinner
			, corners: 1 // Corner roundness (0..1)
			, color: '#000' // #rgb or #rrggbb or array of colors
			, opacity: 0.25 // Opacity of the lines
			, rotate: 0 // The rotation offset
			, direction: 1 // 1: clockwise, -1: counterclockwise
			, speed: 1 // Rounds per second
			, trail: 60 // Afterglow percentage
			, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
			, zIndex: 2e9 // The z-index (defaults to 2000000000)
			, className: 'spinner' // The CSS class to assign to the spinner
			, top: '50%' // Top position relative to parent
			, left: '50%' // Left position relative to parent
			, shadow: false // Whether to render a shadow
			, hwaccel: false // Whether to use hardware acceleration
			, position: 'absolute' // Element positioning
			}
			var target = document.getElementById('signup-spinner');
			/*
				Append Spinner
			*/
			spinner = new Spinner(opts).spin();
			target.appendChild(spinner.el);
			/*
				Milliseconds which user must wait
				after server response arrived
				(Spinner loader)
			*/
			var millisecondsToWait = 1500;

			/*
				After var millisecondsToWait
				we will show results to the client
			*/
			xmlHttp.onreadystatechange = setTimeout(function() {
				/*
					Response function
				*/
				responseSignUp();
			}, millisecondsToWait);
			/*
				Url string
			*/
			var url = "./signup";
			/*
			 Send using POST Method
			*/
			xmlHttp.open("POST", url, false);
			/*
				Header encryption
			*/
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

			xmlHttp.send("email=" + userEmail + "&password=" +  userPassword);

		}
		else
		{
			document.getElementById("signup-response").style.display = "inline";
			document.getElementById("signup-response").innerHTML = "Username or Password cannot be empty !!!";
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
				User can login
			*/
			if(xmlHttp.responseText.localeCompare("true") == 0)
			{
				/*
					Redirect to home page
				*/

				window.location("./home");
			}
			/*
				Wrong username or password
			*/
			else
			{
					/*
						Display an error message
					*/
			 	 document.getElementById("signup-response").style.display = "inline";
				 document.getElementById("signup-response").innerHTML = "Email used from another user !!!";
			}
		}

	}
	/*
		Server Problem (Timeout probably)
	*/
	else {
		/*
			TODO Something like
			document.getElementById("signup-response").style.display ="none";
			document.getElementById("signup-response").innerHTML = "Wrong username or password";
			OR
			TODO window.location("./home");
		*/
	}
}
