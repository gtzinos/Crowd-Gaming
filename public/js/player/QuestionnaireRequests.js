/*
  #Click join Button
  #Open modal
  #Bind event
*/
function joinQuestionnaire(questionnaire_id)
{
  bindMethod("joinQuestionnaire","#join-questionnaire-button","sendQuestionnaireRequest(" + questionnaire_id + ",1)");
}

/*
  Send request to join questionnaire
*/
function sendQuestionnaireRequest(questionnaire_id,request_type)
{

  /*
    Check the Variables before sending them
  */

  if(userEmail && userPassword)
  {
    var Required = {
        Url() { return webRoot + "signin"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "email=" + userEmail + "&password=" +  userPassword;

          /*
            If user needs to remember him
          */
          if(userRememberMe == "true")
          {
            this.variables += "&remember=true";
          }

          return this.variables;
        }
    };
    var Optional = {
      ResponseMethod() { return "responseSignIn"; },
      DelayTime() { return 1500; },
      ResponseLabel() { return "signin-response"; },
      SpinnerLoader() { return "signin-spinner"; },
      SubmitButton() { return ".submit"; }
    };
    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);

  }
  else
  {
    /*
      Response failed login message
    */
    $("#signin-response").show();
    $("#signin-response").html("<div class='alert alert-danger'>Username or Password cannot be empty. </div>");
  }
}
