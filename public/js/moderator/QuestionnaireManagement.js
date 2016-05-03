/*
  Public Questionnaire selected id
*/
var questionnaire_id,
    questionnaire_index,
    questionnaires = [];


function initialize()
{
  $.fn.bootstrapSwitch.defaults.offText = "<span class='glyphicon glyphicon-lock'> </span>";
  $.fn.bootstrapSwitch.defaults.onText = "<span class='glyphicon glyphicon-globe'> </span>";
  $.fn.bootstrapSwitch.defaults.offColor = 'danger';
  $.fn.bootstrapSwitch.defaults.size = 'small';

  //***ONLY THERE***
  get_questionnaire_i_manage();

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
  $('#questionnaire-management-settings').on('shown.bs.modal', function() {
          getQuestionnaireMembers();
          getAvailableCoordinators();
  });

}


$(window).on('load',function(){
  initialize();
});

/*
  Scroll down
*/
var iScrollPos = 0,
    processing = false;
$(window).scroll(function () {

    var iCurScrollPos = $(this).scrollTop();

    if (iCurScrollPos > iScrollPos) {

      if (processing)
      {
        return false;
      }
      if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.8){
          processing = true; //sets a processing AJAX request flag
          if(questionnaire_offset != 0)
          {
            get_questionnaire_i_manage();
          }
      }
      processing = false;
    }
    iScrollPos = iCurScrollPos;
  });

var questionnaire_offset = 0,
    questionnaire_limit = 10;
function get_questionnaire_i_manage()
{
  //initialize questionnaire sort type
  if(typeof questionnaire_sort == 'undefined' || questionnaire_sort == "")
  {
    questionnaire_sort = "date";
  }

  $.post(webRoot + "get-my-questionnaires",
  {
    'offset' : questionnaire_offset, //default 0
    'limit' : questionnaire_limit, //default 10
    'sort' : questionnaire_sort //default date
  },
  function(data,status)
  {

    if(status == "success")
    {
      var i = 0,
          out = "";
      questionnaires = data.questionnaires;
      if(data.questionnaires.length > 0)
      {
          for(i; i < questionnaires.length; i++)
          {
            out = "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='qitem" + questionnaires[i].id + "'>" +
                        "<div class='col-xs-12'>" +
                            "<h4 class='list-group-item-heading'>" + questionnaires[i].name + "</h4>" +
                        "</div>" +
                        "<div class='col-xs-12' style='margin-top:3%;padding:0px'>" +
                            "<div class='col-xs-4 col-sm-4 col-md-2' style='padding:0px'>" +
                                "<input type='checkbox' id='qcheck" + questionnaires[i].id + "' />" +
                            "</div>" +
                            "<div class='col-xs-offset-1 col-xs-3 col-sm-offset-5 col-sm-3 col-md-offset-8 col-md-2'>" +
                              "<div class='dropdown'>" +
                                  "<span class='dropdown-toggle btn btn-default' type='button' data-toggle='dropdown' onclick='questionnaire_id = " + questionnaires[i].id + "; questionnaire_index = " + i + ";'>Actions " +
                                  "<span class='caret'></span></span>" +
                                  "<ul class='dropdown-menu' >" +
                                    "<li class='settingsitem'><a onclick=\"show_confirm_modal()\"><i class='glyphicon glyphicon-trash'></i> Delete</a></li>" +
                                    "<li class='settingsitem'><a onclick=\"showModal('edit-questionnaire'); return false;\"><i class='glyphicon glyphicon-edit'></i> View logs</a></li>" +
                                    "<li class='settingsitem'><a onclick=\"show_actions_modal()\"><i class='fa fa-cogs'></i> More settings</a></li>" +
                                  "</ul>" +
                              "</div>" +
                            "</div>" +
                        "</div>" +
                    "</div>";
                    $("#questionnaire-list").append(out);
          }
          for(i = 0; i < questionnaires.length; i++)
          {

            $("#qcheck" + questionnaires[i].id).bootstrapSwitch('state',questionnaires[i].public);

            $("#qcheck" + questionnaires[i].id).on('switchChange.bootstrapSwitch', function(event, state) {
              if(state)
              {

                questionnaire_id = $(this).attr('id').replace("qcheck","");
                set_questionnaire_public();
              }
            });
          }
      }
      else if(questionnaire_offset == 0) {
        out = "<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                    "<div class='col-xs-12'>" +
                        "<div class='alert alert-danger'>We don't have any available questionnaire in our database. </div>" +
                    "</div>" +
                "</a>";
        $("#questionnaire-list").append(out);
      }
      questionnaire_offset += 10;
    }
  });
}

