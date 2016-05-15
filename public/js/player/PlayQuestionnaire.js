$(window).on("load",function()
 {
   show_clock("#count-down");
   getQuestionGroups();
 });

function getQuestionGroups()
{
  $.post(webRoot + "/rest_api/questionnaire/" + questionnaire_id + "/groups",
  {

  },
  function(data,status)
  {
    if(status == "success")
    {
      $groups = data["question-group"];

      var i = 0,
          out = "";

      out = "";
      for(i=0; i<$groups.length; i++)
      {
        out += "<div class='panel panel-info'>" +
			      			"<div class='panel-heading text-center'>" +
			        			"<p class='panel-title'>" +
											"<a data-toggle='collapse' data-parent='#accordion' href='#collapse" + $groups[i].id + "'>" +
                        $groups[i].name +
											"</a>" +
										"</p>" +
									"</div>" +
                  "<div id='collapse" + $groups[i].id + "' class='panel-collapse collapse'>" +
										"<div class='panel-body'>" +
											"<div class='questionnaire-time' style='margin-left:98%;'>" +
												"<span class='gt-icon'> <i class='glyphicon glyphicon-unchecked'></i> </span>" +
											"</div>" +
											"<div class='questionnaire-description col-xs-12'>" +
                      "</div>" +
                      "<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>" +
												"<button class='btn btn-primary round' target='_blank' type='button' disabled>Play now</button>"+
											"</div>" +
										"</div>" +
								  "</div>" +
								"</div>";
      }
      $("#accordion").html(out);
    }
  });
}
