/*
  Global variables
*/
var no_completed_request = false;
var users_from_search = [];

function any_no_completed_request()
{
  if(no_completed_request)
  {
    alert("Can't send multiple requests. Please wait");
  }
  return no_completed_request;
}

$(window).on('load',function(e){
  $('#manage-questionnaire-members').on('shown.bs.modal', function() {
          getQuestionnairesICanAccess();
          no_completed_request=false;
          getQuestionnaireMembers();
  });


  $("[data-id=add-questionnaire-member-dropdown]").next().children().children().on('change keyup',function() {

      var client_data = $(this).val();

      $.post(webRoot + "get-users-by-pattern",
      {
        "pattern" : client_data
      },
      function(data,status){
        if(status == "success")
        {
          $("#add-questionnaire-member-dropdown").html('');
          if(data.response_code == "0" && data.users.length > 0)
          {
            users_from_search = data.users;
            var i = 0,
                out = "";
                //alert(users_from_search.length);
            for(i = 0; i < users_from_search.length; i++)
            {
              out += "<option value='" + users_from_search[i].id + "' data-tokens='";

              out += users_from_search[i].name + " " + users_from_search[i].surname + " " + users_from_search[i].email + " ";

              if(users_from_search[i].access == 1)
              {
                  out += "player ";
              }
              else if(users_from_search[i].access == 2)
              {
                out += "moderator ";
              }
              else if(users_from_search[i].access == 3)
              {
                out += "examiner ";
              }

              out += users_from_search[i].gender + " " + users_from_search[i].country + " " +
                     users_from_search[i].city + " " + users_from_search[i].address + " " + users_from_search[i].phone;

              out += "'>" + users_from_search[i].name + " " + users_from_search[i].surname + "</option>";

            }
            $("#add-questionnaire-member-dropdown").html(out);
            $("#add-questionnaire-member-dropdown").selectpicker('refresh');
          }
        }
      });
  //end of keyup change event
  });
  //end of window.load event
});

/*
  Which type to copy (Examiners or players ?)
*/
function copy_questionnaire_members(participation_type)
{
  if(any_no_completed_request()){
    return;
  }
  no_completed_request = true;

  if(questionnaire_id == to_questionnaire_id)
  {
    show_notification("Source and destination questionnaire cannot be the same.");
    return;
  }
  if($("#single-questionnaire-dropdown").val().length > 0)
  {
    var to_questionnaire_id = $("#single-questionnaire-dropdown").val();
    $.post(webRoot + "copy-participants",
    {
      'from-questionnaire-id' : questionnaire_id,
      'to-questionnaire-id' : to_questionnaire_id,
      'participation-type' : participation_type
    },
    function(data,status)
    {
      if(status == "success")
      {
        /*
          0 : All ok
          1 : Participation Type validation error
          2 : FromQuestionnaire Doesnt Exist
          3 : ToQuestionnaire Doesnt Exist
          4 : Invalid Access
        */
        if (data == "0") {
          show_notification("success","Users was copied successfully.",3000);
        }
        else if(data == "1")
        {
          show_notification("error","Not a valid participation type.",4000);
        }
        else if (data == "2") {
          show_notification("error","The target questionnaire doesn't exist.",4000);
        }
        else if (data == "3") {
          show_notification("error","This questionnaire doesnt exists.",4000);
        }
        else if(data == "4") {
          show_notification("error","You dont have the minimum access level.",4000);
        }
        else if(data == "-1") {
          show_notification("error","You didn't send any data.",4000);
        }
        else {
          show_notification("error","Unknown error. Contact us for support." ,4000);
        }
      }
    });
  }
  else {
    show_notification("error","You must select a questionnaire.",4000);
  }
  no_completed_request = false;
}

function getQuestionnaireMembers()
{

  if(any_no_completed_request()){
    return;
  }
  no_completed_request = true;

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
        out += "<option value='" + users[i].id + "' data-tokens='";

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
      }
      $("#questionnaire-members-dropdown").html(out);
      $("#questionnaire-members-dropdown").selectpicker('refresh');
    }
    no_completed_request = false;
  });
}

