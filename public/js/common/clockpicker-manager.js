/*
  Website : http://weareoutman.github.io/clockpicker/
  Source code : https://github.com/weareoutman/clockpicker
*/

/*
  Inialize a time picker
  #element id,this . . .
  #options is an object with options E.g 'option1' : 'value' , .. ,
*/
var default_options = {
  donetext : 'Done',
  placement: 'top',
  align: 'left',
  beforeShow: function() {
    $('body').on({
          'mousewheel': function(e) {
              if (e.target.id == 'el') return;
              e.preventDefault();
              e.stopPropagation();
           }
    });
  },
  beforeHide: function() {
    $('body').unbind('mousewheel');
  }
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
