/*
  Website : http://hilios.github.io/jQuery.countdown/
  Source : https://github.com/hilios/jQuery.countdown
*/
var default_clock_options = {

};
var flag = 0;
// Countdown initialization
function show_clock(element,finalDate,onFinishMessage = "Your time expired.",onFinishMethod)
{
  $(element).countdown(finalDate)
  //for each update
  .on('update.countdown', function(event){
    flag = 0;
    if (event.offset.totalDays && event.offset.totalDays > 0) {
      $(this).html(event.strftime("%Dd %H:%M:%S"));
    }
    else {
      $(this).html(event.strftime("%H:%M:%S"));
    }
  })
  //when will finish
  .on('finish.countdown', function(event) {
    if(flag != 1 && onFinishMessage != "")
    {
      flag = 1;
      show_notification("error",onFinishMessage,5000);
    }
    $(this).html(event.strftime("%H:%M:%S"));
    if(onFinishMethod != "")
    {
      eval(onFinishMethod);
    }
  });
}
/*
  #No parameters
  YYYY/MM/DD
*/
function getToday()
{
  var month = d.getMonth()+1;
  var day = d.getDate();

  var output = d.getFullYear() + '/' +
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day;

    return output;
}
