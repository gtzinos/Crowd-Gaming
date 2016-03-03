<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
		<form class="form-horizontal" method="POST" action="<?php echo LinkUtils::generatePageLink('become-examiner'); ?>">
				<legend class="text-center header">Become an Examiner</legend>

				<!-- Message Text Field -->
				<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
								<span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
						</div>
						<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="20">
								<textarea class="form-control" maxlength="250" name="application_text" placeholder="Why you should be an examiner on our server ?" required></textarea>
								<span></span>
						</div>
				</div>
				<!-- Submit Button Field -->
				<div class="form-group has-feedback">
						<div class="col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6 gt-input-group">
								<button id="submit" type="submit" class="btn btn-primary btn-lg submit" disabled>Send Message</button>
						</div>
				</div>
				<!-- Response Label Field -->
				<div class="form-group">
					<div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
						<label id="request-examiner-response">
								<?php

									if(exists("response-code"))
									{
										/*
											If response-code == 0
											then request sended successfully
										*/
										if(get("response-code") == 0)
										{
											echo "<div class='alert alert-success'>Request for examiner application sended successfully.</div>";
										}
										/*
											Else If response-code == 1
											then user = examiner
										*/
										else if(get("response-code") == 1)
										{
											echo "<div class='alert alert-success'>You have already (examiner or moderator) access on our server.</div>";
										}
										/*
											Else If response-code == 1
											then user must fill all informations
										*/
										else if(get("response-code") == 2)
										{
											echo "<div class='alert alert-danger'>You must fill all of <a href='" . LinkUtils::generatePageLink('profile') . "'>Profile</a> Informations</div>";
										}
										/*
											Else If response-code == 3
											then User has already an active application
										*/
										else if(get("response-code") == 3)
										{
											echo "<div class='alert alert-danger'>You have already an active request application. Please wait for an administrator response.</div>";
										}
										/*
											Else If response-code == 4
											then ApplicationText validation error
										*/
										else if(get("response-code") == 4)
										{
											echo "<div class='alert alert-danger'>This is not a valid text. You must explain us why you should be an examiner.</div>";
										}
										/*
											Else If response-code == 5
											then General database error
										*/
										else if(get("response-code") == 5)
										{
											echo "<div class='alert alert-danger'>General database error. Please try later!</div>";
										}
										/*
											Else a new error returned
										*/
										else
										{
											echo "<div class='alert alert-danger'>Something going wrong. Please contact with one administrator!</div>";
										}
									}
								?>
						</label>
					</div>
				</div>
		</form>
	<p  class="text-center">Join our team of examiners and contribute and even create your own questionnaires!</p>


<?php endif; ?>
