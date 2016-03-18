<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<div class="container-fluid">
					<?php
						if(exists("response-code")) {
							/*
								Initialize response message
							*/
							$response_message="	<div class='form-group'>
								<div class='col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6 text-center'>";

							/*
								If response-code = 0
								Everything is okay
							*/

							if(get("response-code") == 0)
							{
									$response_message .= "<label class='alert alert-success'>Your password has changed. Now you can login with the new one.";

							}
							/*
								If response-code = 1
								invalid password
							*/
							else if (get("response-code") == 1)
							{
								$response_message .= "<label class='alert alert-danger'>This not a valid password";
							}
							/*
								Else If response-code = 2
								General database error
							*/
							else if (get("response-code") == 2)
							{
								$response_message .= "<label class='alert alert-danger'>General database error. Please try later!";
							}
							/*
								Else If response-code = 3
								Expired taken id
							*/
							else if(get("response-code") == 3)
							{
								$response_message .= "<label class='alert alert-danger'>Reset password taken expired.";
							}
							/*
								Else a new error returned
							*/
							else
							{
								$response_message .= "<label class='alert alert-danger'>Something going wrong. Please contact with one administrator!";
							}
							$response_message .= "</label>";
							/*
								Echo responsed message
							*/
							echo $response_message;
							return;
						}
					?>
					<form class="form-horizontal" onsubmit="return !$('#reset-button').prop('disabled')" method="POST" >

								 <legend class="text-center header">Enter a new password</legend>
								 <!-- New Password Field -->
								 <div class="form-group has-feedback">
										 <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
											 <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
										 </div>
										 <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="8">
												 <input type="password" name="password" class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" placeholder="Password (Required) *Length >= 8" required />
												 <span></span>
										 </div>
								 </div>
								 <!-- Response Label Field -->
								 <div class="form-group">
									 <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
										 <label id="reset-response">

											 	<?php
												/*
													If server responsed
												*/
												if(exists("response-code")){
														/*
															Initialize response message
														*/
														$response_message="<label class='alert alert-danger'>";
														/*
															If response-code = 0
															Everything is okay
														*/

														if(get("response-code") == 0)
														{
																$response_message = "<label class='alert alert-success'>Your password changed. Now you can login with the new one.";
														}
														/*
															If response-code = 1
															invalid password
														*/
														else if (get("response-code") == 1)
														{
															$response_message .= "This not a valid password";
														}
														/*
															If response-code = 1
															General database error
														*/
														else if (get("response-code") == 2)
														{
															$response_message .= "General database error. Please try later!";
														}
														/*
															Else a new error returned
														*/
														else
														{
															$response_message .= "Something going wrong. Please contact with one administrator!";
														}
														$response_message .= "</label>";
														/*
															Echo responsed message
														*/
														echo $response_message;
												}
												?>
										 </label>
									 </div>
								 </div>
								 <!-- Reset password Button Field -->
								 <div class="form-group">
										<div class="col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6">
											<button id="reset-button" class="btn btn-primary btn-md submit" type="submit" disabled>Reset Password</button>
										</div>
								 </div>
					</form>
		</div>

<?php endif; ?>
