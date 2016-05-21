$(window).on('load',function() {
  getMyQuestionnaires();
});

function getMyQuestionnaires()
{
  $.post(webRoot + "rest_api/questionnaire",
  {

  },
  function(data,status)
  {
    if(status == "success")
    {
      var i = 0,
          out = "";
      for(i=0;i<data.questionnaire.length;i++)
      {

        var minutes_left = data.questionnaire[i]['time-left'];

        out = "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' style='margin-top:1.5%;border: 2px solid lightblue' id='ritem" + data.questionnaire[i]['id'] + "'>" +
                  "<div class='row'>";

        if(minutes_left > 0)
        {
            out += "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                "<div style='font-size:15px' class='list-group-item-heading'> <div id='mobile-count-down" + data.questionnaire[i].id + "' class='count-down progress-bar progress-bar-striped progress-bar-info active' role='progressbar' style='width:100%'></div></div>" +
              "</div>" +
                "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                    "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + questionnaire_page + "/" + data.questionnaire[i]['id'] + "' style='color:black' target='_blank'>" + data.questionnaire[i]['name'] + "</a></div>" +
                "</div>" +
                "<div class='hidden-xs col-sm-offset-2 col-sm-3 col-md-2'>" +
                    "<div style='font-size:15px' class='list-group-item-heading'>" +
                        "<div id='medium-count-down" + data.questionnaire[i].id + "' class='count-down progress-bar progress-bar-striped progress-bar-info active' role='progressbar' style='width:100%'>" +
                        "</div>" +
                    "</div>" +
                "</div>";
        }
        else if(minutes_left == 0)
        {
          out += "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                    "<div style='font-size:15px' class='list-group-item-heading'> <div class='progress-bar progress-bar-striped progress-bar-success active' role='progressbar' style='width:100%'>Running</div></div>" +
                  "</div>" +
                  "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                      "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + questionnaire_page + "/" + data.questionnaire[i]['id'] + "' style='color:black' target='_blank'>" + data.questionnaire[i]['name'] + "</a></div>" +
                  "</div>" +
                  "<div class='hidden-xs col-sm-offset-2 col-sm-3 col-md-2'>" +
                      "<div style='font-size:15px' class='list-group-item-heading'><div class='progress-bar progress-bar-striped progress-bar-success active' role='progressbar' style='width:100%'>Running</div></div>" +
                  "</div>";
        }
        else if(minutes_left == -1){
          out += "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
              "<div style='font-size:15px' class='list-group-item-heading'> <div class='progress-bar progress-bar-striped progress-bar-warning active' role='progressbar' style='width:100%'>No schedule yet</div></div>" +
            "</div>" +
              "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                  "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + questionnaire_page + "/" + data.questionnaire[i]['id'] + "' style='color:black' target='_blank'>" + data.questionnaire[i]['name'] + "</a></div>" +
              "</div>" +
              "<div class='hidden-xs col-sm-offset-2 col-sm-3 col-md-2'>" +
                  "<div style='font-size:15px' class='list-group-item-heading'><div class='progress-bar progress-bar-striped progress-bar-warning active' role='progressbar' style='width:100%'>No schedule yet</div></div>" +
              "</div>";
        }

        out += "</div>" +
              "<div class='row'>" +
                "<div class='col-xs-12'>" +
                    "<div style='font-size:17px' >" +
                      " Answers : " + data.questionnaire[i]['answered-questions'] + "/" + data.questionnaire[i]['total-questions'] + " </div>" +
                "</div>" +
                "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                    "<div style='font-size:17px' > Players: 100 </a></div>" +
                "</div>" +
                  "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-4 col-sm-3 col-md-2'>";

         if(data.questionnaire[i]['time-left-to-end'] == 0)
         {
            out += "<button type='button' class='btn btn-success' onclick=\"viewQuestionnaireResults(" + data.questionnaire[i]['id'] + ")\"><span class='glyphicon glyphicon-stats'> Results</span></button> ";
         }
         else if(data.questionnaire[i]['time-left'] == 0)
         {
           if(data.questionnaire[i]['answered-questions'] == data.questionnaire[i]['total-questions'])
           {
             out += "<button type='button' class='btn btn-success' disabled><span class='fa fa-play'> Completed</span></button> ";
           }
           else
           {
             out += "<button type='button' class='btn btn-success' onclick=\"playQuestionnaire(" + data.questionnaire[i]['id'] + ")\"><span class='fa fa-play'> Play</span></button> ";
           }
           }
         else {
           out += "<button type='button' class='btn btn-success' disabled><span class='fa fa-play'> Play</span></button> ";
         }
          out += "</div>" +
              "</div>" +
          "</div>";
          $("#my-questionnaires-list").append(out);
          show_clock("#mobile-count-down" + data.questionnaire[i].id,moment().add(minutes_left,'seconds').format("YYYY/MM/DD hh:mm:ss"),"%m months %-d days %-H h %M min %S sec","");
          show_clock("#medium-count-down" + data.questionnaire[i].id,moment().add(minutes_left,'seconds').format("YYYY/MM/DD hh:mm:ss"),"%m months %-d days %-H h %M min %S sec",data.questionnaire[i].name + " started. Page will reload.");

       }
       if(data.questionnaire.length == 0)
       {
         $("#my-questionnaires-list").html("<div class='alert alert-danger text-center'>You don't participate to any questionnaire.</div>");
       }
     }
  });
}

function playQuestionnaire(questionnaire_id)
{
  window.location.replace(play_questionnaire_page + "/" + questionnaire_id);
}
