<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/css/bootstrap-select.min.css"); ?>">
<!-- JUST TEST IGNORE	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/clockpicker/dist/bootstrap-clockpicker.min.css"); ?>">
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/daterangepicker/daterangepicker.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/player/QuestionnaireRequests.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/confirm-dialog.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/js/bootstrap-select.min.js"); ?>"></script>
<!-- JUST TEST IGNORE <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/coordinator/QuestionnaireSettings.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/clockpicker/dist/bootstrap-clockpicker.min.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/clockpicker-manager.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/agent-detector.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/daterangepicker/moment.min.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/daterangepicker/daterangepicker.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/daterangepicker-manager.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<?php
		/*
			Questionnaire Object
		*/
		$questionnaire = get("questionnaire")["questionnaire"];
		echo "<script> var questionnaire_id = " . $questionnaire->getId() . "; </script>";
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-offset-7 col-xs-5 col-sm-offset-10 col-sm-2">
				<div class="progress">
					<!-- active title gives background animation -->
					<div class="glyphicon glyphicon-globe progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width:100%">
						Stopped
					</div>
				</div>
			</div>
		</div>
	<legend class="text-center header" style="margin:0px;padding:0px"> <?php echo $questionnaire->getName() ?> </legend>
		<div class="row">
			<div class="col-xs-7 col-sm-offset-1 col-sm-3">
				<label>On : </label> <?php echo $questionnaire->getCreationDate() ?>
			</div>
			<div class="questionnaire-public col-xs-offset-2 col-xs-2 col-sm-offset-6 col-sm-2">
				<?php
					if($_SESSION["USER_LEVEL"] >= 2 && get("questionnaire")["examiner-participation"])
					{
						echo "
						<div class='dropdown'>
					    <span class='fi-widget dropdown-toggle mediumicon' type='button' data-toggle='dropdown'>
					    <span style='display:none' class='caret'></span></span>
					    <ul class='dropdown-menu' >
					      <!-- <li class='dropdown-header'>Dropdown header 1</li> -->
								<!-- <li class='divider'></li> --> ";
		 						echo "<li class='settingsitem'><a onclick=\"showModal('edit-questionnaire'); return false;\"><i class='glyphicon glyphicon-edit'></i> Edit Content</a></li>";
							if($_SESSION["USER_ID"] == $questionnaire->getCoordinatorId() || $_SESSION["USER_LEVEL"] == 3)
							{
								echo "<li class='settingsitem'><a onclick=\"showModal('manage-questionnaire-members'); return false;\"><i  class='fa fa-users'></i> Manage Members</a></li>";
								echo "<li class='settingsitem'><a onclick=\"showModal('questionnaire-settings'); return false;\"><i  class='fa fa-cogs'></i> Settings & Requests</a></li>";
							}
						echo "</ul>
							</div>";
					}
	 			?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-1 col-sm-9">
					<?php
						echo $questionnaire->getDescription();
					?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-1 col-sm-5">
				<?php
				/*
					If questionnaire is public
				*/
				if($questionnaire -> getMessageRequired() == 1 )
				{
					echo "<span style='color:grey'> <i class='fi-lock'> </i>Message required</span>";
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-1 col-sm-5">
				<a onclick="showModal('questionnaire-players')">Players :
					<?php
						if(get("questionnaire")["player-participation"])
						{
							echo "You and ";
							$users = get("questionnaire")["participations"] - 1;

							echo $users . " users";
						}
						else {
							if(get("questionnaire")["participations"] > 1)
							{
								echo get("questionnaire")["participations"] . " users";
							}
							else {
								echo get("questionnaire")["participations"] . " user";
							}

						}
					?>
				</a>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-1 col-sm-7">
				<?php
						/*
							0  : All ok
							1  : Message validation error
							2  : Invalid Option
							3  : Player already participates
							4  : Player has already an active request
							5  : User has no active request to delete
							6  : User is not participating as player
							7  : Unauthorized action, user level is too low
							8  : Examiner already participates
							9  : Examiner already has an active request
							10 : User has no active examiner request to delete
							11 : User is not participating as examiner
							12 : General Database Error
						*/

						/*
							Server response
						*/
						if(exists("response-code")){
							/*
								Initialize response message
							*/
							$response_message="<label class='alert alert-danger'>";

							/*
								If response-code = 0
								Everything are okay
							*/
							if(get("response-code") == 0)
							{
								/*
									Initialize success class
								*/
								$response_message = "<label class='alert alert-success'>";
								/*
									User option == 1
									he need to be a player
								*/
								if(isset($_POST['player-join']))
								{
									$response_message .= "Your request to be a player on this questionnaire sended successfully.";
								}
								/*
									User option == 2
									he needs to delete player request
								*/
								else if(isset($_POST['player-cancel-request']))
								{
									$response_message .= "Your request to be a player deleted successfully.";
								}
								/*
									User option == 3
									he needs to unjoin as player
								*/
								else if(isset($_POST['player-unjoin']))
								{
									$response_message .= "You are no longer a player on this questionnaire.";
								}
								/*
									User option == 4s
									he needs to be an examiner
								*/
								else if(isset($_POST['examiner-join']))
								{
									$response_message .= "You sent a request to be an examiner on this questionnaire.";
								}
								/*
									User option == 5
									he needs to delete examiner request
								*/
								else if(isset($_POST['examiner-cancel-request']))
								{
									$response_message .= "Your request to be an examiner deleted successfully.";
								}
								/*
									he needs to contact with coordinator
								*/
								else if(isset($_POST['contact-message']))
								{
									$response_message .= "Your message sended successfully.";
								}
								/*
									User option == 6
									he needs to unjoin from examiners list
								*/
								else if(isset($_POST['examiner-unjoin']))
								{
									$response_message .= "You are no longer an examiner on this questionnaire.";
								}
							}
							/*
								Else If response-code = 1
								then Message validation error
							*/
							else if(get("response-code") == 1)
							{
								$response_message .= "This is not a valid message.";
							}
							/*
								Else If response-code = 2
								then Invalid Option
							*/
							else if(get("response-code") == 2)
							{
								$response_message .= "This is not a valid option.";
							}
							/*
								Else If response-code = 3
								then Player already participates
							*/
							else if(get("response-code") == 3)
							{
								$response_message .= "You have already participate on this questionnaire.";
							}
							/*
								Else If response-code = 4
								then Player has already an active request
							*/
							else if(get("response-code") == 4)
							{
								$response_message .= "You have already an active request.";
							}
							/*
								Else If response-code = 5
								then User has no active request to delete
							*/
							else if(get("response-code") == 5)
							{
								$response_message .= "You have no active request to delete.";
							}
							/*
								Else If response-code = 6
								then User is not participating as player
							*/
							else if(get("response-code") == 6)
							{
								$response_message .= "You are not participating as player.";
							}
							/*
								Else If response-code = 7
								then Unauthorized action, user level is too low
							*/
							else if(get("response-code") == 7)
							{
								$response_message .= "Unauthorized action, your access level is too low.";
							}
							/*
								Else If response-code = 8
								then Examiner already participates
							*/
							else if(get("response-code") == 8)
							{
								$response_message .= "You have already examiner access on this questionnaire.";
							}
							/*
								Else If response-code = 9
								then Examiner already has an active request
							*/
							else if(get("response-code") == 9)
							{
								$response_message .= "You have already an active examiner request.";
							}
							/*
								Else If response-code = 10
								then User has no active examiner request to delete
							*/
							else if(get("response-code") == 10)
							{
								$response_message .= "You have no active examiner request to delete.";
							}
							/*
								Else If response-code = 11
								then User is not participating as examiner
							*/
							else if(get("response-code") == 11)
							{
								$response_message .= "You are not participating as examiner.";
							}
							/*
								Else If response-code = 12
								then General Database Error
							*/
							else if(get("response-code") == 12)
							{
								$response_message .= "General Database Error. Please try later!";
							}
							/*
								Else If response-code = 13
								then not a valid message
							*/
							else if(get("response-code") == 13)
							{
								$response_message .= "This is not a valid message text.";
							}
							/*
								Else If response-code = 14
								then cant send emails right now
							*/
							else if(get("response-code") == 14)
							{
								$response_message .= "We can't send emails right now. Please try later!";
							}
							/*
								Else one new error occur
							*/
							else {
									$response_message .= "Something going wrong. Please contact with one administrator!";
							}

							if($response_message != "")
							{
								echo $response_message;
								echo "</label>";
							}
						}
				?>
			</div>
					<form method="POST">
					<?php
						/*
							If he is logged in
						*/
						if(isset($_SESSION["USER_LEVEL"]) && $_SESSION["USER_ID"] != $questionnaire->getCoordinatorId()) {

							/*
								Echo dropdown button
							*/
							echo "<div class='dropdown' style='margin-left:73%'>
											<button class='btn btn-primary dropdown-toggle round' type='button' data-toggle='dropdown'>Options
											<span class='caret'></span></button>
											<ul class='dropdown-menu'>
								";

							/*
								Simple player
							*/
							if($_SESSION["USER_LEVEL"] == 1)
							{

								/*
									If he isnt a player
									and he didnt have an active request to be a player
								*/
								if(!get("questionnaire")["active-player-request"] && !get("questionnaire")["player-participation"])
								{
									/*
										He can make a request to be a player
									*/
									if($questionnaire -> getMessageRequired() == 1 )
									{
										echo "<li><input type='button' class='btn btn-link' value='Join as player' onclick=\"sendQuestionnaireRequest('player-join','Join as player');\" /> </li>";
									}
									else {
										echo "<li><input type='submit' class='btn btn-link' value='Join as player' name='player-join' /> </li>";
									}
								}
								/*
									If he have an active player request
								*/
								else if(get("questionnaire")["active-player-request"]) {
									echo "<li><input type='submit' class='btn btn-link' name='player-cancel-request' value='Delete player request' ></li>";
								}
								/*
									If he is an accepted player
								*/
								else if(get("questionnaire")["player-participation"]) {
									/*
										He can unjoin from the players list
									*/
									echo "<li> <input type='submit' class='btn btn-link' name='player-unjoin' value='Unjoin as player'></li>";
								}
							}
							/*
								Else If he is an examiner
							*/
							else if($_SESSION["USER_LEVEL"] >= 2) {

									/*
										If he isnt a player
										and he didnt have an active request to be a player
									*/
									if(!get("questionnaire")["active-player-request"] && !get("questionnaire")["player-participation"])
									{
										/*
											He can make a request to be a player
										*/
										if($questionnaire -> getMessageRequired() == 1 )
										{
											echo "<li><input type='button' class='btn btn-link' onclick=\"sendQuestionnaireRequest('player-join','Join as player');\" value='Join as player' > </li>";
										}
										else {
											echo "<li><input type='submit' class='btn btn-link' name='player-join' value='Join as player' > </li>";
										}

									}
									/*
										If he have an active player request
									*/
									else if(get("questionnaire")["active-player-request"]) {
										echo "<li><input type='submit' class='btn btn-link' name='player-cancel-request' value='Delete player request' > </li>";
									}
									/*
										If he is an accepted player
									*/
									else if(get("questionnaire")["player-participation"]) {
										/*
											He can unjoin from the players list
										*/
										echo "<li><input type='submit' class='btn btn-link' name='player-unjoin' value='Unjoin as player' > </li>";
									}
								/*
									If he isnt an examiner and
									he didnt have an active request to be a examiner
								*/
									if(!get("questionnaire")["active-examiner-request"] && !get("questionnaire")["examiner-participation"])
									{
										/*
											He can send a request to be one
										*/
										if($questionnaire -> getMessageRequired() == 1 )
										{
											echo "<li><input type='button' class='btn btn-link' onclick=\"sendQuestionnaireRequest('examiner-join','Join as examiner')\" value='Join as examiner' > </li>";
										}
										else {
											echo "<li><input type='submit' class='btn btn-link' name='examiner-join' value='Join as examiner' > </li>";
										}

									}
									/*
										If he had an active examiner request
									*/
									else if(get("questionnaire")["active-examiner-request"])
									{
										/*
											He can delete his request
										*/
										echo "<li><input type='submit' class='btn btn-link' name='examiner-cancel-request' value='Delete examiner request' > </li>";
									}
									/*
										If he is one of the examiners
									*/
									else if(get("questionnaire")["examiner-participation"])
									{
										/*
											He can unjoin from examiner list
										*/
										echo "<li><input type='submit' class='btn btn-link' name='examiner-unjoin' value='Unjoin as examiner' > </li>";
									}

							}

							/*
								Contact with the coordinator
							*/
							echo "<li><input type='button' onclick=\"showModal('contact-modal')\" class='btn btn-link' value='Ask something' > </li>";

							/*
								Close dropdown button
							*/
							echo "</ul></div>";
						}
					?>
		    </ul>
			</div>
			</form>
	</div>

<?php
	load("QUESTIONNAIRE_OPTIONS");
	load("QUESTIONNAIRE_PLAYERS");
	load("CONTACT_WITH_ONE_EMAIL");
	/*
		Illegal actions
	*/
	if(get("questionnaire")["examiner-participation"])
	{
		load("EDIT_QUESTIONNAIRE");
	}
	if($questionnaire->getCoordinatorId() == $_SESSION["USER_ID"] || $_SESSION['USER_LEVEL'] == 3)
	{
			load("QUESTIONNAIRE_MEMBERS");
			load("QUESTIONNAIRE_SETTINGS");
			load("REQUIRED_MESSAGE");
	}

?>

<?php endif; ?>
