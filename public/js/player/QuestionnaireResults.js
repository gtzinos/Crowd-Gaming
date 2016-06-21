var scores_array = [];
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

$(window).on("load",function() {
  $('#questionnaire-results').on('shown.bs.modal', function (e) {
    getAllScores();
  })
});

function getAllScores()
{
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
                          "<th>Full Name</th>" +
                          "<th>Email</th>" +
                          "<th>Degree</th>" +
                        "</tr>" +
                      "</thead>" +
                      "<tbody>";
      data = {
            "code":"200",
            "message":"ok",
            "score":{
                    "Question Group 4":[
                          {
                           "user-name":"Stavros",
                           "user-surname":"Skourtis",
                           "score":100}
                         ,{
                           "user-name":"123",
                           "user-surname":"123",
                           "score":40
                          }
                     ],
                    "Group Name":[
                          {
                          "user-name":"Stavros",
                          "user-surname":"Skourtis",
                          "score":100
                          }
                     ]
                 }
        }
      if(data.scores != null && data.scores.length > 0)
      {
        $.each(data.scores, function(i,group) {
            $.each(group, function(j, userstats) {
              if(scores_array[userstats.email] != undefined)
              {
                scores_array[userstats.email] = scores_array[userstats.email].score + userstats.score;
              }
              else {
                scores_array[userstats.email] = { userstats };
              }
            });
        });

        $.each(scores_array, function(i, user) {
          out += "<tr>" +
                      "<td>" + user["user-surname"] + " " + user["user-email"] + "</td>" +
                      "<td>" + user["user-email"] + "</td>" +
                      "<td>" + user["score"] + "</td>" +
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
      case "604":
        show_notification("error",response.message,4000);
        break;
      default:
        displayServerResponseError(xhr,error);
        break;
    }
  });
}

  function drawChart()
  {
    var pieChartData = [];
    var oneToFive = 0,
        fiveToSix = 0,
        SixToEight = 0,
        EightToNine = 0,
        NineToTen = 0;
    $.each(scores_array,function(i,user){
      if(user.score >= 0 && user.score < 50) { oneToFive++; }
      else if(user.score >= 50 && user.score < 60) { fiveToSix++; }
      else if(user.score >= 60 && user.score < 80) { SixToEight++; }
      else if(user.score >= 80 && user.score <= 100) { NineToTen++; }
    });
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

      var chart = new google.visualization.PieChart(document.getElementById('charts-place'));
      chart.draw(data, options);
  }

   function demoFromHTML() {
       var pdf = new jsPDF('p', 'pt', 'letter');
       // source can be HTML-formatted string, or a reference
       // to an actual DOM element from which the text will be scraped.
       source = $('#content').html();

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
           pdf.save('Test.pdf');
       }, margins);
   }
