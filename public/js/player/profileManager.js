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
  			/*response-code
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
  		  var variables = "email=" + userEmail + "&currentpassword=" + userConfirmPassword + "&name=" + userFName +
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
        /*
           Close Modal
        */
        $('.modal').modal('hide');
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
  				User can login
  			*/
  			if(xmlHttp.responseText.localeCompare("0") == 0)
  			{
          /*
             Close Modal
          */
          $('.modal').modal('hide');

  				/*
  					Redirect to home page
  				*/
  				document.getElementById("profile-response").style.display = "inline";
  				document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>You have updated your profile successfully!</div>";

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
           setTimeout(function() {
               /*
      					 reload profile page
      				 */
               location.reload();
           }, millisecondsToWait);

  			}
  			/*
  				response codes
  			*/
  			else
  			{
  					/*
  						Display an response message
  						depending on the response message
  					*/


  				 var response_message="";
  				 /*
  				 		If response message == 1
  						Email address length problem
  				 */
  				 if(xmlHttp.responseText.localeCompare("1") == 0)
  				 {
  					 response_message += "<div class='alert alert-danger'>Email address length must be 3 - 50 characters.</div>";
  				 }
  				 /*
  				 		If response message == 2
  					  First Name length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("2") == 0)
  				 {
  					 response_message += "<div class='alert alert-danger'>First Name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If response message == 3
  						Last Name length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("3") == 0)
  				 {
  					 response_message += "<div class='alert alert-danger'>Last Name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If response message == 4
  						Gender value problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("4") == 0)
  				 {
  					 response_message += "<div class='alert alert-danger'>Gender length must be 0 or 1.</div>";
  				 }
  				 /*
  				 		If response message == 5
  						Country Name length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("5") == 0)
  				 {
  				 	response_message += "<div class='alert alert-danger'>Country name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If response message == 6
  					  City Name length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("6") == 0)
  				 {
  				 	response_message += "<div class='alert alert-danger'>City name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If response message == 7
  						Password length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("7") == 0)
  				 {
  				 	response_message += "<div class='alert alert-danger'>Password length must be >= 8 characters.</div>";
  				 }
  				 /*
  				 		If response message == 8
  						Address Name length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("8") == 0)
  				 {
  					 response_message += "<div class='alert alert-danger'>Address name length must be 2 - 40 characters.</div>";
  				 }
  				 /*
  				 		If response message == 9
  						Phone number length problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("9") == 0)
  				 {
  				 	response_message += "<div class='alert alert-danger'>Phone number length must be 8 - 15 characters.</div>";
  				 }
  				 /*
  				 		If response message == 10
  						Email address used problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("10") == 0)
  				 {
  				 	response_message += "<div class='alert alert-danger'>Email address used by another user.</div>";
  				 }
  				 /*
  				 	 If response message == 11
  				 	 General database problem
  				 */
  				 else if(xmlHttp.responseText.localeCompare("11") == 0)
  				 {
  				  response_message += "<div class='alert alert-danger'>We are sorry about this. Please try Later.</div>";
  				 }
           /*
             If response message == 12
             Fail password problem
           */
           else if(xmlHttp.responseText.localeCompare("12") == 0)
           {
            response_message += "<div class='alert alert-danger'>Invalid password. Try again!</div>";
           }
  				 /*
  				 	Something going Wrong
  				 */
           else
           {
 						response_message += "<div class='alert alert-danger'>Something going wrong. Please try later!</div>";
 					 }


  				 	if(xmlHttp.responseText.localeCompare("") == 0)
  					{
  						//Send us one email with the response message
  						//mail("to","From","response profile",xmlHttp.responseText);
  						response_message = "<div class='alert alert-danger'>Important response. Contact with one admin!</div>";
  					}



  				 /*
  				 	 Display the message
  					 to the wright div
  				 */
  			 	 document.getElementById("confirm-response").style.display = "inline";
  				 document.getElementById("confirm-response").innerHTML = response_message;

           /*
             After update completed submit button must be enabled
           */
           $(document).find('.submit').prop('disabled',false);

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
     Initialize user confirm password
    */
    var userConfirmPassword = $(".modal").find("#confirm-password").val();

    /*
      Check the Variable before sending
    */
    if(userConfirmPassword)
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
        responseDeleteAccount();
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
      var variables = "currentpassword=" + userConfirmPassword;
      /*
        Send ajax request
      */
      xmlHttp.send(variables);
    }
    else
    {
      /*
         Close Modal
         if is opened
      */
      $('.modal').modal('hide');
      document.getElementById("profile-response").style.display = "inline";
      document.getElementById("profile-response").innerHTML = "<div class='alert alert-danger'>You must fill all fields! </div>";
    }

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
        User can login
      */
      if(xmlHttp.responseText.localeCompare("0") == 0)
      {
        /*
           Close Modal
        */
        $('.modal').modal('hide');

        /*
          Redirect to home page
        */
        document.getElementById("profile-response").style.display = "inline";
        document.getElementById("profile-response").innerHTML = "<div class='alert alert-success'>Your account deleted successfully!</div>";


        /*
         Milliseconds which user must wait
         after delete completed successfully
        */
        var millisecondsToWait = 2000;

        /*
        After var millisecondsToWait
        for user logout
        */
        setTimeout(function() {
         /*
           reload to main page
         */
         //location.reload();
         $(location).attr("href", "./delete-account-success");
        }, millisecondsToWait);
      }
      /*
				Something going wrong
			*/
			else
			{
					/*
						Display an response message
						depending on the response message
					*/

				 var response_message="";
				 /*
				 		If response message == 1
					  Wrong password
         */
				 if(xmlHttp.responseText.localeCompare("1") == 0)
				 {
					 response_message += "<div class='alert alert-danger'>Incorrect password.Try again!</div>";
				 }
         /*
				 		If response message == 1
					  Wrong password
         */
				 else if(xmlHttp.responseText.localeCompare("2") == 0)
				 {
					 response_message += "<div class='alert alert-danger'>General Database response.</div>";
				 }
         /*
          Something going wrong
         */
         else
         {
           response_message += "<div class='alert alert-danger'>Something going wrong. Please try later!</div>";
         }
         /*
           Display the message
           to the wright div
         */
         document.getElementById("confirm-response").style.display = "inline";
         document.getElementById("confirm-response").innerHTML = response_message;
         /*
           After delete completed submit button must be enabled
         */
         $(document).find('.submit').prop('disabled',false);
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
