<? if($section == "CONFIRM_PASSWORD") : ?>
	<script>
		/*
			Confirm Password method
			(Called before modal shown event)
		*/
		function confirmPassword(method)
		{
			/*
				Clear response label
			*/
			$("#confirm-response").html('');
			/*
				Show modal box
			*/
			$("#confirmPassword").modal('show');
				/*
					Set on click listener
					on #confirm-button
				*/
				$("#confirm-button").unbind( "click" );
				$("#confirm-button").bind( "click", function() {
					/*
						parameter name method + ()
						call e.g updateProfile()
					*/
					eval(method + '()');
				} );

		}
	</script>
	<div class="modal fade" id="confirmPassword" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dimdiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Confirm your current password </h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form onsubmit="return false" class="form-horizontal">
							<!-- Password Field -->
							<div class="form-group has-feedback">
									<div class="col-xs-offset-1 col-xs-2 col-sm-offset-1 col-sm-2">
										<span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
									</div>
									<div class="col-xs-offset-0 col-xs-7 gt-input-group" data-validate="length" data-length="8">
											<input class="form-control" id="confirm-password" type="password" placeholder="Password (Required) *Length >= 8" required >
											<span></span>
									</div>
							</div>
							<!-- Spinner and Response Label Field -->
							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-7 col-sm-offset-3 col-sm-7">
									<div id="confirm-spinner">

									</div>
									<label id="confirm-response" class="responseLabel"></label>
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
								 <button id="confirm-button" type="button" class="btn btn-primary btn-md round submit" disabled>Confirm Password</button>
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
