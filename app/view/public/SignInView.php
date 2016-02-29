<? if($section == "SIGN_IN") : ?>
	<div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4><span class="glyphicon glyphicon-lock"></span> Login Page</h4>
				 </div>
				 <div class="modal-body">
						<form>
								<!-- Email Field -->
								<div class="col-xs-12 form-group has-feedback">
									<div class="col-xs-3">
										 <!--   <label class="control-label" for="email">Email</label> -->
												 <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
									</div>
									<div class="input-group col-xs-7" data-validate="email">
									 	  <input class="form-control" id="signin-email" name="email" type="email" maxlength="40" placeholder="Email (Required)" required >
											<span></span>
									</div>
									<div class="col-xs-2"> </div>
								</div>
								<!-- Password Field -->
								<div class="col-xs-12 form-group has-feedback">
									<div class="col-xs-3">
												 <!--  <label class="control-label" for="pwd">Password:</label> -->
												 <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
									</div>
									<div class="input-group col-xs-7" data-validate="length" data-length="8" >
												 <input type="password" id="signin-password" name="password" class="form-control" placeholder="Password (Required) *Length >= 8" required />
												 <span></span>
									</div>
									<div class="col-xs-2"> </div>
								</div>
								<!-- Check box Field -->
							<div class="col-xs-12 form-group row">
								<div class="col-xs-2">
								</div>
								<div class="col-xs-7">
										<label>
											<input id="signin-remember" type="checkbox" />
										  Remember Me
										</label>
								</div>
								<div class="col-xs-6">
										<label>
											<a href="#">Forgot Password?</a>
										</label>
								</div>
							</div>
							<!-- Spinner and Response Label Field -->
							<div class="col-xs-12 form-group row">
								<div class="col-xs-3"></div>
								<div class="col-xs-7">
									<div id="signin-spinner">

									</div>
									<label id="signin-response" class="responseLabel"></label>
								</div>
								<div class="col-xs-2"> </div>
							</div>
							<!-- Login Button Field -->
							<div class="col-xs-12 form-group row">
								<div class="col-xs-2"> </div>
								 <div class="col-xs-7">
			 						 <button type="button" class="btn btn-primary btn-md btn-block round submit" onclick="signIn()" disabled>Sign In</button>
			 						</div>
							</div>

						</form>
			 </div>
				 <div class="modal-footer">
					 	<div class="col-xs-12 container">
							<div class="row">
						 		<div class="col-xs-4">
									 <a href="#">
										<!-- <i class="fa fa-facebook"></i>
										 <span class="hidden-xs">Facebook</span>
									 -->
									 <img src="<?php print LinkUtils::generatePublicLink('img/social/google.png'); ?>" width="150px" height="40px" />
									 </a>
						 		</div>
								<div class="col-xs-4">
									 <a href="#">
										 <!--<i class="fa fa-google-plus"></i>
										 		<span class="hidden-xs">Google+</span>
										 -->
										 <img src="<?php print LinkUtils::generatePublicLink('img/social/facebook.png'); ?>" width="150px" height="40px" />
									</a>
								</div>
							</div>
					 	</div>
					</div>
				</div>

			 </div>
		 </div>

<? endif; ?>
