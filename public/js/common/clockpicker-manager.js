/*
  Inialize a time picker
  #element id,this . . .
  #options is an object with options E.g 'option1' : 'value' , .. ,
*/
let default_options = {
  donetext : 'Done'
}
function initialize_clock_picker(element,options)
{
  var initialized_picker = $(element).clockpicker
  (
    options
  );

  return initialized_picker;
}
