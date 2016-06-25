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
            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="pill" href="#simple-scores-tab">Simple results</a></li>
              <li><a data-toggle="pill" href="#full-scores-tab">Full results</a></li>
            </ul>
            <!-- Simple results tab -->
            <div class="tab-content">
              <div id="simple-scores-tab" class="tab-pane fade in active">
                <br>
                <div id="results-place"></div>
                <br><br>
                <div id="charts-place"></div>
                <div id="hidden-chart-image" style="display:none"></div>
                <div id="scores-spinner"></div>
                <br>
                <div id="buttons-place">
                   <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                     <button id="download-submit" class="form-control" onclick="downloadSimpleResults()">Download PDF</button>
                   </div>
                   <div class="visible-xs"><br><br></div>
                   <div class="col-xs-12 col-sm-4">
                     <button id="get-charts-submit" class="form-control" onclick="drawChart()">Get charts</button>
                   </div>
                   <div class="visible-xs"><br><br></div>
                   <div class="col-xs-12 col-sm-2">
                     <button id="refresh-results-submit" class="form-control" onclick="refreshSimpleResults()">Refresh</button>
                   </div>
                </div>
              </div>
              <!-- Full scores tab -->
              <div id="full-scores-tab" class="tab-pane fade">
                <br><br>
                <form role="form" class="form-horizontal" onsubmit="return false">
                  <div class="form-group">
                    <div class="col-xs-offset-1 col-xs-7 col-sm-5">
                      <select id="full-scores-users-dropdown" class="selectpicker form-control" data-live-search="true" title="Select some users" multiple data-actions-box="true" data-selected-text-format="count > 2">
                      </select>
                    </div>
                    <div class="col-xs-3 col-sm-4">
                      <div class="dropdown">
                         <button class="form-control btn btn-primary" onclick="getFullScoreResults()">Get Scores</button>
                      </div>
                    </div>
                  </div>
                </form>
                <br><br>
                <div id="full-results-place"></div>
                <br><br>
                <div id="full-button-place">
                   <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                     <button id="full-download-submit" class="form-control" onclick="downloadFullResults()">Download PDF</button>
                   </div>
                   <div class="visible-xs"><br><br></div>
                   <div class="col-xs-12 col-sm-2">
                     <button id="full-refresh-results-submit" class="form-control" onclick="refreshFullResults()">Refresh</button>
                   </div>
                </div>
              </div>
            </div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
