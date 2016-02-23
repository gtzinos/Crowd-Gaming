

$(document).ready(function() {
    /*
      If a key pressed (Keyup event)
      in a input-group class then
    */
    $('.input-group input, .input-group textarea, .input-group checkbox, .input-group select').on('keyup change', function() {

      /*
        Initialize variables (Form, div(input-group), button(submit form), span(icon error,success))
      */
      var $form = $(this).closest('form'), //form variable
      $group = $(this).closest('.input-group'), //div input-group
      $button = $(document).find('.submit'); //submit button (use document cause this cant find it)
			$icon = $group.find('span'), //icon (success,error)
      $first_time = false;
			state = false; //default state

      /*
        If is a list
        and selected index was the default one
      */
      if($group.data('validate') == "select")
      {
        if($(this).prop('selectedIndex') == 0)
          $first_time = true;
      }
      /*
        If no value then return
        This is for first time
      */
      else if(!$(this).val())
      {
        $first_time = true;
      }
      /*
        If is a check box and is not checked
      */
      else if(!$(this).prop('checked'))
      {
        /* TODO SOMETHING LIKE
          $first_time = true
        */
      }


      /*
        If group div dont have attribute validate-date="something"
        then we need to have text length >= 1
      */
      if (!$group.data('validate') && !$first_time) {
  			state = $(this).val() ? true : false;
  		}
      /*
        Else If group div have attribute validate-date="email"
        then we need a correct email address
      */
      else if ($group.data('validate') == "email" && !$first_time)
      {
  			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
  		}
      /*
        Else If group div have attribute validate-date="phone"
        then we need a correct phone number
      */
      else if($group.data('validate') == 'phone' && !$first_time) {
  			state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
  		}
      /*
        Else If group div have attribute validate-date="length"
        then we need the correct length.
        so we check if text.length >= attribute data-length="e.g 5"
      */
      else if ($group.data('validate') == "length" && !$first_time)
      {
  			state = $(this).val().length >= $group.data('length') ? true : false;
  		}
      /*
        Else If group div have attribute validate-date="accept-checkbox"
        then we need accept the box
      */
      else if ($group.data('validate') == "accept-checkbox" && !$first_time)
      {
        state = $(this).prop('checked') ? true : false;
      }
      /*
        Else If group div have attribute validate-date="select"
        then we need the user to select another option
        from default one
      */
      else if ($group.data('validate') == "select" && !$first_time)
      {
  			state = $(this).prop('selectedIndex') > 0 ? true : false;
  		}
      /*
        Else If group div have attribute validate-date="number"
        then we need a correct number (1,2,3.5) float type
      */
      else if ($group.data('validate') == "number" && !$first_time) {
  			state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
  		}

      /*
        If it was the first time
        or no value to check
      */
      if($first_time)
      {
        $group.removeClass('has-error');
        $group.removeClass('has-success');
        $icon.attr('class', '');
      }
      /*
        If state was true
        then add a success class icon
      */
  		else if (state)
      {
  				$group.removeClass('has-error');
  				$group.addClass('has-success');
  				$icon.attr('class', 'glyphicon glyphicon-ok form-control-feedback');
  		}
      /*
        Else if state was false
        then add an error class icon
      */
      else if(!state){
          $group.removeClass('has-success');
          $group.addClass('has-error');
  				$icon.attr('class', 'glyphicon glyphicon-remove form-control-feedback');
  		}
      /*
        If user complete successfull the form
        then add button property to enabled
      */
      if ($form.find('.input-group.has-success [required]').length >= 8 && $form.find('.input-group.has-error').length == 0) {
          $button.prop('disabled', false);
      }
      /*
        Else If user didnt complete successfull the form
        then add button property to disabled
      */
      else{
          $button.prop('disabled', true);
      }
  });

  /*
    Close Change trigger
  */
  $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');

});
