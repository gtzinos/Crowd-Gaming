<? if($section == "PLAY_GAME") : ?>
	<div class="modal fade" id="play-questionnaire" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span>Anwer questions</h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form id="play-questionnaire-form" onsubmit="return false" method="POST" class="form-horizontal">

						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<div class="form-group">
							 <div class="col-xs-4 col-sm-offset-2 col-sm-3">
								 <button type="button" class="btn btn-primary btn-md" onclick="sendPublicRequest">Confirm</button>
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
