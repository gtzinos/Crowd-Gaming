$(document)
  .on("mouseover",".settingsitem",function(e) {
    if(e.target.nodeName == "A")
    {
      $(e.target).css("background-color","lightgrey")
                 .children().css("background-color","lightgrey");
    }
    $(e.target).css('cursor', 'hand');
  })
  .on("mouseleave",".settingsitem",function(e) {
    if(e.target.nodeName == "A")
    {
      $(e.target).css("background-color","white")
                 .children().css("background-color","white");
    }
    $(e.target).css('cursor', 'pointer');
  });

/*
  Create questionnaire
*/
function createQuestionnaire()
{
  /*
    Initialize variables
  */
  var name = $("#questionnaire-name").val();
  var descriptionHTML = tinymce.activeEditor.getContent();
  var descriptionClearText = tinymce.activeEditor.getContent({format : 'text'});
  var message_required = $("#message-required").val();

  if(name && descriptionClearText.length >= 31)
  {
    var Required = {
        Url() { return webRoot + "questionnaire-create/ajax"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "name=" + name + "&description=" +  descriptionHTML;

          if(message_required == "-") {
              message_required = "no";
          }

          this.variables += "&message_required=" + message_required;

          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "responseCreateQuestionnaire"; },
        ResponseLabel() { return "questionnaire-create-response"; },
        SubmitButton() { return ".submit"; }
      };

      /*
				Send ajax request
			*/
			sendAjaxRequest(Required,Optional);
    }

  else {
    /*
      Cannot be empty
    */
    $("#questionnaire-create-response").show();
    $("#questionnaire-create-response").html("<div class='alert alert-danger'>Questionnaire name and description cannot be empty. </div>");

  }

}

/*
  Response method Create Questionnaire
*/
function responseCreateQuestionnaire()
{
  /*
		if Server responsed back successfully
	*/
	if (xmlHttp.readyState == 4) {
		if (xmlHttp.status == 200) {
      /*
        0			: Created successfully
        1			: Name Validation error
        2			: Description Validation error
        3			: Message Required Error
        4			: Database Error
      */

			/*
				Debug
			*/
			//console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
			{
  			/*
  				After response submit button must be enabled
  			*/
  			$(document).find('.submit').prop('disabled',false);
  			/*
  				Success message
        */
         $("#questionnaire-create-response").show();
         $("#questionnaire-create-response").html("<div class='alert alert-success'>Your questionnaire created successfully.</div>");
         $("#questionnaire-name").val("");
         tinymce.activeEditor.setContent('<p></p>');
         $("#editor").focus();
         $("#message-required").val("-");
         $("#message-required").focus();
         $("#questionnaire-name").focus();
         $("#message-required").focus();
      }

      /*
        If server responsed with an error code
      */
      else {
        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
           Name Validation error
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid questionnaire name.</div>";
        }
        /*
           If response message == 2
           Description Validation error
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid questionnaire description.</div>";
        }
        /*
           If response message == 3
           Message Required Error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid message required option.</div>";
        }
        /*
           If response message == 4
           Database Error
        */
        else if(xmlHttp.responseText.localeCompare("4") == 0)
        {
         response_message += "<div class='alert alert-danger'>General database error. Please try later!</div>";
        }
        /*
           If response message == 5
           Name already exists
        */
        else if(xmlHttp.responseText.localeCompare("5") == 0)
        {
         response_message += "<div class='alert alert-danger'>This questionnaire name already exists.</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Something going wrong. Contact with one administrator!</div>";
        }



       $("#questionnaire-create-response").show();
       $("#questionnaire-create-response").html(response_message);
      }
    }
  }
}