function getQuestionnairesICanAccess()
{
  if(any_no_completed_request()){
    return;
  }
  no_completed_request = true;

  $("#single-questionnaire-dropdown").find("option").remove();

  $.post(webRoot + "get-my-questionnaires",
  {
  },
  function(data,status){
    if(status == "success")
    {
      var questionnaire = data.questionnaires,
          i = 0,
          out = "";

      for(i=0; i<questionnaire.length;i++)
      {
        out = "<option value='" + questionnaire[i].id + "' data-tokens='";
        if(questionnaire[i].public == 1)
        {
          out += "public ";
        }
        else
        {
          out += "private ";
        }

        if(questionnaire[i].message_required == 1)
        {
          out += "message_required ";
        }
        else {
          out += "nomessage ";
        }

        out += questionnaire[i].creation_date;

        out += "'>" + questionnaire[i].name + "</option>";
        $("#single-questionnaire-dropdown").append(out);
      }
        $("#single-questionnaire-dropdown").find("option[value=" + questionnaire_id + "]").remove();
        $("#single-questionnaire-dropdown").selectpicker('refresh');
    }
    no_completed_request = false;
  });
}
  //type = participation type
  //confirmed = if modal box confirmed
  function delete_members_from_questionnaire(type,confirmed)
  {
    //client protection for multiple requests
    if(any_no_completed_request()){
      return;
    }
    no_completed_request = true;

    var selected_users = [],
        i = 0;

    if($('#questionnaire-members-dropdown').val() == null)
    {
      show_notification("error","Please select some users.",4000);
      no_completed_request = false;
      return;
    }
    else if(!confirmed)
    {
      display_confirm_dialog("Confirm","Are you sure to delete these members of this questionnaire ?","btn-default","btn-default","black","delete_members_from_questionnaire(" + type + ",true)","");
      no_completed_request = false;
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
        $.post(webRoot + "delete-questionnaire-participation",
        {
          "questionnaire-id" : questionnaire_id,
          "user-id" : selected_users[i],
          "participation-type" : type
        },
        function(data,status){
          if(status == "success")
          {
            var user_name = user_results_array[i];
            var type_name = "";
            if(type == 1)
            {
              type_name = "Player";
            }
            else
            {
              type_name = "Examiner";
            }
            /*
              0 : All ok
              1 : Questionnaire doesnt exists
              2 : You must be the coordinator
              3 : participation-type must be 1 or 2
              4 : The participation doesnt exist
              5 : You cant remove the coordinator
              6 : Database Error
              -1 : No post data.
            */
            if(data == "0")
            {
              show_notification("success",type_name + " " + user_name + " was deleted successfully.",4000);
            }
            else if(data == "1")
            {
              show_notification("error","Questionnaire doesnt exists. { " + user_name + " }",6000);
            }
            else if(data == "2")
            {
              show_notification("error","You must be the coordinator. { " + user_name + " }",6000);
            }
            else if(data == "3")
            {
              show_notification("error","The participation must be 'Player' or 'Examiner' { " + user_name + " }",6000);
            }
            else if(data == "4")
            {
              show_notification("error","User " + user_name + " doesn't participate.",6000);
            }
            else if(data == "5")
            {
              show_notification("error","You cant remove the coordinator. { " + user_name + " }",6000);
            }
            else if(data == "6")
            {
              show_notification("error","Database Error. { " + user_name + " }",6000);
            }
            else if(data == "-1")
            {
              show_notification("error","You didn't send any data. { " + user_name + " }",6000);
            }
          }
          no_completed_request = false;
          getQuestionnaireMembers();
        });
      })(i);
    }
  }


  //type = participation type
  //confirmed = if modal box confirmed
  function add_member_on_questionnaire(type,confirmed)
  {
    //client protection for multiple requests
    if(any_no_completed_request()){
      return;
    }
    no_completed_request = true;

    var selected_users = [],
        i = 0;

    var type_name = "";
    if(type == 1)
    {
      type_name = "Player";
    }
    else {
      type_name = "Examiner";
    }

    if($('#add-questionnaire-member-dropdown').val() == null)
    {
      show_notification("error","You must find a user.",4000);
      no_completed_request = false;
      return;
    }
    else if(!confirmed)
    {
      display_confirm_dialog("Confirm","Are you sure to add these user as " + type_name + " of this questionnaire ?","btn-default","btn-default","black","add_member_on_questionnaire(" + type + ",true)","");
      no_completed_request = false;
      return;
    }

    var temp = String($('#add-questionnaire-member-dropdown').val());

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
        user_results_array[i] = String($("#add-questionnaire-member-dropdown option[value=" + selected_users[i] + "]").text());

        $.post(webRoot + "create-questionnaire-participation",
        {
          "questionnaire-id" : questionnaire_id,
          "user-id" : selected_users[i],
          "participation-type" : type
        },
        function(data,status){
          if(status == "success")
          {
            /*
              0 : All ok
              1 : Questionnaire doesnt exists
              2 : You must be the coordinator
              3 : participation-type must be 1 or 2
              4 : The participation doesnt exist
              5 : User already participates
              6 : Database Error
              -1 : No post data.
            */
            if(data == "0")
            {
              show_notification("success",type_name + " " + user_results_array[i] + " was added successfully.",4000);
            }
            else if(data == "1")
            {
              show_notification("error","Questionnaire doesnt exists. { " + user_results_array[i] + " }",6000);
            }
            else if(data == "2")
            {
              show_notification("error","You must be the coordinator. { " + user_results_array[i] + " }",6000);
            }
            else if(data == "3")
            {
              show_notification("error","The participation must be 'Player' or 'Examiner' { " + user_results_array[i] + " }",6000);
            }
            else if(data == "4")
            {
              show_notification("error","User (" + user_results_array[i] + ") doesn't participate",6000);
            }
            else if(data == "5")
            {
              show_notification("error","User already participates. { " + user_results_array[i] + " }",6000);
            }
            else if(data == "6")
            {
              show_notification("error","Database Error. { " + user_results_array[i] + " }",6000);
            }
            else if(data == "-1")
            {
              show_notification("error","You didn't send any data. { " + user_results_array[i] + " }",6000);
            }
          }
          no_completed_request = false;
          getQuestionnaireMembers();
        });
      })(i);
    }
  }
