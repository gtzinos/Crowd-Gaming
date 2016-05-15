/*
  Website : http://hilios.github.io/jQuery.countdown/
  Source : https://github.com/hilios/jQuery.countdown
*/
var default_options = {

};
function show_clock(element,finalDate,strftime="m months %-d days %-H h %M min %S sec",onUpdate = "",onFinish = "")
{
  $(element).countdown(finalDate, function(event) {
    $(this).html(event.strftime(strftime));
  });
}

/*
  #No parameters
  YYYY/MM/DD
*/
function getNow()
{
  var month = d.getMonth()+1;
  var day = d.getDate();

  var output = d.getFullYear() + '/' +
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day;

    return output;
}
