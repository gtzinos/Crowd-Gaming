/*
  Website : http://weareoutman.github.io/clockpicker/
  Source code : https://github.com/weareoutman/clockpicker
*/

/*
  Inialize a time picker
  #element id,this . . .
  #options is an object with options E.g 'option1' : 'value' , .. ,
*/
let default_options = {
  donetext : 'Done',
  placement: 'top',
  align: 'left'
}
function initialize_clock_picker(element,options)
{
  if(options != null)
  {
    var initialized_picker = $(element).clockpicker
    (
      options
    );
  }
  else
  {
    var initialized_picker = $(element).clockpicker
    (
      default_options
    );
  }

  return initialized_picker;
}
