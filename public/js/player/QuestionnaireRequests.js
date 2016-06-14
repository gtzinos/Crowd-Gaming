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

$(window).on("load",function()
{
  show_clock(".count-down",moment().add(time_left,'minutes').format("YYYY/MM/DD HH:mm:00"),"%m months %-d days %-H h %M min %S sec","Questionnaire started. Page will reload.");
});
