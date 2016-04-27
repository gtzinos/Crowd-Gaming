<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/moderator/UserProfileManagement.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid text-center">
	<?php
		/*
			Emfanise mono liga stoixeia , px onoma , eponumo ktlp.
		 */

		if(exists("user"))
		{
			//var_dump( get("user") );
			$user = get("user");

		 	echo "
		<form id='user-edit-view-form' class='form-horizontal'>
			<div class='form-group has-feedback'>
				<div class='col-xs-offset-5 col-xs-2 col-md-offset-5 col-md-2'>
					<span class='text-center'>";
					if($user->getGender() == 0)
					{
						echo "<i class='fi-torso' style='font-size:150px;color:#36A0FF'> </i>";
					}
					else {
						echo "<i class='fi-torso-female' style='font-size:150px;color:#36A0FF'> </i>";
					}
		echo "</span>
				</div>
			</div>
			<div class='form-group has-feedback'>
				<div class='col-xs-2 col-md-offset-1 col-md-2'>
					<span class='text-center'><i class='material-icons bigicon'>mood</i></span>
				</div>
				<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='select'>
					<select id='edit-user-access' class='form-control' placeholder='Access Level (Required)' required>
					<option value='-' disabled>Access Level (*Required)</option>";
						if($user->getAccessLevel() == 1)
						{
							echo "<option value='1' selected>Player</option>
										<option value='2'>Examiner</option>";
						}
						else if($user->getAccessLevel() == 2){
							echo "<option value='1'>Player</option>
										<option value='2' selected>Examiner</option>";
						}
					echo "
					</select>
					<span class='gt-icon'></span>
				</div>
			</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-envelope bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='email'>
						<input id='edit-user-email' type='text' class='form-control' value='" . $user->getEmail() . "' data-toggle='tooltip' gt-error-message='Not a valid email address' placeholder='Email address (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-lock bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='8'>
						<input type='text' id='edit-user-new-password' class='form-control' value='' data-toggle='tooltip' gt-error-message='Not a valid password' placeholder='New password (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-lock bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='8' data-equal='edit-user-new-password'>
						<input id='edit-user-new-repeat-password' type='text' class='form-control' value='' data-toggle='tooltip' gt-error-message='Not a valid password' placeholder='Repeat new password (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-user bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='2'>
						<input id='edit-user-name' type='text' class='form-control' value='" . $user->getName() . "' data-toggle='tooltip' maxlength='25' gt-error-message='Not a valid first name' placeholder='First name (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-user bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='2'>
						<input id='edit-user-surname' type='text' class='form-control' value='" . $user->getSurname() . "' data-toggle='tooltip' maxlength='25' gt-error-message='Not a valid last name' placeholder='Last name (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='fi-male-female bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='select'>
						<select id='edit-user-gender' class='form-control' placeholder='Gender (Required)' required>
							<option value='-' disabled>Gender (*Required)</option>";
						if($user->getGender() == 0)
						{
							echo "<option value='0' selected>Male</option>
										<option value='1'>Female</option>";
						}
						else {
							echo "<option value='0'>Male</option>
										<option value='1' selected>Female</option>";
						}
					echo "
							</select>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-globe bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='3'>
						<input id='edit-user-country' type='text' class='form-control' value='" . $user->getCountry() . "' data-toggle='tooltip' maxlength='25' gt-error-message='Not a valid country name' placeholder='Country name (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='material-icons bigicon'>location_city</i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='3'>
						<input id='edit-user-city' type='text' class='form-control' value='" . $user->getCity() . "' data-toggle='tooltip' maxlength='25' gt-error-message='Not a valid city name' placeholder='City name (Required)' required>
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-home bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='length' data-length='5'>
						<input id='edit-user-address' type='text' class='form-control' value='" . $user->getAddress() . "' data-toggle='tooltip' maxlength='50' gt-error-message='Not a valid address name' placeholder='Address name (Optional)' >
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-earphone bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group' data-validate='phone'>
						<input id='edit-user-phone' type='text' class='form-control' value='" . $user->getPhone() . "' maxlength='15' data-toggle='tooltip' gt-error-message='Not a valid phone number' placeholder='Phone number (Optional)' >
						<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='glyphicon glyphicon-ban-circle bigicon'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group'>";
					if(!$user->getBanned())
					{
						echo "<input type='text' class='form-control' value='Not Banned' maxlength='10' placeholder='Banned ?' disabled>";
					}
					else {
						echo "<input type='text' class='form-control' value='Banned' maxlength='6' placeholder='Banned ?' disabled>";
					}
					echo "<span class='gt-icon'></span>
					</div>
				</div>
				<div class='form-group has-feedback'>
					<div class='col-xs-2 col-md-offset-1 col-md-2'>
						<span class='text-center'><i class='bigicon fa fa-trash-o' style='font-size: 35px'> </i></span>
					</div>
					<div class='col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group'>";
					if(!$user->getDeleted())
					{
						echo "<input type='text' class='form-control' value='Not Deleted' maxlength='11' placeholder='Deleted ?' disabled>";
					}
					else {
						echo "<input type='text' class='form-control' value='Deleted' maxlength='7' placeholder='Deleted ?' disabled>";
					}
					echo "<span class='gt-icon'></span>
					</div>
				</div>

					<div class='col-xs-offset-3 col-xs-3 col-md-offset-3 col-md-1'>
						<div class='dropdown'>
							<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Actions
							<span class='caret'></span></button>
							<ul class='dropdown-menu'>
								<li><input type='button' class='btn btn-link' onclick='update_user(" . $user->getId() . ",false)' value='Update profile'></li>";
								if(!$user->getBanned())
								{
									echo "<li><input type='button' class='btn btn-link' onclick='ban_user(" . $user->getId() . ",false)' value='Ban account'></li>";
								}
								else {
									echo "<li><input type='button' class='btn btn-link' onclick='unban_user(" . $user->getId() . ",false)' value='Unban account'></li>";
								}

								if(!$user->getDeleted())
								{
									echo "<li><input type='button' class='btn btn-link' onclick='delete_user(" . $user->getId() . ",false)' value='Delete Account'></li>";
								}
								else{
									echo "<li><input type='button' class='btn btn-link' onclick='undelete_user(" . $user->getId() . ",false)' value='Undelete Account' style='color:red;text-decoration: line-through;'></li>";

								}

				echo "</ul>
						</div>
					</div>

			</form>
";
		}
		/*
			User doesnt exists
		*/
		else
		{
			echo "<div class='text-center'> <label class='alert alert-danger '> User doesn't exist </label> </div>";
		}
	?>

	</div>

<?php endif; ?>
