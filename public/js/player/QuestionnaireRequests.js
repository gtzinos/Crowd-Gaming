/*
  Send Questionnaire request
  variable values :
    #1 - player-join
    #2 - examiner-join
*/
function sendQuestionnaireRequest(request_name,request_value)
{
  $("#send-request-button").attr('name',request_name);
  $("#send-request-button").html(request_value);

  showModal('questionnaire-options');
}
