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

$(window).load(function() {
  //on password required list change
  $("#message-required").on("change",function(){
    if(this.value == "yes")
    {
      $("#questionnaire-password").prop("disabled",false)
                                  .prop("required",true)
                                  .trigger('change');
    }
    else
    {
      $("#questionnaire-password")
            .prop("disabled",true)
            .removeAttr("required")
            .val("")
            .trigger('change');
    }

  });

  $("#datepicker").on('show.daterangepicker',function() {
    $('body').on({
          'mousewheel': function(e) {
              if (e.target.id == 'el') return;
              e.preventDefault();
              e.stopPropagation();
           }
    });
  });
  $("#datepicker").on('hide.daterangepicker',function() {
      $('body').unbind('mousewheel');
  });
});

function delete_public_request(confirmed)
{
  if(!confirmed)
  {
      display_confirm_dialog("Confirm","Are you sure to cancel this request ?","btn-default","btn-default","black","delete_public_request(true)","");
      return;
  }

  $.post(webRoot + "publish-questionnaire-request",
  {
    "questionnaire-id" : questionnaire_id,
    "cancel" : true
  },
  function(data,status){
    if(status == "success")
    {
      /*
        1 : Questionnaire doesnt work.
        2 : You must be coordinator to make the request.
        3 : Message Validation Error
        4 : Questionnaire is already public
        5 : Active application already exists
        6 : General Database Error
        -1 : No post data.
      */
      if(data == "0")
      {
        show_notification("success","Request canceled successfully.",3000);
        setTimeout(function() {
          location.reload();
        },3000);
      }
      else if (data == "1")
      {
        show_notification("error","Questionnaire doesnt work.",4000);
      }
      else if (data == "2")
      {
        show_notification("error","You must be coordinator to make the request.",4000);
      }
      else if (data == "3")
      {
        show_notification("error","This is not a valid message.",4000);
      }
      else if (data == "4")
      {
        show_notification("error","Questionnaire is already public.",4000);
      }
      else if (data == "5")
      {
        show_notification("error","Active application already exists.",4000);
      }
      else if (data == "6")
      {
        show_notification("error","General Database Error.",4000);
      }
      else if (data == "7")
      {
        show_notification("error","There is no active publish application.",4000);
      }
      else if (data == "-1")
      {
        show_notification("error","You didnt send data.",4000);
      }
    }
  });
}

/*
  Send request to public his questionnaire
*/
function sendPublicRequest()
{
  var text = $("#required-message").val();
  $.post(webRoot + "publish-questionnaire-request",
  {
    "questionnaire-id" : questionnaire_id,
    "request-text" : text
  },
  function(data,status){
    if(status == "success")
    {
      /*
        1 : Questionnaire doesnt work.
        2 : You must be coordinator to make the request.
        3 : Message Validation Error
        4 : Questionnaire is already public
        5 : Active application already exists
        6 : General Database Error
        -1 : No post data.
      */
      if(data == "0")
      {
        show_notification("success","Request sended successfully.",3000);
        setTimeout(function() {
          location.reload();
        },3000);
      }
      else if (data == "1")
      {
        show_notification("error","Questionnaire doesnt work.",4000);
      }
      else if (data == "2")
      {
        show_notification("error","You must be coordinator to make the request.",4000);
      }
      else if (data == "3")
      {
        show_notification("error","This is not a valid message.",4000);
      }
      else if (data == "4")
      {
        show_notification("error","Questionnaire is already public.",4000);
      }
      else if (data == "5")
      {
        show_notification("error","Active application already exists.",4000);
      }
      else if (data == "6")
      {
        show_notification("error","General Database Error.",4000);
      }
      else if (data == "7")
      {
        show_notification("error","There is no active publish application.",4000);
      }
      else if (data == "-1")
      {
        show_notification("error","You didnt send data.",4000);
      }
    }
  });
}

