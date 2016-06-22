var loginCaptcha,
    registerCaptcha,
    contactCaptcha;
$(window).load(function() {
    $('.g-recaptcha').each(function(index,el){
      //grecaptcha.render(el,{'sitekey' : googleReCaptchaKey});
      //$(el).attr("data-sitekey","6LeluyETAAAAADhNCPmzGYok8f1jfKYgRr36T33A");
    });

    if($("#login-recaptcha").length == 1)
    {
      loginCaptcha = grecaptcha.render('login-recaptcha', { 'sitekey' : '6LeluyETAAAAADhNCPmzGYok8f1jfKYgRr36T33A' });
    }
    if($("#register-recaptcha").length == 1)
    {
      registerCaptcha = grecaptcha.render('register-recaptcha', { 'sitekey' : '6LeluyETAAAAADhNCPmzGYok8f1jfKYgRr36T33A' });
    }
    if($("#contact-recaptcha").length == 1)
    {
      contactCaptcha = grecaptcha.render('contact-recaptcha', { 'sitekey' : '6LeluyETAAAAADhNCPmzGYok8f1jfKYgRr36T33A' });
    }
});

/*
  Include javascript file from a javascript file
*/
var head = document.getElementsByTagName('head')[0];
var script;
var include =
  function(path)
  {
   script = document.createElement('script');
   script.type = 'text/javascript';
   script.src = path;
   head.appendChild(script);
 };

/*
  Display error message
  #Parameter 1 : xhr
  #Parameter 2 : error
*/
function displayServerResponseError(xhr,error)
{
    if(xhr.status==0)
    {
    	show_notification("error","Please check your internet connection.",4000);
  	}
    else if(xhr.status==404)
    {
  	   show_notification("error","Requested URL not found.",4000);
  	}
    else if(xhr.status==500)
    {
  	   show_notification("error","Internel Server Error.",4000);
  	}
    else if(error == 'parsererror')
    {
      show_notification("error","Error.Parsing JSON Request failed.",4000);
  	}
    else if(error == 'timeout')
    {
  	   show_notification("error","Request Time out.",4000);
  	}
    else
    {
  	   show_notification("error","Unknown Error. Message: " + xhr.responseText,4000);
  	}
}

/*
  Bind a Method on an element
  #1 PARAMETER : Modal Name (Optional)
  #2 Element Name (Required)
  #3 PARAMETER : Method Name (Required)
*/
function bindMethod(modal,element,method)
{
    if(modal != "")
    {
      showModal(modal);
    }
    /*
      Set on click listener
      on #confirm-button
    */
    $(element).unbind( "click" );
    $(element).bind( "click", function() {
      /*
        parameter name method + ()
        call e.g updateProfile()
      */
      eval(method + '()');
    } );

}


/*
  Close all opened modals
  and open a new one
*/
function showModal(modalName)
{
  /*
    Close opened modals
  */
  $('.modal').modal('hide');
  /*
    Clear all response labels
  */
  $(document).find('.responseLabel').html('');
  /*
    Open the new one after one second
  */
  setTimeout(function() {
        $('#' + modalName).modal('show');
  },1000);
  return false;
}

/*
  Keypress event on login / register forms
*/
function keyPressForm(e) {
  /*
    If key pressed was enter
    then try to login
  */
  if(e.which == 13)
  {

    /*
      If register modal is opened
      then try to register
    */

    if(($("#registerModal").data('bs.modal') || {}).isShown)
    {
      /*
        If submit button is activated
      */
      var keyPressed = $(document).find(".submit").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call sign Up function
        */
        signUpFromForm();
      }
      /*
        End
      */
      return;
    }
    /*
      Else if Register modal is opened
    */
    else if(($("#loginModal").data('bs.modal') || {}).isShown)
    {
      /*
        If submit button is activated
      */
      var keyPressed = $(document).find(".submit").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call sign In function
        */
        signInFromForm();
      }
      /*
        End
      */
      return;
    }
    /*
      Else if Register modal is opened
    */
    else if(($("#confirmPassword").data('bs.modal') || {}).isShown)
    {
      /*
        Cancel default action from the enter key
        E.g (Send form data)
      */
      event.preventDefault();
      /*
        If submit button is activated
      */
      var keyPressed = $(document).find("#confirm-button").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call confirm-button on click function
        */
        $("#confirm-button").click();
      }
      /*
        End
      */
      return;
    }
    /*
      Else if Reset Password modal is opened
    */
    else if(($("#PasswordRecoveryModal").data('bs.modal') || {}).isShown)
    {
      /*
        Cancel default action from the enter key
        E.g (Send form data)
      */
      event.preventDefault();
      /*
        If submit button is activated
      */
      var keyPressed = $(document).find("#recovery-button").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call confirm-button on click function
        */
        $("#recovery-button").click();
      }
      /*
        End
      */
      return;
    }
    /*
      Else if is a contact form then ...
      TODO Call contactForm
    */
  }

}

/*
  Reload page after #Parameter1 seconds
  #Parameter 1 : X seconds
*/
function reloadPage(afterSeconds)
{
  setTimeout(function() {
        location.reload();
  },afterSeconds);
}
