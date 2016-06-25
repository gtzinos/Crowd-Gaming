<? if($section == "QUESTIONNAIRE_SCORES") : ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/jsPDF/dist/jspdf.min.js"); ?>"></script>
  <script src="<?php print LinkUtils::generatePublicLink("js/player/QuestionnaireResults.js"); ?>"></script>
	<div class="modal fade" id="questionnaire-results" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><i class='glyphicon glyphicon-stats'></i> Questionnaire results </h4>
				 </div>
				 <div class="modal-body container-fluid">
           <div id="results-place"></div>
           <br><br>
           <div id="charts-place"></div>
           <div id="hidden-chart-image" style="display:none"></div>
           <div id="scores-spinner"></div>
           <br>
           <div id="buttons-place">
              <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                <button id="download-submit" class="form-control" onclick="downloadAsPdf()">Download PDF</button>
              </div>
              <div class="visible-xs"><br><br></div>
              <div class="col-xs-12 col-sm-4">
                <button id="get-charts-submit" class="form-control" onclick="drawChart()">Get charts</button>
              </div>
              <div class="visible-xs"><br><br></div>
              <div class="col-xs-12 col-sm-2">
                <button id="refresh-results-submit" class="form-control" onclick="getAllScores()">Refresh</button>
              </div>
           </div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
