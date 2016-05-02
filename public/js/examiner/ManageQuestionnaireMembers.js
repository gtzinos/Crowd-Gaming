
var no_completed_request = false;
function any_no_completed_request()
{
  if(no_completed_request)
  {
    alert("Can't send multiple requests. Please wait");
  }
  return no_completed_request;
}

$(document).ready(function(e){
  $('#manage-questionnaire-members').on('shown.bs.modal', function() {
          getQuestionnairesICanAccess();
          no_completed_request=false;
          getQuestionnaireMembers();
  });
});

function getQuestionnaireMembers()
{
  if(any_no_completed_request()){
    return;
  }
  no_completed_request = true;


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
      show_notification("error","You must select some users.",4000);
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
    selected_users = temp.split(",");

    //var users = [];
    for(i = 0; i<selected_users.length; i++)
    {
        //users.push({ "id" : this.value });
        $.post(webRoot + "delete-questionnaire-participation",
        {
          "questionnaire-id" : questionnaire_id,
          "user-id" : selected_users[i],
          "participation-type" : type
        },
        function(data,status){
          if(status == "success")
          {
            var user_name = $("#questionnaire-members-dropdown option[value='" + selected_users[i] + "']").text();
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
              2 : You must be coordinator
              3 : participation-type must be 1 or 2
              4 : The participation doesnt exist
              5 : You cant remove the coordinator
              6 : Database Error
              -1 : No post data.
            */
            if(data == "0")
            {
              show_notification("success",type_name + " " + user_name + " deleted successfully.",4000);
            }
            else if(data == "1")
            {
              show_notification("error","Questionnaire doesnt exists. { " + user_name + " }",6000);
            }
            else if(data == "2")
            {
              show_notification("error","You must be coordinator. { " + user_name + " }",6000);
            }
            else if(data == "3")
            {
              show_notification("error","Participation type must be 1 or 2. { " + user_name + " }",6000);
            }
            else if(data == "4")
            {
              show_notification("error","The participation doesnt exist. { " + user_name + " }",6000);
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
              show_notification("error","You didn't send data. { " + user_name + " }",6000);
            }
          }
          no_completed_request = false;
          getQuestionnaireMembers();
        });
    }
  }
 $(document).ready(function() {
   $("#find-a-user").on("change keydown",function(e){
   $("#find-a-user").autocomplete({
       source: function(request, response) {
           $.ajax({
               url: webRoot + "get-users-by-pattern",
               dataType: "json",
               data: {
                   "pattern" : $("#find-a-user").val(),
               },
               success: function (data) {
                 response($.map(data.d, function (item) {
                    return {
                       id: item.id,
                       value: item.name + " " + item.surname + " (" + item.email + ")"
                    }
                 }))
               },
               select: function (event, ui) {
                  $(this).data("Selected", item);
               }
           });
       },
       min_length: 3,
       delay: 300
   });
    $( "#find-a-user" ).autocomplete( "option", "appendTo", "#questionnaire-members-form" );
 });

 });
   /*
   $("#find-a-user").on("change keydown",function(e){
     var users_from_search = [];

       var client_data = $('#find-a-user').val();

       $.post(webRoot + "get-users-by-pattern",
       {
         "pattern" : client_data
       },
       function(data,status){
         if(status == "success")
         {
           if(data.response_code == "0" && data.users.length > 0)
           {

             var i = 0;
             for(i = 0; i < data.users.length; i++)
             {
               users_from_search[i] = data.users[i].name + " " + data.users[i].surname + " (" + data.users[i].email + ")";
               //alert(users_from_search[i]);
             }


             $("#find-a-user").autocomplete({
               source: data
             });
             $( "#find-a-user" ).autocomplete( "option", "appendTo", "#questionnaire-members-form" );
           }
         }
       });
   });

 });
*/

  //type = participation type
  //confirmed = if modal box confirmed
  function add_member_on_questionnaire(type,confirmed)
  {
    //client protection for multiple requests
    if(any_no_completed_request()){
      return;
    }
    no_completed_request = true;

    var selected_user_id,
        i = 0;

    var type_name = "";
    if(type == 1)
    {
      type_name = "Player";
    }
    else {
      type_name = "Examiner";
    }

    if($('#find-a-user').val() == "")
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

    selected_user_name = $('#find-a-user').val();

    $.post(webRoot + "create-questionnaire-participation",
    {
      "questionnaire-id" : questionnaire_id,
      "user-id" : selected_user_id,
      "participation-type" : type
    },
    function(data,status){
      if(status == "success")
      {
        var selected_user_id = $("#find-a-user").text();
        /*
          0 : All ok
          1 : Questionnaire doesnt exists
          2 : You must be coordinator
          3 : participation-type must be 1 or 2
          4 : The participation doesnt exist
          5 : User already participates
          6 : Database Error
          -1 : No post data.
        */
        if(data == "0")
        {
          show_notification("success",type_name + " " + user_name + " added successfully.",4000);
        }
        else if(data == "1")
        {
          show_notification("error","Questionnaire doesnt exists. { " + user_name + " }",6000);
        }
        else if(data == "2")
        {
          show_notification("error","You must be coordinator. { " + user_name + " }",6000);
        }
        else if(data == "3")
        {
          show_notification("error","Participation type must be 1 or 2. { " + user_name + " }",6000);
        }
        else if(data == "4")
        {
          show_notification("error","The participation doesnt exist. { " + user_name + " }",6000);
        }
        else if(data == "5")
        {
          show_notification("error","User already participates. { " + user_name + " }",6000);
        }
        else if(data == "6")
        {
          show_notification("error","Database Error. { " + user_name + " }",6000);
        }
        else if(data == "-1")
        {
          show_notification("error","You didn't send data. { " + user_name + " }",6000);
        }
      }
      no_completed_request = false;
    });
  }