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
      var keyPressed = $(document).find("#signup-submit").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call sign Up function
        */
        signUp();
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
      var keyPressed = $(document).find("#signin-submit").prop("disabled");
      if(!keyPressed)
      {
        /*
          Call sign In function
        */
        signIn();
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