function set_questionnaire_public()
{
  $.post(webRoot + "set-questionnaire-public",
  {
    'questionnaire-id' : questionnaire_id
  },
  function(data,status)
  {
    if(status == "success")
    {
      var i = 0;
      for(i=0;i<questionnaires.length;i++)
      {
        if(questionnaires[i].id == questionnaire_id)
        {
          questionnaire_index = i;
          break;
        }
      }
      /*
        0 : All ok
        1 : Questionnaire Doesnt Exist
        2 : Questionnaire Already public
        3 : Database Error
        -1 : No data
      */
      if(data == "0")
      {
        show_notification("success","Questionnaire " + questionnaires[questionnaire_index].name + " is now public.",3000);
      }
      else if(data == "1")
      {
        show_notification("error","Questionnaire " + questionnaires[questionnaire_index].name + " doesn't exist.",4000);
      }
      else if(data == "2")
      {
        show_notification("error","Questionnaire " + questionnaires[questionnaire_index].name + " already public.",4000);
      }
      else if(data == "3")
      {
        show_notification("error","General database error. { " + questionnaires[questionnaire_index].name + " }",4000);
      }
      else if(data == "-1")
      {
          show_notification("error","You didn't send data. { " + questionnaires[questionnaire_index].name + " }",4000);
      }
      else
      {
        show_notification("error","Unknown error. Please contact with us { " + questionnaires[questionnaire_index].name + " }",4000);
      }
    }
  });
}

function show_actions_modal()
{
  showModal('questionnaire-management-settings');
  $('#qtitle-actions-modal').html("<span class='glyphicon glyphicon-lock'></span> Actions for " + questionnaires[questionnaire_index].name);
  $("#questionnaire-deletion-button").bind("click",function() {
    show_confirm_modal(questionnaire_id,questionnaires[questionnaire_index].name);
  });
}

function getQuestionnaireMembers()
{
  $("#questionnaire-members-dropdown").find("option").remove();
  $.post(webRoot + "get-users-from-questionnaire",
  {
    "questionnaire-id" : questionnaire_id
  },
  function(data,status){
    if(status == "success")
    {

      var users = data.users,
          i = 0,
          out = "";
      for(i=0; i<users.length;i++)
      {
        out = "<option value='" + users[i].id + "' data-tokens='";

        out += users[i].email + " ";

        if(users[i].access == 1)
        {
            out += "player ";
        }
        else if(users[i].access == 2)
        {
          out += "moderator ";
        }
        else if(users[i].access == 3)
        {
          out += "examiner ";
        }

        out += users[i].gender + " " + users[i].country + " " +
               users[i].city + " " + users[i].address + " " + users[i].phone;

        out += "'>" + users[i].name + " " + users[i].surname + "</option>";
        $("#questionnaire-members-dropdown").append(out);
      }
        $("#questionnaire-members-dropdown").selectpicker('refresh');
    }
  });
}

function getAvailableCoordinators()
{
  $("#questionnaire-available-coordinators-dropdown").find("option").remove();
  $.post(webRoot + "get-available-coordinators",
  {
    "questionnaire-id" : questionnaire_id
  },
  function(data,status){
    if(status == "success")
    {

      var users = data.users,
          i = 0,
          out = "";
      for(i=0; i<users.length;i++)
      {
        out = "<option value='" + users[i].id + "' data-tokens='";

        out += users[i].email + " ";

        if(users[i].access == 1)
        {
            out += "player ";
        }
        else if(users[i].access == 2)
        {
          out += "moderator ";
        }
        else if(users[i].access == 3)
        {
          out += "examiner ";
        }

        out += users[i].gender + " " + users[i].country + " " +
               users[i].city + " " + users[i].address + " " + users[i].phone;

        out += "'>" + users[i].name + " " + users[i].surname + "</option>";
        $("#questionnaire-available-coordinators-dropdown").append(out);
      }
        $("#questionnaire-available-coordinators-dropdown").selectpicker('refresh');
    }
  });
}


