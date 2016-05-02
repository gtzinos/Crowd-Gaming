<? if($section == "CONFIRM_QUESTIONNAIRE_DELETION") : ?>
	<div class="modal fade" id="confirm-questionnaire-deletion" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header" id='qtitle-confirm-deletion-modal'></h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form id="confirm-modal-form" onsubmit="return false" class="form-horizontal">
							<!-- Password Field -->
							<div class="form-group has-feedback">
									<div class="col-xs-offset-1 col-xs-2 col-sm-offset-1 col-sm-2">
										<span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
									</div>
									<div class="col-xs-offset-0 col-xs-7 gt-input-group" data-validate="length" data-length="8">
											<input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" id="confirm-password-text" type="password" placeholder="Password (Required) *Length >= 8" required >
											<span class="gt-icon"></span>
									</div>
							</div>
						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Confirm Password / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-0 col-xs-6 col-sm-offset-1 col-sm-5">
								 <!-- A Script will add on click method -->
								 <button form="confirm-modal-form" id="confirm-questionnaire-deletion-button" type="button" class="btn btn-primary btn-md round gt-submit" disabled>Confirm &#38; Delete</button>
							 </div>
							 <div class="col-xs-3 col-sm-2">
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
