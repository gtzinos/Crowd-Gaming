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
				$( "#confirm-button" ).unbind( "click" );
				$( "#confirm-button" ).bind( "click", function() {
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
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Confirm your current password </h4>
				 </div>
				 <div class="modal-body">
						<form role="form" method="POST" action="#" class="form-horizontal">
							<!-- Password Field -->
							<div class="form-group has-feedback">
								<div class="col-xs-2">
											 <!--  <label class="confirm-label" for="pwd">Password:</label> -->
											 <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
								</div>
								<div class="input-group col-xs-7" data-validate="length" data-length="8" >
											 <input type="password" id="confirm-password" name="password" class="form-control" placeholder="Password (Required) *Length >= 8" required />
											 <span></span>
								</div>
							</div>
							<!-- Spinner and Response Label Field -->
							<div class="form-group">
								<div class="col-xs-3"></div>
								<div class="col-xs-7">
									<div id="confirm-spinner">

									</div>
									<label id="confirm-response" class="responseLabel"></label>
								</div>
							</div>

						</form>
				 </div>
				 <div class="modal-footer">
					 <button id="confirm-button" type="button" class="btn btn-primary btn-md round submit" disabled>Confirm Password</button>
					 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal" >Cancel</button>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
