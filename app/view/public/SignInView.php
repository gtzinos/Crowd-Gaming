<? if($section == "SIGN_IN") : ?>
<div class="modal fade" id="loginModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h4><span class="glyphicon glyphicon-lock"></span> Login Page</h4>
			 </div>
			 <div class="modal-body container-fluid">

					<form class="form-horizontal">
						<!--   <div class="container-fluid"> -->
									<!-- Email Field -->
									<div class="form-group has-feedback">
											<div class="col-xs-offset-1 col-xs-3 col-md-offset-1 col-md-3">
														 <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
											</div>
											<div class="col-xs-offset-0 col-xs-8 col-md-offset-0 col-md-8 block gt-input-group" data-validate="email">
													<input class="form-control" id="signin-email" name="email" type="email" maxlength="40" placeholder="Email (Required)" required >
													<span></span>
											</div>
									</div>
									<!-- Password Field -->
									<div class="form-group has-feedback">
											<div class="col-xs-offset-1 col-xs-3">
												<span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
											</div>
											<div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="8">
													<input class="form-control" id="signin-password" name="password" type="password" placeholder="Password (Required) *Length >= 8" required >
													<span> </span>
											</div>
									</div>
									<!-- Check box Field -->
									<div class="form-group">
										<div class="col-xs-offset-1 col-xs-5 col-sm-offset-4 col-sm-4">
												<span style="font-size:12px">
													<input id="signin-remember" type="checkbox" />
													Remember
												</span>
										</div>
										<div class="col-xs-offset-0 col-xs-6 col-sm-offset-0 col-sm-4">
												<spa`n style="font-size:12px">
													<!-- This input help (Remember Me , Forgot password) to be on the same line -->
													<input id="signin-remember" type="checkbox" style="visibility:hidden"/>
													<a href="<?php print LinkUtils::generatePageLink("forgot-my-password");?>">Forgot Password?</a>
												</span>
										</div>
									</div>
									<!-- Spinner and Response Label Field -->
									<div class="form-group">
										<div class="col-xs-offset-4 col-xs-8 ">
											<div id="signin-spinner">

											</div>
											<label id="signin-response" class="responseLabel"></label>
										</div>
									</div>
									<!-- Login Button Field -->
									<div class="form-group">
										 <div class="col-xs-offset-4 col-xs-4">
											 <button type="button" class="btn btn-primary btn-md btn-block round submit" onclick="signIn()" disabled>Sign In</button>
											</div>
									</div>
						</form>
					</div>
					<!-- Foot Fields -->
					<!-- Footer container fluid ( Fluid is a container on a parent container.For this form parent=modal) -->
					<div class="modal-footer container-fluid">
							<!-- Facebook icon -->
							 <div class="col-xs-offset-0 col-xs-3 col-sm-offset-0 col-sm-2">
									<a href="#">
										<img src="<?php print LinkUtils::generatePublicLink('img/social/facebook.png'); ?>" width="40px" height="35px" />
									</a>
							 </div>
							 <!-- Google account icon -->
							 <div class="col-xs-offset-0 col-xs-3 col-sm-offset-0 col-sm-2">
									<a href="#">
										<img src="<?php print LinkUtils::generatePublicLink('img/social/google.png'); ?>" width="40px" height="35px" />
								 </a>
							 </div>
							 <br><br>
							 <div class="col-xs-12"> </div>
							 <div style="margin-left:auto;">
								 <span style="font-size:12px">
										<a href="" onclick="return showModal('registerModal')">
											Not a member? Sign Up
										</a>
								 </span>
							 </div>
					</div>
			 </div>
		 </div>
	</div>
<? endif; ?>
