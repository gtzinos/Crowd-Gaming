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
