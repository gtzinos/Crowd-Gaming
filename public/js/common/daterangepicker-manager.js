/*
  Website : http://www.daterangepicker.com/
  Source : https://github.com/dangrossman/bootstrap-daterangepicker
*/

function create_daterangerpicker(selector,options)
{
  if(options != null)
  {
    $(selector).daterangepicker(options);
  }
  else
  {
    $(selector).daterangepicker();
  }
}
