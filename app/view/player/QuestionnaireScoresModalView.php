<? if($section == "QUESTIONNAIRE_SCORES") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/jsPDF/dist/jspdf.min.js"); ?>"></script>
  <script src="<?php print LinkUtils::generatePublicLink("js/player/QuestionnaireResults.js"); ?>"></script>
	<div class="modal fade" id="questionnaire-results" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><i class='glyphicon glyphicon-stats'></i> Questionnaire results </h4>
				 </div>
				 <div id="results-place" class="modal-body container-fluid">

				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Send Email / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-2 col-xs-5 col-sm-offset-2 col-sm-4">
								 <!-- A Script will add on click method -->
								 <button id="contact-coordinator" form="contact-form" type="button" class="btn btn-primary btn-md gt-submit" onclick="$('#contact-form').submit()" disabled>Options</button>
							 </div>
							 <div class="col-xs-3 col-sm-2">
								 <button type="button" class="btn btn-primary btn-md" data-dismiss="modal" >
									 Cancel
								 </button>
							 </div>
						</div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
