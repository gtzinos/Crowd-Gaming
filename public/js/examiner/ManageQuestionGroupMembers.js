var selected_user_id;
$(window).on('load',function(e) {
  $('#question-group-users').on('shown.bs.modal', function() {
    get_question_groups();
  });

  $('#single-group-dropdown').on('changed.bs.select', function (e) {
      selected_group_id = e.target.value;
      getQuestionGroupUsers();
      getQuestionnaireMembers();
  });
});

function add_user_on_question_group()
{
  if($("#questionnaire-users-dropdown").val() == null)
  {
    show_notification("error","Please select some users.",5000);
    return;
  }
  var users_array,
      i = 0;
  if(String($("#questionnaire-users-dropdown").val()).indexOf(',') > 0)
  {
    users_array = String($("#questionnaire-users-dropdown").val()).split(',');
  }
  else {
    users_array = String($("#questionnaire-users-dropdown").val());
  }

var user_name_array = [];
  for(i = 0; i<users_array.length; i++)
  {
    (function(i)
    {
      user_name_array[i] = String($("#questionnaire-users-dropdown option[value=" + users_array[i] + "]").text());

      $.post(webRoot + "add-user-to-question-group",
      {
        "question-group-id" : selected_group_id,
        "user-id" : users_array[i]
      },
      function(data,status){
        if(status == "success")
        {
            var user_name = user_name_array[i];

            if(data == "0")
            {
              /*
                0 : All ok
                1 : Invalid access
                2 : User already participates to that question group
                3 : User doesnt participate to this questionnaire
                4 : General database error
               -1 : No post data;
              */
              show_notification("success","User added successfully (" + user_name + ").",3000);
            }
            else if(data == "1")
            {
              show_notification("error","You don't have the minimum access level (" + user_name + ").",5000);
            }
            else if(data == "2")
            {
              show_notification("error","User (" + user_name + ") already participates in that question group.",5000);
            }
            else if(data == "3")
            {
              show_notification("error","User " + user_name + " doesn't participate in this questionnaire.",5000);
            }
            else if(data == "4")
            {
              show_notification("error","General database error (" + user_name + ").",5000);
            }
            else if(data == "-1")
            {
              show_notification("error","You didnt send any data (" + user_name + ").",5000);
            }
            else
            {
              show_notification("error","Unknown error. Contact us for support. (" + user_name + ").",5000);
            }
          }
      });
      })(i);
    }
    getQuestionnaireMembers();
    getQuestionGroupUsers();
}

function delete_user_from_question_group()
{
  if($("#question-group-users-dropdown").val() == null)
  {
    show_notification("error","Please select some users.",5000);
    return;
  }
  var users_array,
      i = 0;
  if(String($("#question-group-users-dropdown").val()).indexOf(',') > 0)
  {
    users_array = String($("#question-group-users-dropdown").val()).split(',');
  }
  else {
    users_array = String($("#question-group-users-dropdown").val());
  }
  var user_name_array = [];
  for(i = 0; i<users_array.length; i++)
  {
    (function(i)
    {
      user_name_array[i] = String($("#question-group-users-dropdown option[value=" + users_array[i] + "]").text());

      $.post(webRoot + "remove-user-from-question-group",
      {
        "question-group-id" : selected_group_id,
        "user-id" : users_array[i]
      },
      function(data,status){
        if(status == "success")
        {
          var user_name = user_name_array[i];
            if(data == "0")
            {
              /*
                0 : All ok
                1 : Invalid access
                2 : Participation Doesnt exist
                3 : General database error
               -1 : No post data;
              */
              show_notification("success","User deleted successfully (" + user_name + ").",4000);
            }
            else if(data == "1")
            {
              show_notification("error","You don't have the minimum access level (" + user_name + ").",5000);
            }
            else if(data == "2")
            {
              show_notification("error","User " + user_name + " doesn't participate in this question group.",5000);
            }
            else if(data == "4")
            {
              show_notification("error","General database error (" + user_name + ").",5000);
            }
            else if(data == "-1")
            {
              show_notification("error","You didn't any send data (" + user_name + ").",5000);
            }
            else
            {
              show_notification("error","Unknown error. Contact us for support (" + user_name + ").",5000);
            }
          }
      });
      })(i);
    }
    getQuestionnaireMembers();
    getQuestionGroupUsers();
}

function get_question_groups()
{
  $("#single-group-dropdown").find("option").remove();
  $.post(webRoot + "get-all-question-groups",
  {
    "questionnaire-id" : questionnaire_id
  },
  function(data,status){
    if(status == "success")
    {
      /*
        0 all ok
        1 Questionnaires doesnt exist
        2 You dont have access
      */
      if(data.response_code == "0")
      {
        //alert(JSON.stringify(data));
        var groups = data.groups,
            i = 0,
            out = "";

        for(i=0; i<groups.length;i++)
        {
          out = "<option value='" + groups[i].id + "' data-tokens='";
          if(groups[i].longitude != ":null")
          {
            out += "longitude:" + groups[i].longitude + " ";
          }

          if(groups[i].latitude != ":null")
          {
            out += "latitude:" + groups[i].latitude + " ";
          }

          if(groups[i].radius != ":null")
          {
            out += "radius:" + groups[i].radius + " ";
          }
          out += groups[i].creation_date + " ";

          //
          out += "'>" + groups[i].name + "</option>";
          $("#single-group-dropdown").append(out);
        }
        $("#single-group-dropdown").selectpicker('refresh');
      }
      else if(data.response_code == "1")
      {
        show_notification("error","Questionnaire doesnt exist.",5000);
      }
      else if(data.response_code == "2")
      {
        show_notification("error","You dont have access.",5000);
      }
      else {
        show_notification("error","Unknown error. Contact us for support.",5000);
      }
    }
  });
  }

  function getQuestionGroupUsers()
  {
    $("#question-group-users-dropdown").find("option").remove();
    $.post(webRoot + "get-users-from-question-group",
    {
      "question-group-id" : selected_group_id
    },
    function(data,status){
      if(status == "success")
      {
        if(data.response_code == "0")
        {
            /*
              0 : All ok
              1 : Invalid Access
             -1 : Not Post Data
            */
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
              $("#question-group-users-dropdown").append(out);
            }
            $("#question-group-users-dropdown").selectpicker('refresh');
      }
      else if(data.response_code == "1")
      {
        show_notification("error","You don't have the minimum access level.",5000);
      }
      else if(data.response_code == "2")
      {
        show_notification("error","You didn't send any data.",5000);
      }
      else
      {
        show_notification("error","Unknown error. Contact us for support.",5000);
      }
    }
  });
}

  function getQuestionnaireMembers()
  {
    $("#questionnaire-users-dropdown").find("option").remove();
    $.post(webRoot + "get-users-from-questionnaire",
    {
      "questionnaire-id" : questionnaire_id
    },
    function(data,status){
      if(status == "success")
      {
        /*
          0 all ok
          1 Questionnaire doesnt exist
          2 You dont have access
        */
        if(data.response_code == "0")
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
            $("#questionnaire-users-dropdown").append(out);
          }
            $("#questionnaire-users-dropdown").selectpicker('refresh');
         }
         else if(data.response_code == "1")
         {
           show_notification("error","Questionnaires doesnt exist.",5000);
         }
         else if(data.response_code == "1")
         {
           show_notification("error","You don't have the minimum access level.",5000);
         }
         else
         {
           show_notification("error","Unknown error. Contact us for support..",5000);
         }
       }
    });
  }
