<? if($section == "QUESTIONNAIRE_OPTIONS") : ?>

	<div class="modal fade" id="questionnaire-options" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="fa fa-lock"></span> Join on this questionnaire </h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form onsubmit="return !$('#option-request-button').prop('disabled')" method="POST" class="form-horizontal">

							<!-- Password Text Field -->
              <div class="form-group has-feedback row">
                  <div class="col-xs-offset-0 col-xs-1 col-md-offset-1 col-md-1">
                      <span class="text-center mediumicon"><i class="fa fa-key"></i></span>
                  </div>
                  <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-8 gt-input-group" data-validate="length" data-length="1">
                      <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 characters" maxlength="250" name="message" placeholder="Password (*Required)" required>
                      <span class="gt-icon"></span>
                  </div>
              </div>
							<!--Confirm send request / Button Field -->
							<div class="form-group row">
								 <div class="col-xs-offset-2 col-xs-4  col-sm-3">
									 <!-- A Script will add on click method -->
									 <button id="send-request-button" type="submit" class="btn btn-primary btn-md gt-submit" disabled>Send request</button>
								 </div>
								 <div class="col-xs-3 col-sm-3">
									 <button type="button" class="btn btn-primary btn-md" data-dismiss="modal" >
										 Cancel
									 </button>
								 </div>
							</div>
						</form>
				 </div>

			 </div>
		 </div>
	 </div>

<? endif; ?>
