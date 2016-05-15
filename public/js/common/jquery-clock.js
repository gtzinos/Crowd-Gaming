/*
  Website : http://hilios.github.io/jQuery.countdown/
  Source : https://github.com/hilios/jQuery.countdown
*/
var default_options = {

};
// Countdown initialization
function show_clock(element,finalDate,strftime="%m months %-d days %-H h %M min %S sec",onUpdate = "",onFinish = "")
{
  $(element).countdown(finalDate)
  //for each update
  .on('update.countdown', function(event){
    if (event.offset.totalDays && event.offset.totalDays > 0) {
      $(this).html(event.strftime("%Dd %H:%M:%S"));
    }
    else {
      $(this).html(event.strftime("%H:%M:%S"));
    }
  })
  //when will finish
  .on('finish.countdown', function(event) {
    show_notification("error","Your time expired.",5000);
    $(this).html(event.strftime("%H:%M:%S"));
    setTimeout(function() {
      location.reload(); //back to my questionnaires
    },5000);
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
