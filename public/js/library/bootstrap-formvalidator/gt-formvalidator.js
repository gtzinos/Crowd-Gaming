var retrieveURL = function(filename) {
    var scripts = document.getElementsByTagName('script');
    if (scripts && scripts.length > 0) {
        for (var i in scripts) {
            if (scripts[i].src && scripts[i].src.match(new RegExp(filename+'\\.js$'))) {
                return scripts[i].src.replace(new RegExp('(.*)'+filename+'\\.js$'), '$1');
            }
        }
    }
};

var dir = retrieveURL("gt-formvalidator");
$(document).ready(function() {
    /*
      Include change focus events
    */
    $.getScript(dir + "/change-focus.js");

    /*
      If a key pressed (Keyup event)
      in a gt-input-group class then
    */
    $('.gt-input-group input, .gt-input-group textarea, .gt-input-group checkbox, .gt-input-group select').on('keyup change focus', function() {
      /*
        Initialize variables (Form, div(gt-input-group), button(submit form), span(icon error,success))
      */
      var first_time = false,
      form = $(this).closest('form'), //form variable
      group = $(this).closest('.gt-input-group'), //div gt-input-group
      input = group.find('> * > .form-control, > .form-control');
      /*
        Find submit button
      */
      var button;
      /*
        Search button from the form
      */
      if(form.find("> * > .gt-submit, > .gt-submit, > * > input[type='submit'], > input[type='submit'], > * > [type='button'], > [type='button'], > * > button, > button").length > 0)
      {
        button = form.find("> * > .gt-submit, > .gt-submit, > * > input[type='submit'], > input[type='submit'], > * > [type='button'], > [type='button'], > * > button, > button");
        /*
          If we can find a button with attribute name = form.name
        */
        if(button.filter("[form='" + form.prop("id") + "']").length)
        {
          button = button.filter("[form='" + form.prop("id") + "']");
        }
      }
      /*
        Search button from the whole document
      */
      else if($(document).find(".gt-submit,input[type='submit'],[type='button'],button").filter("[form='" + form.prop("id") + "']").length > 0)
      {
        button = $(document).find(".gt-submit,input[type='submit'],[type='button'],button").filter("[form='" + form.prop("id") + "']");
      }
      /*
        If something go wrong
      */
      else {
        button = form.find(".gt-submit:first"); //submit button (use document cause this cant find it)
      }

      var icon = group.find('> * > span.gt-icon, > span.gt-icon'), //icon (success,error)
			state = false; //default state
      if(!input.attr("data-placement"))
      {
          input.attr("data-placement","top");
      }
      /*
        If is a list
        and selected index was the default one
      */
      if(group.data('validate') == "select")
      {
        if($(this).find("option:selected").prop('disabled'))
        {
          first_time = true;
        }
      }
      /*
        If no value then return
        This is for first time
      */
      else if(!$(this).val())
      {
        first_time = true;
      }
      /*
        If is a check box and is not checked
      */
      else if(!$(this).prop('checked'))
      {
        /* TODO SOMETHING LIKE
          first_time = true
        */
      }


      /*
        If group div dont have attribute validate-date="something"
        then we need to have text length >= 1
      */
      if (!group.data('validate') && !first_time) {
  			state = $(this).val() ? true : false;
  		}
      /*
        Else If group div have attribute validate-date="email"
        then we need a correct email address
      */
      else if (group.data('validate') == "email" && !first_time)
      {
  			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
  		}
      /*
        Else If group div have attribute validate-date="password"
        then we need a correct password
        1 letter (a-z or A-Z)
        1 Number (0-9)
        1 symbol (#,! . . .)
        8 at least characters
      */
      else if(group.data('validate') == "password" && !first_time)
      {
        state = /[0-9]/.test($(this).val());
        if(state)
        {
          state = /[\'£!$%@#~,=_+¬-]/.test($(this).val());
        }
        if(state)
        {
          state = /[A-Z,a-z]/.test($(this).val());
        }
        if(state)
        {
          /*
            If group div have attribute validate-length="e.g 9"
          */
          if(group.data('length'))
          {
            state = $(this).val().length >= group.data('length') ? true : false;
          }
          /*
            else group div dont have attribute
            validate-length we set a default min = 8
          */
          else {
            state = $(this).val().length >= 8 ? true : false;
          }
        }
      }
      /*
        Else If group div have attribute validate-date="phone"
        then we need a correct phone number
      */
      else if(group.data('validate') == 'phone' && !first_time) {
  			state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
  		}
      /*
        Else If group div have attribute validate-date="length"
        then we need the correct length.
        so we check if text.length >= attribute data-length="e.g 5"
      */
      else if (group.data('validate') == "length" && !first_time)
      {
  			state = $(this).val().length >= group.data('length') ? true : false;
  		}
      /*
        Else If group div have attribute validate-date="accept-checkbox"
        then we need accept the box
      */
      else if(group.data('validate') == "accept-checkbox" && !first_time)
      {
        state = $(this).prop('checked') ? true : false;
      }
      /*
        Else If group div have attribute validate-date="select"
        then we need the user to select another option
        from default one
      */
      else if(group.data('validate') == "select" && !first_time)
      {
  			state = $(this).find("option:selected").prop('disabled') ? false : true;
  		}
      /*
        Else If group div have attribute validate-date="number"
        then we need a correct number (1,2,3.5) float,integer type
      */
      else if (group.data('validate') == "number" && !first_time) {
  			state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val()); //(cant be 02 01 04.4 ..) && !/^0[0-9.,]+$/.test($(this).val());
        /*
           If group div have attribute validate-date="integer"
          then we need a correct number (1,2,3.5) integer type
        */

        if((group.data('type') == "integer" || group.data('type') == "int") && !first_time && state) {
          state = /^(0[1-9]*)|(-?[1-9]+[0-9]*)$/.test($(this).val());
        }
        /*
          If data-min-number is setted then we must check if
          the number is greater that minimum value
        */
        if(group.data('min-number') != undefined && state)
        {
          state = $(this).val() >= group.data('min-number') ? true : false;
        }
        /*
          If data-max-number is setted then we must check if
          the number is greater that minimum value
        */
        if(group.data('max-number') != undefined && state)
        {
          state = $(this).val() <= group.data('max-number') ? true : false;
        }
        if(group.data('number-greater-than') != undefined && state)
        {
          state = $(this).val() > group.data('number-greater-than') ? true : false;
        }
        if(group.data('number-less-than') != undefined && state)
        {
          state = $(this).val() < group.data('number-less-than') ? true : false;
        }
  		}
      /*
        If group div have attribute data-equal="#field-id"
        then we need to compare them
      */
      if(group.data('equal') && state && !first_time)
      {
        state = $(this).val().localeCompare($(document).find('#'+group.data('equal')).val()) == 0 ? true : false;
      }
      /*
        If group div have attribute data-not-equal="#field-id"
        then we need to compare them
      */
      if(group.data('not-equal') && state && !first_time)
      {
        state = $(this).val().localeCompare($(document).find('#'+group.data('not-equal')).val()) != 0 ? true : false;
      }

      /*
        If have a required checkbox
      */
      if(group.data('required-checkbox') && !first_time)
      {
        if(!$(group.data('required-checkbox')).prop("checked"))
        {
          first_time = true;
        }
      }

      /*
        If it was the first time
        or no value to check
      */
      if(first_time)
      {
        group.removeClass('has-error');
        group.removeClass('has-success');
        icon.removeClass('glyphicon glyphicon-ok form-control-feedback');
        icon.removeClass('glyphicon glyphicon-remove form-control-feedback');
      }
      /*
        If state was true
        then add a success class icon
      */
  		else if (state)
      {
  				group.removeClass('has-error');
          icon.removeClass('glyphicon glyphicon-remove form-control-feedback');
          /*
            If have a tooltip attribute
          */
          if(input.attr("data-toggle") && input.attr("data-toggle") == "tooltip")
          {
            input.tooltip('destroy')
                  .removeAttr("data-original-title");
          }
  				group.addClass('has-success');
  				icon.addClass('glyphicon glyphicon-ok form-control-feedback');
  		}
      /*
        Else if state was false
        then add an error class icon
      */
      else if(!state){
          /*
            Remove success class (error-icon)
          */
          group.removeClass('has-success');
          icon.removeClass('glyphicon glyphicon-ok form-control-feedback');
          /*
            If have a tooltip attribute
          */
          if(input.attr("data-toggle") && input.attr("data-toggle") == "tooltip")
          {
            /*
              If attr gt-error-message not initialized
            */
            if(!input.attr("gt-error-message")) input.attr("gt-error-message","Wrong input value.");
            /*
              Else gt-error-message initialized
            */
            else input.attr("data-original-title",input.attr("gt-error-message"));
          }
          /*
            If tooltip is hidden
          */
          input.tooltip('show');
          /*
            Add error class (error-icon)
          */
          group.addClass('has-error');
          /*
            Add error icon
          */
  				icon.addClass('glyphicon glyphicon-remove form-control-feedback');
      }
      /*
        If user complete successfull the form
        then add button property to enabled
      */
      if (form.find('> * > .gt-input-group.has-success [required], > .gt-input-group.has-success').length >= form.find(' > * > .gt-input-group [required], > .gt-input-group [required]').length && form.find('> * > .gt-input-group.has-error, > .gt-input-group.has-error').length == 0) {
          button.prop('disabled', false);
      }
      /*
        Else If user didnt complete successfull the form
        then add button property to disabled
      */
      else{
          button.prop('disabled', true);
      }
  });


});


$.getScript(dir + "/libs/tinymce/tinymce-validator.js");
