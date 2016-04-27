$(document).ready(function(e) {
  $('#question-group-users').on('shown.bs.modal', function() {
    get_question_groups();
  });

  $('#single-group-dropdown').on('changed.bs.select', function (e) {
      getQuestionnaireMembers();
  });
});

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
        show_notification("error","Unknown error. Please contact with us!",5000);
      }
    }
  });
  }

  function getQuestionGroupUsers(group_id)
  {
    $("#questionnaire-users-dropdown").find("option").remove();
    $.post(webRoot + "get-users-from-question-group",
    {
      "question-group-id" : group_id
    },
    function(data,status){
      if(status == "success")
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
          $("#questionnaire-users-dropdown").append(out);
        }
          $("#questionnaire-users-dropdown").selectpicker('refresh');
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
    });
  }
