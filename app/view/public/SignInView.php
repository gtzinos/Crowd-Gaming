<? if($section == "SIGN_IN") : ?>
	<div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Login Page</h4>
				 </div>
				 <div class="modal-body">
						<form role="form">
								<div class="form-group">
										<label for="email">Email</label>
								 	  <input class="form-control" id="signin-Email" type="email"  placeholder="Email">
								</div>
								<div class="form-group">
									<label for="pwd">Password:</label>
									<input type="password" id="signin-Password" class="form-control" placeholder="Password">
								</div>
								<div class="form-group">
									<div id="signin-spinner"> </div>
									<label id="signin-response" class="responseLabel"></label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" /> Remember Me
									</label>
								</div>
						</form>
				 </div>
				 <div class="modal-footer">
					 <button type="button" class="btn btn-primary btn-md round" onclick="signIn()" >Sign In</button>
					 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
