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
  if(notCompletedRequest == true || $("#delete-publish-request-submit").prop("disabled"))
  {
    return;
  }
  notCompletedRequest = true;

  if(!confirmed)
  {
      display_confirm_dialog("Confirm","Are you sure to cancel this request ?","btn-default","btn-default","black","delete_public_request(true)","");
      return;
  }

  show_spinner("publish-request-spinner");
  $("#delete-publish-request-submit").prop("disabled",true);
  $.ajax({
    method: "POST",
    url: webRoot + "publish-questionnaire-request",
    data: {
      "questionnaire-id" : questionnaire_id,
      "cancel" : true
    }
  })
  .done(function(data){
      /*
        1 : Questionnaire doesn't exist.
        2 : You must be the coordinator to make this request.
        3 : Message Validation Error
        4 : Questionnaire is already public
        5 : Active application already exists
        6 : General Database Error
        -1 : No post data.
      */
      if(data == "0")
      {
        show_notification("success","The request was canceled successfully.",3000);
        setTimeout(function() {
          location.reload();
        },2000);
      }
      else
      {
        if (data == "1")
        {
          show_notification("error","Questionnaire doesn't exist.",4000);
        }
        else if (data == "2")
        {
          show_notification("error","You must be the coordinator to make this request.",4000);
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
          show_notification("error","An An An active application already exists.",4000);
        }
        else if (data == "6")
        {
          show_notification("error","General Database Error.",4000);
        }
        else if (data == "7")
        {
          show_notification("error","There is no active puclication request.",4000);
        }
        else if (data == "-1")
        {
          show_notification("error","You didn't send any data..",4000);
        }
        notCompletedRequest = false;
        remove_spinner("publish-request-spinner");
        $("#delete-publish-request-submit").prop("disabled",false);
      }
  })
  .fail(function(xhr,error)
  {
    displayServerResponseError(xhr,error);
    notCompletedRequest = false;
    remove_spinner("publish-request-spinner");
    $("#delete-publish-request-submit").prop("disabled",false);
  });
}

