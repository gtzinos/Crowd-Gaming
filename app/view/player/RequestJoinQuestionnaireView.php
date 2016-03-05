<? if($section == "REQUEST_JOIN_QUESTIONNAIRE") : ?>

	<div class="modal fade" id="joinQuestionnaire" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dimdiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Request to join our questionnaire </h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form onsubmit="return false" class="form-horizontal">
              <!-- Message Text Field -->
              <div class="form-group has-feedback">
                  <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                      <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                  </div>
                  <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="1">
                      <textarea class="form-control" maxlength="250" id="request-join-message" name="message" placeholder="Send us something (Optional)" ></textarea>
                      <span></span>
                  </div>
              </div>
							<!-- Request type Field -->
							<div class="form-group has-feedback">
									<div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
										<span class="text-center"><i class="material-icons bigicon">mood</i></span>
									</div>
									<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="select">
										<select class="form-control" id="request-join-type" required>
											<option value="" disabled selected>What you need ? </option>
											<option value="1" >I want to play</option>
											<?php
												/*
													TODO : We need array of request types
												*/
											?>
										</select>
										<span></span>
									</div>
							</div>
							<!-- Spinner and Response Label Field -->
							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-7 col-sm-offset-3 col-sm-7">
									<label id="join-questionnaire-response" class="responseLabel"></label>
								</div>
							</div>
						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Confirm Password / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-0 col-xs-5 col-sm-offset-3 col-sm-4">
								 <!-- A Script will add on click method -->
								 <button id="join-questionnaire-button" type="button" class="btn btn-primary btn-md round submit" disabled>Send request</button>
							 </div>
							 <div class="col-xs-offset-2 col-xs-3 col-sm-offset-0 col-sm-2">
								 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal" >
									 Cancel
								 </button>
							 </div>
						</div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
