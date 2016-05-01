$(document).ready(function() {
  get_questionnaire_i_manage();
});

function get_questionnaire_i_manage()
{
  $.post(webRoot + "get-my-questionnaires",
  {

  },
  function(data,status)
  {
    if(status == "success")
    {
      var i = 0,
          out = "",
          questionnaires = data.questionnaires;
      if(data.questionnaires.length > 0)
      {
          for(i; i < questionnaires.length; i++)
          {
            var questionnaire_name_to_delete = questionnaires[i].name.replace("&#039;","\\'");
            questionnaire_name_to_delete = questionnaire_name_to_delete.replace("&#34;","\\'");

            out += "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='qitem" + questionnaires[i].id + "'>" +
                        "<div class='col-xs-12'>" +
                            "<h4 class='list-group-item-heading'>" + questionnaires[i].name + "</h4>" +
                        "</div>" +
                        "<div class='col-xs-12' style='margin-top:3%;padding:0px'>" +
                            "<div class='col-xs-12 col-sm-4 col-md-3' style='padding:0px'>" +
                                "<button class='btn btn-info' type='button'>New Question</button>" +
                            "</div>" +
                            "<div class='col-xs-12 col-sm-2 col-md-1' style='padding:0px'>" +
                                "<a class='btn btn-default' href=''>Edit</a>" +
                            "</div>" +
                            "<div class='col-xs-12 col-sm-2 col-md-2' style='padding:0px'>" +
                                "<button class='btn btn-danger' type='button' onclick=\"show_confirm_modal('" + questionnaires[i].id + "','" + questionnaire_name_to_delete + "')\">Delete</button>" +
                            "</div>" +
                            "<div class='col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3'>" +
                                "<button class='btn btn-link' type='button'>Questions</button>" +
                            "</div>" +
                        "</div>" +
                    "</div>";
          }
      }
      else {
        out += "<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                    "<div class='col-xs-12'>" +
                        "<div class='alert alert-danger'>We don't have any available questionnaire in our database. </div>" +
                    "</div>" +
                "</a>";
      }
      $("#questionnaire-list").html(out);
    }
  });
}

function show_confirm_modal(questionnaire_to_delete,questionnaire_name_to_delete)
{
  showModal('confirm-questionnaire-deletion');
  $('#qtitle-confirm-deletion-modal').html("<span class='glyphicon glyphicon-lock'></span> Delete questionnaire " + questionnaire_name_to_delete);
  $("#confirm-questionnaire-deletion-button").bind("click",function() {
    delete_questionnaire(questionnaire_to_delete);
  });
}

function delete_questionnaire(questionnaire_to_delete)
{
  var password = $("#confirm-password-text").val();
  $.post(webRoot + "delete-questionnaire",
  {
    'questionnaire-id' : questionnaire_to_delete,
    'password' : password
  },
  function(data,status)
  {
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","Questionnaire deleted successfully.",3000);
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
}
