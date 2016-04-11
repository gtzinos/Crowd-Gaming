<? if($section == "SIGN_IN") : ?>
<div class="modal fade" id="loginModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Login Page</h4>
			 </div>
			 <div class="modal-body container-fluid">

					<form id="signin-form" onsubmit="return false" class="form-horizontal">
									<!-- Email Field -->
									<div class="form-group has-feedback">
											<div class="col-xs-offset-1 col-xs-2 col-md-offset-1 col-md-2">

														 <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
											</div>
											<div class="col-xs-offset-0 col-xs-8 col-md-offset-0 col-md-8 block gt-input-group" data-validate="email">
													<input class="form-control" data-toggle="tooltip" gt-error-message="Not a valid email address" id="signin-email" name="email" type="email" maxlength="40" placeholder="Email (Required)" required >
													<span class="gt-icon"></span>
											</div>
									</div>
									<!-- Password Field -->
									<div class="form-group has-feedback">
											<div class="col-xs-offset-1 col-xs-2">
												<span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
											</div>
											<div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="8">
													<input class="form-control" id="signin-password" data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" name="password" type="password" placeholder="Password (Required) *Length >= 8" required >
													<span class="gt-icon"> </span>
											</div>
									</div>
									<!-- Check box Field -->
									<div class="form-group">
										<div class="col-xs-offset-1 col-xs-5 col-sm-offset-3 col-sm-4">
												<span style="font-size:12px">
													<input id="signin-remember" type="checkbox" />
													Remember Me
												</span>
										</div>
										<div class="col-xs-offset-0 col-xs-6 col-sm-offset-1 col-sm-4">
												<span style="font-size:12px">
													<!-- This input help (Remember Me , Forgot password) to be on the same line -->
													<input id="signin-forgot" type="checkbox" style="visibility:hidden"/>
													<a href="#" onclick="return showModal('PasswordRecoveryModal')">Forgot Password?</a>
												</span>
										</div>
									</div>
									<!-- Login Button Field -->
									<div class="form-group">
										 <div class="col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-8">
											 <button type="button" class="btn btn-primary btn-md btn-block gt-submit" form="signin-form" onclick="signInFromForm()" disabled>Sign In</button>
											</div>
									</div>
						</form>
						<div style="margin-left:auto;width:130px">
							<span style="font-size:12px;">
								 <a href="" onclick="return showModal('registerModal')">
									 Not a member? Sign Up
								 </a>
							</span>
						</div>
						<!-- Spinner and Response Label Field -->
						<div class="form-group">
							<div class="col-xs-offset-3 col-xs-8 ">
								<div id="signin-spinner">

								</div>
								<label id="signin-response" class="responseLabel"></label>
							</div>
						</div>
					</div>
					<!-- Foot Fields
					<!-- Footer container fluid ( Fluid is a container on a parent container.For this form parent=modal) -->
					<!--
					<div class="modal-footer container-fluid">

							 <div class="col-xs-offset-0 col-xs-3 col-sm-offset-0 col-sm-2">
									<a href="#">
										<img src="<?php print LinkUtils::generatePublicLink('img/social/facebook.png'); ?>" alt="Login via Facebook" width="40" height="35" />
									</a>
							 </div>

								<div class="col-xs-offset-0 col-xs-3 col-sm-offset-0 col-sm-2 g-signin2" data-onsuccess="onSignIn" data-theme="dark">
										 <img src="<?php print LinkUtils::generatePublicLink('img/social/google.png'); ?>"  alt="Login via Google Plus" width="40" height="35" />
								</div>
							-->
							 <script>
							 /*
								 function onSignIn(googleUser) {
									 // Useful data for your client-side scripts:
									 var profile = googleUser.getBasicProfile();

									 if(profile == null)
									 {
										 window.alert("not ok");
									 }
									 else
									 {
										 window.alert("ok");
									 }
									 console.log("ID: " + profile.getId()); // Don't send this directly to your server!
									 console.log("Name: " + profile.getName());
									 console.log("Image URL: " + profile.getImageUrl());
									 console.log("Email: " + profile.getEmail());

									 // The ID token you need to pass to your backend:
									 var id_token = googleUser.getAuthResponse().id_token;
									 console.log("ID Token: " + id_token);
								 };
								 */
							 </script>

						<!--
							 <br><br>
							 <div class="col-xs-12"> </div>
							 <div style="margin-left:auto;">
								 <span style="font-size:12px">
										<a href="" onclick="return showModal('registerModal')">
											Not a member? Sign Up
										</a>
								 </span>
							 </div>

					</div> -->
			 </div>
		 </div>
	</div>
<? endif; ?>