//type = ban , unban
//confirmed = if modal box confirmed
function ban_members_from_questionnaire(action_type,confirmed)
{
  var selected_users = [],
      i = 0;

  if($('#questionnaire-members-dropdown').val() == null)
  {
    show_notification("error","You must select some users.",4000);
    return;
  }
  else if(!confirmed)
  {
    display_confirm_dialog("Confirm","Are you sure to ban these selected members of this questionnaire ?","btn-default","btn-default","black","ban_members_from_questionnaire('" + action_type + "',true)","");
    return;
  }

  var temp = String($('#questionnaire-members-dropdown').val());
  if(temp.indexOf(',') >= 0)
  {
    selected_users = temp.split(",");
  }
  else {
    selected_users[0] = temp;
  }

  var user_results_array = [];
  for(i = 0; i<selected_users.length; i++)
  {
    (function(i)
    {
      user_results_array[i] = String($("#questionnaire-members-dropdown option[value=" + selected_users[i] + "]").text());
      //users.push({ "id" : this.value });
      $.post(webRoot + "ban-user",
      {
        "user-id" : selected_users[i],
        "action-type" : action_type
      },
      function(data,status){
        if(status == "success")
        {
          var user_name = user_results_array[i];
          /*
            0 : All ok
            1 : User doesnt Exist
            2 : Database Error
            3 : invalid action
            4 : Cant ban a moderator
            -1 : No data
          */
          if(data == "0")
          {
            show_notification("success",user_name + " banned successfully.",4000);
          }
          else if(data == "1")
          {
            show_notification("error","User doesnt Exist. { " + user_name + " }",6000);
          }
          else if(data == "2")
          {
            show_notification("error","General database error. { " + user_name + " }",6000);
          }
          else if(data == "3")
          {
            show_notification("error","Invalid action. { " + user_name + " }",6000);
          }
          else if(data == "4")
          {
            show_notification("error","Can't ban a moderator. { " + user_name + " }",6000);
          }
          else if(data == "-1")
          {
            show_notification("error","You didn't send data. { " + user_name + " }",6000);
          }
          else
          {
            show_notification("error","Unknow error.Please contact with us. { " + user_name + " }",6000);
          }
          getQuestionnaireMembers();
        }
      });
      })(i);
  }
}

function show_confirm_modal()
{
  showModal('confirm-questionnaire-deletion');
  $('#qtitle-confirm-deletion-modal').html("<span class='glyphicon glyphicon-lock'></span> Delete questionnaire " + questionnaires[questionnaire_index].name);
  $("#confirm-questionnaire-deletion-button").bind("click",function() {
    delete_questionnaire();
  });
}

function delete_questionnaire()
{
  var password = $("#confirm-password-text").val();
  $.post(webRoot + "delete-questionnaire",
  {
    'questionnaire-id' : questionnaire_id,
    'password' : password
  },
  function(data,status)
  {
    if(status == "success")
    {
      if(data == "0")
      {
        $("#confirm-questionnaire-deletion").modal("hide");
        show_notification("success","Questionnaire deleted successfully.",3000);
        setTimeout(function() {
          location.reload();
        },3000);
      }
      else if(data == "1")
      {
        show_notification("error","Authentication failed. Your password is incorrect.",4000);
      }
      else if(data == "2")
      {
        show_notification("error","Access error.",4000);
      }
      else if(data == "3")
      {
        show_notification("error","General database error.",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data.",4000);
      }
      else
      {
        show_notification("error","Unknow error. Please contact with us.",4000);
      }
    }
  });
  $("#confirm-password-text").val('');
  $("#confirm-password-text").focus();
}

function ban_all_examiners_from_questionnaire()
{
  $.post(webRoot + "ban-examiners-from-questionnaire",
  {
    'questionnaire-id' : questionnaire_id
  },
  function(data,status)
  {
    if(status == "success")
    {
      /*
        0 : All ok
        1 : Database Error
       -1 : No data
      */
      if(data == "0")
      {
        show_notification("success","Questionnaire examiners banned successfully.",3000);
      }
      else if(data == "1")
      {
        show_notification("error","General database error.",4000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didn't send data.",4000);
      }
      else {
        show_notification("error","Unknown error. Please contact with us.",4000);
      }
    }
  });
}

function change_coordinator()
{
  var user_id = $("#questionnaire-available-coordinators-dropdown").val();
  $.post(webRoot + "change-coordinator",
  {
    "questionnaire-id" : questionnaire_id,
    "user-id" : user_id
  },
  function(data,status)
  {
    /*
    0 : All ok
      1 : Questionnaire does not exist
      2 : User doesnt not exist
      3 : User Access Level is lower than Examiner
      4 : Database Error
      -1: No Data
    */
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","Coordinator changed successfully.",3000);
        getAvailableCoordinators();
      }
      else if(data == "1") {
        show_notification("error","Questionnaire does not exist.",4000);
      }
      else if(data == "2") {
        show_notification("error","User does not exist.",4000);
      }
      else if(data == "3") {
        show_notification("error","User access level is lower than examiner.",4000);
      }
      else if(data == "4") {
        show_notification("error","General database error.",4000);
      }
      else if(data == "-1") {
        show_notification("error","You didn't send data.",4000);
      }
      else {
        show_notification("error","Unknown error. Please contact with us.",4000);
      }
    }
  });
}