/*
  Update one questionnaire
*/
function updateQuestionnaire(id)
{
  /*
    Initialize the variables
  */
  var name = $(document).find("#qname").val();
  var description = $(document).find("#qeditor").val();
  var required = $(document).find("#mrequired").val();

  /*
    Check the Variables before sending them
  */
  if(name && description && required)
  {
    var Required = {
        Url() { return webRoot + "questionnaire-edit/"; },
        SendType() { return "POST"; },
        Parameters() {
          return "questionnaire-id=" + id + "&name=" + name + "&description=" + description + "&message_required=" + required;
        }
    };
    var Optional = {
      ResponseMethod() { return "responseUpdateQuestionnaire"; },
      ResponseLabel() { return "questionnaire-edit-response"; },
      SubmitButton() { return "edit-questionnaire"; }
    };
    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);

  }
  else
  {
    /*
      Response failed recovery message
    */
    $("#questionnaire-edit-response").show();
    $("#questionnaire-edit-response").html("<div class='alert alert-danger'>Empty fields !!!</div>");
  }
}

/*
  Responsed method (Update Questionnaire)
*/
function responseUpdateQuestionnaire()
{
  /*
    Response code values
    0			: Edited successfully
    1			: Name Validation error
    2			: Description Validation error
    3			: Message Required Error
    4			: Database Error
   */
   /*
 		if Server responsed successfully
 	*/
 	if (xmlHttp.readyState == 4) {
 		if (xmlHttp.status == 200) {
 			/*
 				Debug
 			*/

 			//console.log(xmlHttp.responseText);

 			/*
 			  Enable submit button
 			*/

 			$(document).find('#edit-questionnaire').prop('disabled',false);
      $('#edit-questionnaire').unbind("hidden.bs.modal");
 			/*
 				User can login
 			*/
 			if(xmlHttp.responseText.localeCompare("0") == 0)
 			{
 				/*
 					Redirect to home page
 				*/
        $("#questionnaire-edit-response").show();
        $("#questionnaire-edit-response").html("<div class='alert alert-success'>Questionnaire updated successfully.</div>");
        $('#edit-questionnaire').on('hidden.bs.modal', function () {
   				location.reload();
        });
 			}
 			/*
 				Wrong username or password
 			*/
 			else
 			{
 					/*
 						Display an response message
 					*/

 					var response_message = "";
          /*
 						 If response message == -1
 						 Cant found questionnaire
 					*/
 					if(xmlHttp.responseText.localeCompare("-1") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>We can't found this questionnaire.</div>";
 					}
 					/*
 						 If response message == 1
 						 Not a valid Questionnaire Name.
 					*/
 					else if(xmlHttp.responseText.localeCompare("1") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Questionnaire Name.</div>";
 					}
 					/*
 						 If response message == 2
 						 Not a valid Questionnaire Description
 					*/
 					else if(xmlHttp.responseText.localeCompare("2") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Questionnaire Description.</div>";
 					}
 					/*
 						 If response message == 3
 						 Not a valid Message Required value
 					*/
 					else if(xmlHttp.responseText.localeCompare("3") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Not a valid Message Required value.</div>";
 					}
 					/*
 						 If response message == 4
 						 General Database Error.
 					*/
 					else if(xmlHttp.responseText.localeCompare("4") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>General Database Error.</div>";
 					}
          /*
 						 If response message == 4
 						 Questionnaire name already exists
 					*/
 					else if(xmlHttp.responseText.localeCompare("5") == 0)
 					{
 					 response_message += "<div class='alert alert-danger'>Questionnaire name already exists.</div>";
 					}
 					/*
 							Something going wrong
 					*/
 					else {
 						response_message += "<div class='alert alert-danger'>Unknown error message. Contact with one administrator!</div>";
 					}

 			 	 $("#questionnaire-edit-response").show();
 				 $("#questionnaire-edit-response").html(response_message);
 			}
 		}

 	}
 	/*
 		Server Problem (Timeout probably)
 	*/
 	else {
 			/*
 				TODO Something like
 			*/
 			$("#questionnaire-edit-response").show();
 			$("#questionnaire-edit-response").html("<div class='alert alert-danger'>Server is offline</div>");
 	}
}


