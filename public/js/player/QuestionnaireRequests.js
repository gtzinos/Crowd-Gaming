/*
  Options for one questionnaire
  #1 PARAMETER : Questionnaire id (Required)
*/
function optionsForQuestionnaire(questionnaire_id)
{
  showModal("joinQuestionnaire");
}

/*
  #Click join Button
  #Open modal
  #Bind event
*/
function showJoinQuestionnaire(questionnaire_id)
{
  bindMethod("joinQuestionnaire","#join-questionnaire-button","joinQuestionnaire(" + questionnaire_id + ")");
}
/*
  #Click join Button
  #Open modal
  #Bind event
*/
function joinQuestionnaire(questionnaire_id)
{
  var request = $("#request-join-type").val()
  bindMethod("joinQuestionnaire","#join-questionnaire-button","sendQuestionnaireRequest(" + questionnaire_id + ")," + request + ",'#join-questionnaire-response'");
}
/*
  UnJoin one questionnaire
*/
function unJoinQuestionnaire(questionnaire_id)
{
  sendQuestionnaireRequest(questionnaire_id,2,"");
}
/*
  Send request to join questionnaire
*/
function sendQuestionnaireRequest(questionnaire_id,request_type,response_label)
{

  /*
    Check the Variables before sending them
  */
  if(true) {
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
