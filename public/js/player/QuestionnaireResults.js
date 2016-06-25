var scores_array = [],
    customize_array = [];
google.charts.load("current", {packages:["corechart"]});

$(window).on("load",function() {
  $('#questionnaire-results').on('shown.bs.modal', function (e) {
    if(time_left == 0)
    {
      show_notification("warning","These aren't the final results. Questionnaire is online.",6000);
    }
    getAllScores();
  })
});

function refresh()
{
  $("#results-place,#full-results-place,#charts-place,#hidden-chart-image").html("");
  getAllScores();
}

function getAllScores()
{
  if(notCompletedRequest == true)
  {
    return;
  }
  notCompletedRequest = true;
  show_spinner("scores-spinner");
  $("#charts-place").html();

  $.ajax(
  {
    method: "POST",
    url: webRoot + "/rest_api/questionnaire/" + questionnaire_id + "/score",
    data: {}
  })
  .done(function(data)
  {
    if(data.code == "200")
    {
      $("#results-place").html("");
      var out = "<div class='table-responsive'>" +
                    "<table class='table'>" +
                      "<thead>" +
                        "<tr>" +
                          "<th>First Name</th>" +
                          "<th>Surname</th>" +
                          "<th>Degree (%)</th>" +
                        "</tr>" +
                      "</thead>" +
                      "<tbody>";

      if(data["group-scores"] != null)
      {
        scores_array = data;
        $.each(data["group-scores"], function(i,group) {
            $.each(group, function(j, userstats) {
              if(scores_array[userstats["user-name"] + " " + userstats["user-surname"]] != undefined)
              {
                scores_array[userstats["user-name"] + " " + userstats["user-surname"]] = scores_array[userstats["user-name"] + " " + userstats["user-surname"]]["userstats"].score + userstats.score;
              }
              else {
                scores_array[userstats["user-name"] + " " + userstats["user-surname"]] = { userstats };
              }
            });
        });
        //sortJsonByKey(scores_array,"user-surname");
        $.each(data["total-score"],function(){
          out += "<tr>" +
                    "<td>" + this["name"] + "</td>" +
                    "<td>" + this["surname"] + "</td>" +
                    "<td>" + (this["score"]).toFixed(2) + "</td>" +
                 "</tr>";
        });
      }
      out += "</tbody>" +
            "</table>" +
        "</div>";
      $("#results-place").html(out);
    }
  })
  .fail(function(xhr,error){
    var response = JSON.parse(xhr.responseText);
    switch(response.code)
    {
      case "403":
      case "604":
        show_notification("error",response.message,4000);
        break;
      default:
        displayServerResponseError(xhr,error);
        break;
    }
  })
  .always(function() {
    remove_spinner("scores-spinner");
    notCompletedRequest = false;
  })
}

//Sort json by key
function sortJsonByKey(array, key) {
   return array.sort(function(a, b) {
       var x = a["userstats"][key];
       var y = b["userstats"][key];
       return ((x < y) ? -1 : ((x > y) ? 1 : 0));
   });
}

  function drawChart()
  {
    if(notCompletedRequest == true)
    {
      return;
    }
    notCompletedRequest = true;
    $("#charts-place").html("");
    $("#hidden-chart-image").html("");
    show_spinner("scores-spinner");

    var pieChartData = [];
    var oneToFive = 0,
        fiveToSix = 0,
        SixToEight = 0,
        EightToNine = 0,
        NineToTen = 0;
    $.each(scores_array["total-score"],function() {
      var degree = this["score"];
      if(degree >= 0 && degree < 50) { oneToFive++; }
      else if(degree >= 50 && degree < 60) { fiveToSix++; }
      else if(degree >= 60 && degree < 80) { SixToEight++; }
      else if(degree >= 80 && degree <= 100) { NineToTen++; }
    })
      var data = google.visualization.arrayToDataTable([
        ['Degree', 'Number of players'],
        ['0 - 50', oneToFive],
        ['50 - 60', fiveToSix],
        ['60 - 80', SixToEight],
        ['80 - 90', EightToNine],
        ['90 - 100', NineToTen]
      ]);

      var options = {
        title: 'Questionnaire results',
        pieHole: 0.4,
      };

      var chart_div = document.getElementById('charts-place');
      var chart = new google.visualization.PieChart(chart_div);

      chart.draw(data, options);

      $("#hidden-chart-image").append('<img src="' + chart.getImageURI() + '">');
      remove_spinner("scores-spinner");
      notCompletedRequest = false;
  }

   function downloadAsPdf() {
       var pdf = new jsPDF('p', 'pt', 'a4');
       // source can be HTML-formatted string, or a reference
       // to an actual DOM element from which the text will be scraped.
       source = $('#results-place').html() + "<br><br>" + $('#hidden-chart-image').html() + "<br><br>" + $('#charts-place').html();

       // we support special element handlers. Register them with jQuery-style
       // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
       // There is no support for any other type of selectors
       // (class, of compound) at this time.
       specialElementHandlers = {
           // element with id of "bypass" - jQuery style selector
           '#bypassme': function (element, renderer) {
               // true = "handled elsewhere, bypass text extraction"
               return true
           }
       };
       margins = {
           top: 80,
           bottom: 60,
           left: 40,
           width: 522
       };
       // all coords and widths are in jsPDF instance's declared units
       // 'inches' in this case
       pdf.fromHTML(
       source, // HTML string or DOM elem ref.
       margins.left, // x coord
       margins.top, { // y coord
           'width': margins.width, // max width of content on PDF
           'elementHandlers': specialElementHandlers
       },

       function (dispose) {
           // dispose: object with X, Y of the last line add to the PDF
           //          this allow the insertion of new lines after html
           pdf.save(questionnaire_name + '.pdf');
       }, margins);
   }
