$(document).ready(function(e) {


tinymce.init({
      selector: "textarea.mce-editor",
      theme: 'modern',
      menubar: 'file edit insert view format table tools',
      plugins: [
        'advlist autolink lists link image print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'save table contextmenu directionality',
        'emoticons paste textcolor colorpicker textpattern imagetools spellchecker'
      ],
      toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      toolbar2: 'print preview media | forecolor backcolor emoticons spellchecker',
      image_advtab: true,
      removed_menuitems: 'newdocument',
      spellchecker_callback: function(method, text, success, failure) {
          var words = text.match(this.getWordCharPattern());
          if (method == "spellcheck") {
              var suggestions = {};
              if(words != null)
              {
                for (var i = 0; i < words.length; i++) {
                  suggestions[words[i]] = ["First", "Second"];
                }
              }
              success(suggestions);
          }
      },
      setup : function(ed) {

        ed.on("change focus keyup", function(e){
            /*
              Initialize variables (Form, div(gt-input-group), button(submit form), span(icon error,success))
            */
            var first_time=false,
            form = $("textarea.mce-editor").closest('form'), //form variable
            group = $("textarea.mce-editor").closest('.gt-input-group'), //div gt-input-group
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
              if(button.filter("[form='" + form.prop("name") + "']").length)
              {
                button = button.filter("[form='" + form.prop("name") + "']");
              }
            }
            /*
              Search button from the whole document
            */
            else if($(document).find(".gt-submit,input[type='submit'],[type='button'],button").filter("[form='" + form.prop("name") + "']").length > 0)
            {
              button = $(document).find(".gt-submit,input[type='submit'],[type='button'],button").filter("[form='" + form.prop("name") + "']");
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

            var text = tinymce.activeEditor.getContent({format : 'text'});

            /*
              If is a list
              and selected index was the default one
            */
            if(group.data('validate') == "select")
            {
              if($("textarea.mce-editor").prop('selectedIndex') == 0)
                first_time = true;
            }
            /*
              If no value then return
              This is for first time
            */

            else if(text.length == 0)
            {
              first_time = true;
            }
            /*
              If is a check box and is not checked
            */
            else if(!$("textarea.mce-editor").prop('checked'))
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
        			state = text.length >= 0 ? true : false;
        		}
            /*
              Else If group div have attribute validate-date="email"
              then we need a correct email address
            */
            else if (group.data('validate') == "email" && !first_time)
            {
        			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(text)
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
              state = /[0-9]/.test(text);
              if(state)
              {
                state = /[\'£!$%@#~,=_+¬-]/.test(text);
              }
              if(state)
              {
                state = /[A-Z,a-z]/.test(text);
              }
              if(state)
              {
                /*
                  If group div have attribute validate-length="e.g 9"
                */
                if(group.data('length'))
                {
                  state = text.length >= group.data('length') ? true : false;
                }
                /*
                  else group div dont have attribute
                  validate-length we set a default min = 8
                */
                else {
                  state = text.length >= 8 ? true : false;
                }
              }
            }
            /*
              Else If group div have attribute validate-date="phone"
              then we need a correct phone number
            */
            else if(group.data('validate') == 'phone' && !first_time) {
        			state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test(text)
        		}
            /*
              Else If group div have attribute validate-date="length"
              then we need the correct length.
              so we check if text.length >= attribute data-length="e.g 5"
            */
            else if (group.data('validate') == "length" && !first_time)
            {
        			state = text.length >= group.data('length') ? true : false;
        		}
            /*
              Else If group div have attribute validate-date="accept-checkbox"
              then we need accept the box
            */
            else if (group.data('validate') == "accept-checkbox" && !first_time)
            {
              state = $("textarea.mce-editor").prop('checked') ? true : false;
            }
            /*
              Else If group div have attribute validate-date="select"
              then we need the user to select another option
              from default one
            */
            else if (group.data('validate') == "select" && !first_time)
            {
        			state = $("textarea.mce-editor").prop('selectedIndex') > 0 ? true : false;
        		}
            /*
              Else If group div have attribute validate-data="words"
              then we need at least x words
            */
            else if (group.data('validate') == "words" && !first_time)
            {
        			state = $("textarea.mce-editor").prop('selectedIndex') > 0 ? true : false;
        		}
            /*
              Else If group div have attribute validate-date="number"
              then we need a correct number (1,2,3.5) float type
            */
            else if (group.data('validate') == "number" && !first_time) {
        			state = !isNaN(parseFloat(text)) && isFinite(text);
        		}
            /*
              If group div have attribute data-equal="#field-id"
              then we need to compare them
            */
            if(group.data('equal') && state && !first_time)
            {
              state = text.localeCompare($(document).find('#'+group.data('equal')).val()) == 0 ? true : false;
            }
            /*
              If group div have attribute data-not-equal="#field-id"
              then we need to compare them
            */
            if(group.data('not-equal') && state && !first_time)
            {
              state = text.localeCompare($(document).find('#'+group.data('not-equal')).val()) != 0 ? true : false;
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
            if (form.find('> * > .gt-input-group.has-success [required], > .gt-input-group.has-success').length >= form.find('> * > .gt-input-group [required]').length && form.find('> * > .gt-input-group.has-error').length == 0) {
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
      }
});
})
