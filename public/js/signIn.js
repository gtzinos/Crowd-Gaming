var xmlHttp;
/*
	Try to Sign In Method
*/
function signIn() {
	/*
		Initialize response label
	*/
	 document.getElementById("login_response").innerHTML = "";
	 document.getElementById("login_response").style.display = "none";

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
			Store user input to variabless
		*/
		var userEmail = document.getElementById("userEmail").value;
		var userPassword = document.getElementById("userPassword").value;
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
			var target = document.getElementById('spinner');
			//var spinner = new Spinner(opts).spin(target);

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
				responseLogin();
			}, millisecondsToWait);
			/*
				Url string
			*/
			var url = "./signin";
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
			document.getElementById("login_response").style.display = "inline";
			document.getElementById("login_response").innerHTML = "Username or Password cannot be empty !!!";
		}

}
/*
	Method called after response
*/
function responseLogin() {
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
			var target = document.getElementById('spinner');
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
			 	 document.getElementById("login_response").style.display = "inline";
				 document.getElementById("login_response").innerHTML = "Wrong username or password";
			}
		}

	}
	/*
		Server Problem (Timeout probably)
	*/
	else {
		/*
			TODO Something like
			document.getElementById("login_response").style.display ="none";
			document.getElementById("login_response").innerHTML = "Wrong username or password";
			OR
			TODO window.location("./home");
		*/
	}
}
