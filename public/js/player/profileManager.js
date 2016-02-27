var xmlHttp;

/*
  Initialize spinner
*/
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

/*
  User try to update
  his profile informations
*/
function profileUpdate()
{
  	/*
  		Initialize response label
  	*/
  	 document.getElementById("profile-response").innerHTML = "";
  	 document.getElementById("profile-response").style.display = "none";
  	 //$(document).find("#profile-response").css('color','red');

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
  			Store required and optional
        user input to variables
  		*/
  		var userEmail = $(document).find("#profile-email").val();
  		var userPassword = $(document).find("#profile-password").val();
  		var userFName = $(document).find("#profile-fname").val();
  		var userLName = $(document).find("#profile-lname").val();
  		var userGender = $(document).find("#profile-gender").val();
  		var userCountry = $(document).find("#profile-country").val();
  		var userCity = $(document).find("#profile-city").val();
      /*
        Optional
      */
  		var userAddress = $(document).find("#profile-address").val();
  		var userPhone =  $(document).find("#profile-phone").val();

  		/*
  			Check the Variables before sending them
  		*/

  		if(userEmail && userPassword && userFName &&  userLName && userGender && userCountry && userCity)
  		{

  			var target = document.getElementById('profile-spinner');
  			//var spinner = new Spinner(opts).spin(target);

  			spinner = new Spinner(opts).spin();
  			target.appendChild(spinner.el);
  			/*
  				While spin loading submit button must be disabled
  			*/
  			$(document).find('.submit').prop('disabled',true);
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
  				responseUpdateProfile();
  			}, millisecondsToWait);
  			/*
  				Url string
  			*/
  			var url = "./profile/ajax";
  			/*
  			 Send using POST Method
  			*/
  			xmlHttp.open("POST", url, false);
  			/*
  				Header encryption
  			*/
  			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  		  var variables = "email=" + userEmail + "&password=" + userPassword + "&name=" + userFName +
  				"&surname=" + userLName + "&country=" + userCountry + "&city=" + userCity + "&gender="
  				+ userGender;
        /*
          If address is setted
        */
  			if(userAddress)
  			{
  				variables = variables + "&address=" + userAddress;
  			}

        /*
          If userPhone is setted
        */
  			if(userPhone)
  			{
  				variables = variables + "&phone=" + userPhone;
  			}

  			xmlHttp.send(variables);

  		}
  		else
  		{
  			document.getElementById("profile-response").style.display = "inline";
  			document.getElementById("profile-response").innerHTML = "<div class='alert alert-danger'>You must fill all fields! </div>";
  		}

  }
  /*
  	Method called after response
  */
  function responseUpdateProfile() {
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
  			var target = document.getElementById('profile-spinner');
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
  				document.getElementById("profile-response").style.display = "inline";
  			//	$(document).find("#profile-response").css('color','green');
  				document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>You have updated your profile successfully!</div>";

  				/*
  				 Milliseconds which user must wait
  				 after register completed successfully
  			 */
  			 var millisecondsToWait = 2000;

  			 /*
  				After var millisecondsToWait
  				we will show results to the client
  			*/
  			 xmlHttp.onreadystatechange = setTimeout(function() {
  				 /*
  					 reload to main page
  				 */
  				 location.reload();
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
  				 if(xmlHttp.responseText.localeCompare("2") == 0)
  				 {
  					 error_message += "<div class='alert alert-danger'>First Name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If error message == 3
  						Last Name length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("3") == 0)
  				 {
  					 error_message += "<div class='alert alert-danger'>Last Name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If error message == 4
  						Gender value problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("4") == 0)
  				 {
  					 error_message += "<div class='alert alert-danger'>Gender length must be 0 or 1.</div>";
  				 }
  				 /*
  				 		If error message == 5
  						Country Name length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("5") == 0)
  				 {
  				 	error_message += "<div class='alert alert-danger'>Country name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If error message == 6
  					  City Name length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("6") == 0)
  				 {
  				 	error_message += "<div class='alert alert-danger'>City name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If error message == 7
  						Password length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("7") == 0)
  				 {
  				 	error_message += "<div class='alert alert-danger'>Password length must be >= 8 characters.</div>";
  				 }
  				 /*
  				 		If error message == 8
  						Address Name length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("8") == 0)
  				 {
  					 error_message += "<div class='alert alert-danger'>Address name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If error message == 9
  						Phone number length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("9") == 0)
  				 {
  				 	error_message += "<div class='alert alert-danger'>Phone number length must be 8 - 15 characters.</div>";
  				 }
  				 /*
  				 		If error message == 10
  						Email address used problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("10") == 0)
  				 {
  				 	error_message += "<div class='alert alert-danger'>Email address used by another user.</div>";
  				 }
  				 /*
  				 	 If error message == 11
  				 	 General database problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("11") == 0)
  				 {
  				  error_message += "<div class='alert alert-danger'>We are sorry about this. Please try Later.</div>";
  				 }

  				 /*
  				 	Else if no error message
  					return something going Wrong
  				 */


  				 	if(xmlHttp.responseText.localeCompare("") == 0)
  					{
  						//Send us one email with the error message
  						//mail("to","From","ERROR profile",xmlHttp.responseText);
  						error_message = "<div class='alert alert-danger'>Important error. Contact with one admin!</div>";
  					}



  				 /*
  				 	 Display the message
  					 to the wright div
  				 */
  			 	 document.getElementById("profile-response").style.display = "inline";
  				 document.getElementById("profile-response").innerHTML = xmlHttp.responseText;

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
  			document.getElementById("profile-response").style.display ="none";
  			document.getElementById("profile-response").innerHTML = "<div class='alert alert-danger'>Server is offline</div>"	;
  	}
  }

/*
  User try to delete his account
*/
function deleteAccount()
{
  /*
    Initialize response label
  */
   document.getElementById("profile-response").innerHTML = "";
   document.getElementById("profile-response").style.display = "none";
   //$(document).find("#profile-response").css('color','red');

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

    var target = document.getElementById('profile-spinner');
    //var spinner = new Spinner(opts).spin(target);

    spinner = new Spinner(opts).spin();
    target.appendChild(spinner.el);
    /*
      While spin loading submit button must be disabled
    */
    $(document).find('.submit').prop('disabled',true);
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
      responseDeleteAccount();
    }, millisecondsToWait);
    /*
      Url string
    */
    var url = "./delete-account";
    /*
     Send using POST Method
    */
    xmlHttp.open("POST", url, false);
    /*
      Header encryption
    */
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var variables = "deleteme=true&accept=true";
    /*
      Send ajax request
    */
    xmlHttp.send(variables);
}
/*
  Server response
  after user try to delete
  his account
*/
function responseDeleteAccount()
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
        Remove spinner loader
      */
      var target = document.getElementById('profile-spinner');
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
        document.getElementById("profile-response").style.display = "inline";
        //	$(document).find("#profile-response").css('color','green');
        document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>Your account deleted successfully!</div>";
        /*
         Milliseconds which user must wait
         after register completed successfully
        */
        var millisecondsToWait = 2000;

        /*
        After var millisecondsToWait
        we will show results to the client
        */
        xmlHttp.onreadystatechange = setTimeout(function() {
         /*
           reload to main page
         */
         location.reload();
        }, millisecondsToWait);
      }
      /*
				Something going wrong
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
					  ERROR 1

  				 if(xmlHttp.responseText.localeCompare("1") == 0)
  				 {
  					 error_message += "<div class='alert alert-danger'>Email address length must be 3 - 50 characters.</div>";
  				 }
         */
         /*
           Display the message
           to the wright div
         */
         document.getElementById("profile-response").style.display = "inline";
         document.getElementById("profile-response").innerHTML = error_message;

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
 			document.getElementById("profile-response").style.display ="none";
 			document.getElementById("profile-response").innerHTML = "<div class='alert alert-danger'>Server is offline</div>";
 	}
}