function getQuestionnaireData()
{
  /*
    Initialize variables
  */
  var name = $("#questionnaire-name").val();
  var descriptionHTML = tinymce.activeEditor.getContent();
  var descriptionClearText = tinymce.activeEditor.getContent({format : 'text'});
  var message_required = $("#message-required").val();
  var password = $("#questionnaire-password").val();

  if(name && descriptionClearText.length >= 31)
  {
    /*
      Variables we will send
    */
    let data = {
      "name": name,
      "description": descriptionHTML,
      "message_required": message_required == "yes" ? "yes" : "no"
    }

    if(message_required == "yes")
    {
      data["message"] = password;
    }

    return data;
  }
  else
  {
    return null;
  }
}
/*
  Create questionnaire
*/
function createQuestionnaire()
{
    var dataToSend = getQuestionnaireData();

    if(dataToSend != null)
    {
      $('.submit').prop('disabled',true);
      $.ajax({
        method: "POST",
        url: webRoot + "questionnaire-create/ajax",
        data: dataToSend
      })
      .done(function(data){
        /*
          0			: Created successfully
          1			: Name Validation error
          2			: Description Validation error
          3			: Password Required Error
          4			: Database Error
        */
        if(data == "0")
        {
          /*
            Success message
          */
           show_notification("success","Your questionnaire created successfully.",4000);
           $("#questionnaire-name").val("");
           tinymce.activeEditor.setContent('<p></p>');
           $("#editor").focus();
           $("#message-required").val("-");
           $("#message-required").focus();
           $("#questionnaire-name").focus();
           $("#message-required").focus();
        }
        /*
           If response message == 1
           Name Validation error
        */
        else if(data == "1")
        {
          show_notification("error","This is not a valid questionnaire name.",4000);
        }
        /*
           If response message == 2
           Description Validation error
        */
        else if(data == "2")
        {
          show_notification("error","This is not a valid questionnaire description.",4000);
        }
        /*
           If response message == 3
           Password Required Error
        */
        else if(data == "3")
        {
          show_notification("error","This is not a valid password required option.",4000);
        }
        /*
           If response message == 4
           Database Error
        */
        else if(data == "4")
        {
          show_notification("error","General database error. Please try later!",4000);
        }
        /*
           If response message == 5
           Name already exists
        */
        else if(data == "5")
        {
          show_notification("error","This questionnaire name already exists.",4000);
        }
        /*
            Something going wrong
        */
        else {
          show_notification("error","Something going wrong. Contact with one administrator!",4000);
        }
      })
      .fail(function(xhr,error){
        displayServerResponseError(xhr,error);
      })
      .always(function() {
        /*
          After response submit button must be enabled
        */
        $('.submit').prop('disabled',false);
      });
  }
  else {
    /*
      Cannot be empty
    */
    show_notification("error","Questionnaire name and description cannot be empty.",4000);
  }
}

//get update questionnaire data
function getUpdateQuestionnaireData(id) {
  /*
    Initialize the variables
  */
  var name = $(document).find("#qname").val();
  var description = $(document).find("#qeditor").val();
  var required = $(document).find("#message-required").val();

  /*
    Check the Variables before sending them
  */
  if(name && description && required)
  {
    let data = {
      "questionnaire-id": id,
      "name": name,
      "description": description,
      "message_required": required == "yes" ? "yes" : "no"
    };
    if(required == "yes")
    {
      data["message"] = $("#questionnaire-password").val();
    }
    return data;
  }
  else
  {
    return null;
  }
}
/*
  Update one questionnaire
*/
function updateQuestionnaire(id)
{
  var dataToSend = getUpdateQuestionnaireData(id);
  if(dataToSend != null)
  {
    $("#edit-questionnaire").prop("disabled",true);
    $.ajax({
      method: "POST",
      url: webRoot + "questionnaire-edit/",
      data: dataToSend
    })
    .done(function(data){
        /*
          Response code values
          0			: Edited successfully
          1			: Name Validation error
          2			: Description Validation error
          3			: Password Required Error
          4			: Database Error
         */
         /*
          if Server responsed successfully
        */
        $('#edit-questionnaire').unbind("hidden.bs.modal");
        /*
          User can login
        */
        if(data == "0")
        {
          /*
            Redirect to home page
          */
          show_notification("error","Questionnaire updated successfully.",4000);
          $('#edit-questionnaire').on('hidden.bs.modal', function () {
            location.reload();
          });
        }
        /*
           If response message == -1
           Cant found questionnaire
        */
        else if(data == "-1")
        {
          show_notification("error","We can't found this questionnaire.",4000);
        }
        /*
           If response message == 1
           Not a valid Questionnaire Name.
        */
        else if(data == "1")
        {
         response_message += "<div class='alert alert-danger'>Not a valid Questionnaire Name.</div>";
        }
        /*
           If response message == 2
           Not a valid Questionnaire Description
        */
        else if(data == "2")
        {
          show_notification("error","Not a valid Questionnaire Description.",4000);
        }
        /*
           If response message == 3
           Not a valid Password Required value
        */
        else if(data == "3")
        {
          show_notification("error","Not a valid password required value",4000);
        }
        /*
           If response message == 4
           General Database Error.
        */
        else if(data == "4")
        {
          show_notification("error","General Database Error.",4000);
        }
        /*
           If response message == 4
           Questionnaire name already exists
        */
        else if(data == "5")
        {
          show_notification("error","Questionnaire name already exists.",4000);
        }
        /*
            Something going wrong
        */
        else {
          show_notification("error","Unknown error message. Contact with one administrator!",4000);
        }
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
    })
    .always(function() {
      $("#edit-questionnaire").prop("disabled",false);
    })
  }
  else
  {
    /*
      Response failed recovery message
    */
    show_notification("error","Please fill all required fields.",4000);
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
