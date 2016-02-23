<? if($section == "SIGN_IN") : ?>
	<div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Login Page</h4>
				 </div>
				 <div class="modal-body">
						<form role="form" class="form-horizontal">
							<!-- Email Field -->
							<div class="form-group has-feedback">
								<div class="col-xs-2">
									 <!--   <label class="control-label" for="email">Email</label> -->
											 <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
								</div>
								<div class="input-group col-xs-7" data-validate="email">
								 	  <input class="form-control" id="signin-email" name="email" type="email" maxlength="40" placeholder="Email (Required)" required >
										<span></span>
								</div>
							</div>
							<!-- Password Field -->
							<div class="form-group has-feedback">
								<div class="col-xs-2">
											 <!--  <label class="control-label" for="pwd">Password:</label> -->
											 <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
								</div>
								<div class="input-group col-xs-7" data-validate="length" data-length="8" >
											 <input type="password" id="signin-password" name="password" class="form-control" maxlength="20" placeholder="Password (Required) *Length >= 8" required />
											 <span></span>
								</div>
							</div>
							<!-- Spinner and Response Label Field -->
							<div class="form-group">
								<div class="col-xs-3"></div>
								<div class="col-xs-7">
									<div id="signin-spinner">

									</div>
									<label id="signin-response" class="responseLabel"></label>
								</div>
							</div>
								<!-- Check box Field -->
							<div class="form-group">
								<div class="col-xs-2"></div>
								<div class="col-xs-7">
									<label  class="control-label">
										<input type="checkbox" /> Remember Me
									</label>
								</div>
							</div>
						</form>
				 </div>
				 <div class="modal-footer">
					 <button type="button" id="submit" class="btn btn-primary btn-md round" onclick="signIn()" disabled>Sign In</button>
					 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
