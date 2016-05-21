<!-- Include javascript files for modals -->
<script src="<?php print LinkUtils::generatePublicLink("js/resetPassword.js"); ?>"> </script>

<?php if($section == "PASSWORD_RECOVERY") : ?>
<div class="modal fade" id="PasswordRecoveryModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h4 class="gt-modal-header"><span class="fa fa-lock"></span> Forgot Passowrd </h4>
			 </div>
			 <div class="modal-body container-fluid">

					<form onsubmit="return false" id="password-recovery-form" class="form-horizontal" method="POST" >
						<!-- Email Field -->
						<div class="form-group has-feedback">
								<div class="col-xs-offset-1 col-xs-2 col-sm-offset-1 col-sm-2">
											 <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
								</div>
								<div class="col-xs-offset-0 col-xs-7 gt-input-group" data-validate="email">
										<input class="form-control" data-toggle="tooltip" gt-error-message="Not a valid email address" id="recovery-email" name="email" type="email" maxlength="40" placeholder="Email (Required)" required >
										<span class="gt-icon"></span>
								</div>
						</div>
						<!--Response Label Field -->
						<div class="form-group">
							<div class="col-xs-offset-3 col-xs-7 col-sm-offset-3 col-sm-7">
								<label id="recovery-response" class="responseLabel"></label>
							</div>
						</div>
					</form>
				</div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Reset password Confirm / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-1 col-xs-4 col-sm-offset-2 col-sm-4">
								 <button id="confirm-button" type="button" form="password-recovery-form" class="btn btn-primary btn-md round gt-submit" onclick="resetPassword()" disabled>Reset Password</button>
							 </div>
							 <div class="col-xs-offset-2 col-xs-2 col-sm-offset-0 col-sm-2">
								 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal" >Cancel</button>
							 </div>
						</div>
				 </div>
			</div>
		</div>
	</div>
<?php endif; ?>
