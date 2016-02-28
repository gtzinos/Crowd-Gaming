var xmlHttp;

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

     document.getElementById("confirm-response").innerHTML = "";
  	 document.getElementById("confirm-response").style.display = "none";

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
      var userConfirmPassword = $(".modal").find("#confirm-password").val();
  		var userNewPassword = $(document).find("#profile-new-password").val();
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

  		if(userEmail && userConfirmPassword && userFName &&  userLName && userGender && userCountry && userCity)
  		{

  			/*
  				While spin loading submit button must be disabled
  			*/
  			$(document).find('.submit').prop('disabled',true);
  			/*
  				Milliseconds which user must wait
  				after server response arrived
  				(loader)
  			*/
  			var millisecondsToWait = 1000;

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
  		  var variables = "email=" + userEmail + "&oldpassword=" + userConfirmPassword + "&name=" + userFName +
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
        /*
          If userNewPassword is setted
        */
        if(userNewPassword)
        {
          variables = variables + "&newpassword=" + userNewPassword;
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
  				document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>You have updated your profile successfully!</div>";

  			   /*
              Close Modal
           */
           $('.modal').modal('hide');

           /*
             Milliseconds which user must wait
             before refresh
             (loader)
           */
           var millisecondsToWait = 3000;

           /*
             After var millisecondsToWait
             we will refresh the page
           */
           xmlHttp.onreadystatechange = setTimeout(function() {
               /*
      					 reload profile page
      				 */
               location.reload();
           }, millisecondsToWait);

  			}
  			/*
  				Error codes
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
             If error message == 12
             Fail password problem
           */
           if(xmlHttp.responseText.localeCompare("12") == 0)
           {
            error_message += "<div class='alert alert-danger'>Invalid password. Try again!</div>";
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
  			 	 document.getElementById("confirm-response").style.display = "inline";
  				 document.getElementById("confirm-response").innerHTML = error_message;

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
  			document.getElementById("confirm-response").style.display ="none";
  			document.getElementById("confirm-response").innerHTML = "<div class='alert alert-danger'>Server is offline</div>"	;
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

   document.getElementById("confirm-response").innerHTML = "";
   document.getElementById("confirm-response").style.display = "none";

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
      While spin loading submit button must be disabled
    */
    $(document).find('.submit').prop('disabled',true);
    /*
      Milliseconds which user must wait
      after server response arrived
      (loader)
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
        document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>Your account deleted successfully!</div>";


        /*
           Close Modal
        */
        $('.modal').modal('hide');

        /*
         Milliseconds which user must wait
         after delete completed successfully
        */
        var millisecondsToWait = 2000;

        /*
        After var millisecondsToWait
        for user logout
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
         document.getElementById("confirm-response").style.display = "inline";
         document.getElementById("confirm-response").innerHTML = error_message;

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
 			document.getElementById("confirm-response").style.display ="none";
 			document.getElementById("confirm-response").innerHTML = "<div class='alert alert-danger'>Server is offline</div>";
 	}
}