/*
  On mouse over on delete user buttons
*/
$(document)
  .on("mouseover","span.remove-user",function(e) {
    $(e.target).css("color","#36A0FF")
               .css('cursor', 'hand');
  })
  .on("mouseleave","span.remove-user",function(e) {
    $(e.target).css("color","#000000")
               .css('cursor', 'pointer');
  });

  /*
    Ask to remove a specific participant
  */
  function remove_participant(user_id,ask_required)
  {
    if(ask_required)
    {
      display_confirm_dialog("Confirm","Are you sure to remove player access of this user ?","btn-default","btn-default","black","remove_participant("+ user_id + ",false)","");
    }
    else {
      var Required = {
          Url() { return webRoot + "delete-questionnaire-participation"; },
          SendType() { return "POST"; },
          variables : "",
          Parameters() {
            /*
              Variables we will send
            */
            this.variables = "questionnaire-id=" + questionnaire_id + "&user-id=" + user_id + "&participation-type=1";
            return this.variables;
          }
        }

        var Optional = {
          ResponseMethod() { return "remove_participant_response(" + user_id + ")"; }
        };

        /*
          Send ajax request
        */
        sendAjaxRequest(Required,Optional);
    }
  }

  /*
    Ask to remove a specific participant
  */
  function remove_participant_response(user_id)
  {
    /*
      if Server responsed back successfully
    */
    if (xmlHttp.readyState == 4) {
      if (xmlHttp.status == 200) {
        /*
          0 : All ok
          1 : Questionnaire doesnt exists
          2 : You must be coordinator
          3 : participation-type must be 1 or 2
          4 : The participation doesnt exist
          5 : You cant remove the coordinator
          6 : Database Error
         -1 : No post data.
        */
        $('#questionnaire-modal').unbind("hidden.bs.modal");

        if(xmlHttp.responseText.localeCompare("0") == 0)
        {
            /*
              Success message
            */
            $("#mitem"+user_id).remove();
            //if was the last user
            if($("[id*=mitem]").length == 0)
            {
              $("#mgroup").html("<label class='alert alert-danger text-center'>There are no members on this questionnaire</label>");
            }
            show_notification("success","User removed successfully.",4000);
            //after modal closed
            $('#questionnaire-modal').on('hidden.bs.modal', function () {
              location.reload();
            });
        }
        /*
          If server responsed with an error code
        */
        else {
          /*
            Display an response message
          */
          var response_message = "";
          /*
             If response message == 1
              Questionnaire doesnt exists
          */
          if(xmlHttp.responseText.localeCompare("1") == 0)
          {
           response_message += "Questionnaire doesnt exists.";
          }
          /*
             If response message == 2
             Access error
          */
          else if(xmlHttp.responseText.localeCompare("2") == 0)
          {
           response_message += "You must be coordinator.";
          }
          /*
             If response message == 3
             participation-type must be 1 or 2
          */
          else if(xmlHttp.responseText.localeCompare("3") == 0)
          {
           response_message += "Participation type must be 1 or 2.";
          }
          /*
             If response message == 4
             The participation doesnt exist
          */
          else if(xmlHttp.responseText.localeCompare("4") == 0)
          {
           response_message += "This user doesn't have a player access.";
          }
          /*
             If response message == 5
             You cant remove the coordinator
          */
          else if(xmlHttp.responseText.localeCompare("5") == 0)
          {
           response_message += "You cant remove the coordinator.";
          }
          /*
             If response message == 6
             Database Error
          */
          else if(xmlHttp.responseText.localeCompare("6") == 0)
          {
           response_message += "General Database Error.";
          }
          /*
             If response message == -1
             No post data.
          */
          else if(xmlHttp.responseText.localeCompare("-1") == 0)
          {
           response_message += "You didn't send data.";
          }
          /*
              Something going wrong
          */
          else {
            response_message += "Unknown error. Contact with one administrator!";
          }

          show_notification("error",response_message,5000);
        }
      }
    }
  }
