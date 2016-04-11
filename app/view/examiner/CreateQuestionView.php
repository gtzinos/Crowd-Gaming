<? if($section == "CONFIRM_PASSWORD") : ?>
	<div class="modal fade" id="createQuestion" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span>Create Question</h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form id="create-question-form" onsubmit="return false" class="form-horizontal">
							<!-- Password Field -->
							<div class="form-group has-feedback">
									<div class="col-xs-offset-1 col-xs-2 col-sm-offset-1 col-sm-2">
										<span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
									</div>
									<div class="col-xs-offset-0 col-xs-7 gt-input-group" data-validate="length" data-length="8">
											<input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" id="confirm-password" type="password" placeholder="Password (Required) *Length >= 8" required >
											<span class="gt-icon"></span>
									</div>
							</div>
						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Create Question button / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-0 col-xs-5 col-sm-offset-3 col-sm-4">
								 <!-- A Script will add on click method -->
								 <button form="create-question-form" type="button" class="btn btn-primary btn-md round gt-submit" disabled>Create</button>
							 </div>
							 <div class="col-xs-offset-2 col-xs-3 col-sm-offset-0 col-sm-2">
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