/*
  Send request to public his questionnaire
*/
function sendPublicRequest()
{
  if(notCompletedRequest == true || $("#publish-request-submit").prop("disabled"))
  {
    return;
  }
  notCompletedRequest = true;
  $("#publish-request-submit").prop("disabled",true);

  var text = $("#publish-request-reason").val();
  show_spinner("publish-request-spinner");

  $.ajax(
  {
      method: "POST",
      url: webRoot + "publish-questionnaire-request",
      data:
      {
        "questionnaire-id" : questionnaire_id,
        "request-text" : text
      }
  })
  .done(function(data){
      /*
        1 : Questionnaire doesn't exist.
        2 : You must be the coordinator to make this request.
        3 : Message Validation Error
        4 : Questionnaire is already public
        5 : Active application already exists
        6 : General Database Error
        -1 : No post data.
      */
      if(data == "0")
      {
        show_notification("success","Request was sent successfully.",3000);
        setTimeout(function() {
          location.reload();
        },2000);
      }
      else {
        if (data == "1")
        {
          show_notification("error","Questionnaire doesn't exist.",4000);
        }
        else if (data == "2")
        {
          show_notification("error","You must be the coordinator to make this request.",4000);
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
          show_notification("error","An An An active application already exists.",4000);
        }
        else if (data == "6")
        {
          show_notification("error","General Database Error.",4000);
        }
        else if (data == "7")
        {
          show_notification("error","There is no active puclication request.",4000);
        }
        else if (data == "-1")
        {
          show_notification("error","You didn't send any data..",4000);
        }
        remove_spinner("publish-request-spinner");
        notCompletedRequest = false;
        $("#publish-request-submit").prop("disabled",false);
      }
  })
  .fail(function(xhr,error){
    displayServerResponseError(xhr,error);
    remove_spinner("publish-request-spinner");
    $("#publish-request-submit").prop("disabled",false);
    notCompletedRequest = false;
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
  var allow_multiple_groups_playthrough = $("#allow_multiple_groups_playthrough").val();
  var message_required = $("#message-required").val();
  var password = $("#questionnaire-password").val();
  var score_rights = $("#score_rights").val();

  if(name && descriptionClearText.length >= 31 && allow_multiple_groups_playthrough != "-")
  {
    /*
      Variables we will send
    */
    var data = {
      "name": name,
      "description": descriptionHTML,
      "allow-multiple-groups-playthrough": allow_multiple_groups_playthrough == "1" ? "1" : "0",
      "message_required": message_required == "yes" ? "yes" : "no"
    }

    if(message_required == "yes")
    {
      data["message"] = password;
    }

    if(score_rights != "-")
    {
      data["score_rights"] = score_rights;
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
    if(notCompletedRequest == true || $("#create-questionnaire-submit").is(':disabled'))
    {
      return;
    }
    var dataToSend = getQuestionnaireData();

    if(dataToSend != null)
    {
      notCompletedRequest = true;
      $('#create-questionnaire-submit').prop('disabled',true);
      show_spinner("create-questionnaire-spinner");
      $.ajax({
        method: "POST",
        url: webRoot + "questionnaire-create/ajax",
        data: dataToSend
      })
      .done(function(data){
        var code = data["response-code"];
        /*
          0			: Created successfully
          1			: Name Validation error
          2			: Description Validation error
          3			: Password Required Error
          4			: Database Error
        */
        if(code == "0")
        {
          /*
            Success message
          */
           show_notification("success","The questionnaire was created successfully..",4000);
           setTimeout(function() {
             window.location.replace(questionnaire_view_page + "/" + data["questionnaire-id"]);
           },3000);
        }
        else {
          /*
             If response message == 1
             Name Validation error
          */
          if(code == "1")
          {
            show_notification("error","This is not a valid questionnaire name.",4000);
          }
          /*
             If response message == 2
             Description Validation error
          */
          else if(code == "2")
          {
            show_notification("error","This is not a valid questionnaire description.",4000);
          }
          /*
             If response message == 3
             Password Required Error
          */
          else if(code == "3")
          {
            show_notification("error","Please select if a password is required..",4000);
          }
          /*
             If response message == 4
             Database Error
          */
          else if(code == "4")
          {
            show_notification("error","General database error. Please try again later!",4000);
          }
          /*
             If response message == 5
             Name already exists
          */
          else if(code == "5")
          {
            show_notification("error","This questionnaire name already exists.",4000);
          }
          /*
              Something going wrong
          */
          else {
            show_notification("error","Something went wrong. Contact us for support.",4000);
          }
          remove_spinner("create-questionnaire-spinner");
        }

      })
      .fail(function(xhr,error){
        displayServerResponseError(xhr,error);
        /*
          After response submit button must be enabled
        */
        $('#create-questionnaire-submit').prop('disabled',false);
        remove_spinner("create-questionnaire-spinner");
      })
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
  var description = tinymce.activeEditor.getContent({format : 'text'});
  var required = $(document).find("#message-required").val();
  var allow_multiple_groups_playthrough = $("#allow-multiple-groups-playthrough").val();
  var score_rights = $("#score_rights").val();

  /*
    Check the Variables before sending them
  */
  if(name && description && required && allow_multiple_groups_playthrough != "-" && score_rights)
  {
    var data = {
      "questionnaire-id": id,
      "name": name,
      "description": description,
      "allow-multiple-groups-playthrough": allow_multiple_groups_playthrough == "1" ? "1" : "0",
      "message_required": required == "yes" ? "yes" : "no",
      "score_rights": score_rights
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
  if(notCompletedRequest == true || $("#edit-questionnaire-submit").is(':disabled'))
  {
    return;
  }

  var dataToSend = getUpdateQuestionnaireData(id);
  if(dataToSend != null)
  {
    notCompletedRequest = true;
    show_spinner("edit-questionnaire-spinner");
    $("#edit-questionnaire-submit").prop("disabled",true);
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
          show_notification("success","Questionnaire was updated successfully..",6000);

          setTimeout(function() {
            location.reload();
          },3000);

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
          show_notification("error","This questionnaire doesn't exist.",4000);
        }
        /*
           If response message == 1
           Not a valid Questionnaire Name.
        */
        else if(data == "1")
        {
         show_notification("error","Not a valid Questionnaire Name.",4000);
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
           Please select if a password is required.
        */
        else if(data == "3")
        {
          show_notification("error","Please select if a password is required.",4000);
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
          show_notification("error","Something  went wrong. Contact us for support.",4000);
        }
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
      $("#edit-questionnaire").prop("disabled",false);
      remove_spinner("edit-questionnaire-spinner");
    });
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
    remove a specific participant
  */
  function remove_participant(user_id,ask_required)
  {
    if(ask_required)
    {
      display_confirm_dialog("Confirm","Are you sure to remove player access of this user ?","btn-default","btn-default","black","remove_participant("+ user_id + ",false)","");
    }
    else {
      $.ajax({
        method: "POST",
        url: webRoot + "delete-questionnaire-participation",
        data: {
          "questionnaire-id": questionnaire_id,
          "user-id": user_id,
          "participation-type": "1"
        }
      })
      .done(function(data){
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

        if(data == "0")
        {
            /*
              Success message
            */
            $("#mitem"+user_id).remove();
            //if was the last user
            if($("[id*=mitem]").length == 0)
            {
              $("#mgroup").html("<label class='alert alert-danger text-center'>There are no members in this queationnaire.</label>");
            }
            show_notification("success","User was removed successfully.",4000);
            //after modal closed
            $('#questionnaire-modal').on('hidden.bs.modal', function () {
              location.reload();
            });
        }
        /*
           If response message == 1
            Questionnaire doesnt exists
        */
        if(data == "1")
        {
          show_notification("error","Questionnaire doesnt exists.",4000);
        }
        /*
           If response message == 2
           Access error
        */
        else if(data == "2")
        {
          show_notification("error","You must be the coordinator.",4000);
        }
        /*
           If response message == 3
           participation-type must be 1 or 2
        */
        else if(data == "3")
        {
          show_notification("error","The participation must be 'Player' or 'Examiner'.",4000);
        }
        /*
           If response message == 4
           The participation doesnt exist
        */
        else if(data == "4")
        {
          show_notification("error","This user doesn't participate as a player..",4000);
        }
        /*
           If response message == 5
           You cant remove the coordinator
        */
        else if(data == "5")
        {
          show_notification("error","You cant remove the coordinator.",4000);
        }
        /*
           If response message == 6
           Database Error
        */
        else if(data == "6")
        {
          show_notification("error","General Database Error.",4000);
        }
        /*
           If response message == -1
           No post data.
        */
        else if(data == "-1")
        {
          show_notification("error","You didn't send any data.",4000);
        }
        /*
            Something going wrong
        */
        else {
          show_notification("error","Unknown error. Contact us for support.",4000);
        }
      })
      .fail(function(xhr,error){
        displayServerResponseError(xhr,error);
      });
    }
  }
