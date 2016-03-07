<? if($section == "QUESTIONNAIRE_OPTIONS") : ?>

	<div class="modal fade" id="questionnaire-options" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dimdiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Options for this questionnaire </h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form onsubmit="return !$('#option-request-button').prop('disabled')" method="POST" class="form-horizontal">
							<!-- Request type Field -->
							<div class="form-group has-feedback">
									<div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
										<span class="text-center"><i class="material-icons bigicon">mood</i></span>
									</div>
									<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-8 gt-input-group" data-validate="select">

											<option value="" disabled selected>What do you want ? </option>
											<?php
												/*
													Simple player
												*/

												/*
													If he isnt a player
													and he didnt have an active request to be a player
												*/
												if(!get("questionnaire")["active-player-request"] && !get("questionnaire")["player-participation"])
												{
													/*
														He can make a request to be a player
													*/
													echo "<option value='1' >I want to play on this questionnaire</option>";
												}
												/*
													If he have an active player request
												*/
												else if(get("questionnaire")["active-player-request"]) {
													echo "<option value='-1' >Please delete my request to be a player</option>";
												}
												/*
													If he is an accepted player
												*/
												else if(get("questionnaire")["player-participation"]) {
													/*
														He can unjoin from the players list
													*/
													echo "<option value='-1' >I dont want to be a player on this questionnaire</option>";
												}

												/*
													If he is logged in
												*/
												if(isset($_SESSION["USER_LEVEL"])) {
													/*
														If he is an examiner
													*/
													if($_SESSION["USER_LEVEL"] > 2) {
														/*
															If he isnt an examiner and
															he didnt have an active request to be a examiner
														*/
															if(!get("questionnaire")["active-examiner-request"] && !get("questionnaire")["examiner-participation"])
															{
																/*
																	He can send a request to be one
																*/
																echo "<option value='2' >I want to be an examiner on this questionnaire</option>";
															}
															/*
																If he had an active examiner request
															*/
															else if(get("questionnaire")["active-examiner-request"])
															{
																/*
																	He can delete his request
																*/
																echo "<option value='-1' >Please delete my request to be an examiner</option>";
															}
															/*
																If he is one of the examiners
															*/
															else if(get("questionnaire")["examiner-participation"])
															{
																/*
																	He can unjoin from examiner list
																*/
																echo "<option value='-2' >I dont want to be an examiner for this questionnaire</option>";
															}
													}
												}

											?>

										</select>
										<span></span>
									</div>
							</div>
							<!-- Message Text Field -->
              <div class="form-group has-feedback">
                  <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                      <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                  </div>
                  <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-8 gt-input-group" data-validate="length" data-length="1">
                      <textarea class="form-control" maxlength="250" id="request-join-message" name="message" placeholder="Send us something (Optional)" ></textarea>
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
								 <button id="join-questionnaire-button" onclick="$(document).find('form').submit()" class="btn btn-primary btn-md round submit" disabled>Send request</button>
							 </div>
							 <div class="col-xs-offset-2 col-xs-3 col-sm-offset-0 col-sm-2">
								 <button id="option-request-button" type="button" class="btn btn-primary btn-md round" data-dismiss="modal" >
									 Cancel
								 </button>
							 </div>
						</div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
