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

        out += "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' style='margin-top:1.5%;border: 2px solid lightblue' id='ritem" + data.questionnaire[i]['id'] + "'>" +
                  "<div class='row'>";

        if(minutes_left > 0)
        {
            /*
              1 hour => 60 minutes
              1 day = 1440 minutes
            */
            var days_left = 0;
            if(minutes_left >= 1440)
            {
              days_left = parseInt(minutes_left / 1440); //days left
              minutes_left -= parseInt(days_left * 1440);
            }
            var hours_left = 0;
            if(minutes_left >= 60)
            {
              hours_left = parseInt(minutes_left / 60); //hours left
              minutes_left -= parseInt(hours_left * 60);
            }
            var display = (days_left > 0 ? days_left + "d " : "") + (hours_left > 0 ? hours_left + "h " : "") + ( minutes_left > 0 ? minutes_left + "m " : "") + "left";

            out += "<div class='visible-xs col-xs-offset-5 col-xs-7'>" +
                "<div style='font-size:15px' class='list-group-item-heading'> <div class='progress-bar progress-bar-striped progress-bar-info active' role='progressbar' style='width:100%'>" + display + "</div></div>" +
              "</div>" +
                "<div class='col-xs-12 col-sm-7 col-md-8'>" +
                    "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + questionnaire_page + "/" + data.questionnaire[i]['id'] + "' style='color:black' target='_blank'>" + data.questionnaire[i]['name'] + "</a></div>" +
                "</div>" +
                "<div class='hidden-xs col-sm-offset-2 col-sm-3 col-md-2'>" +
                    "<div style='font-size:15px' class='list-group-item-heading'><div class='progress-bar progress-bar-striped progress-bar-info active' role='progressbar' style='width:100%'>" + display + "</div></div>" +
                "</div>";
        }
        else if(data.questionnaire[i]['time-left'] == 0)
        {
          out += "    <div class='col-xs-12 col-sm-7 col-md-8'>" +
                    "<div style='font-size:18px' class='list-group-item-heading'><a class='user_name' href='" + questionnaire_page + "/" + data.questionnaire[i]['id'] + "' style='color:black' target='_blank'>" + data.questionnaire[i]['name'] + "</a></div>" +
                "</div>";
        }
        else if(data.questionnaire[i]['time-left'] == -1){
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

        var access = data.questionnaire[i]['time-left'] != 0 ? "disabled" : "";

        out += "</div>" +
              "<div class='row'>" +
                "<div class='col-xs-12'>" +
                    "<div style='font-size:17px' > Answers : 10/50 </div>" +
                "</div>" +
                "<div class='col-xs-12 col-sm-5 col-md-6'>" +
                    "<div style='font-size:17px' > Players: 100 </a></div>" +
                "</div>" +
                  "<div class='col-xs-offset-5 col-xs-7 col-sm-offset-4 col-sm-3 col-md-2'>" +
                    "<button type='button' class='btn btn-success' " + access + " onclick=\"handleQuestionnaireParticipationRequest(" + data.questionnaire[i]['id'] + ",'accept')\"><span class='fa fa-play'> Play</span></button> " +
                  "</div>" +
              "</div>" +
          "</div>";
       }

       $("#my-questionnaires-list").append(out);
    }
  });
}
