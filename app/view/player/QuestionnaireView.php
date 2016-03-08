<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/player/QuestionnaireRequests.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<?php
		/*
			Questionnaire Object
		*/
		$questionnaire = get("questionnaire")["questionnaire"];
	?>
	<legend class="text-center header"> <?php echo $questionnaire->getName() ?> </legend>

	<div class="container-fluid">
		<div class="row">
			<div class="-xs-12 col-sm-offset-1 col-sm-5">
				<label> Posted : </label> <?php echo $questionnaire->getCreationDate() ?>
			</div>
			<div class="questionnaire-public col-xs-12 col-sm-offset-3 col-sm-3">
					<span class="mediumicon"> <i class='fa fa-globe'></i> </span>
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
				<a>Members :
					<?php
						if(get("questionnaire")["player-participation"])
						{
							echo "You and ";
						}
						echo get("questionnaire")["participations"] . " users";
					?>
				</a>
			</div>
			<div class="col-xs-12 col-sm-offset-2 col-sm-3">
				Language : <?php echo $questionnaire->getLanguage(); ?>
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
								Initialize user option
							*/
							$option = -1;

							if(isset($_POST["option"]) && filter_var($_POST['option'], FILTER_VALIDATE_INT)) $option = $_POST["option"];

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
									if($option == 1)
									{
										$response_message .= "Your request to be a player on this questionnaire sended successfully.";
									}
									/*
										User option == 2
										he needs to delete player request
									*/
									else if($option == 2)
									{
										$response_message .= "Your request to be a player deleted successfully.";
									}
									/*
										User option == 3
										he needs to unjoin as player
									*/
									else if($option == 3)
									{
										$response_message .= "You are no longer a player on this questionnaire.";
									}
									/*
										User option == 4s
										he needs to be an examiner
									*/
									else if($option == 4)
									{
										$response_message .= "You sent a request to be an examiner on this questionnaire.";
									}
									/*
										User option == 5
										he needs to delete examiner request
									*/
									else if($option == 5)
									{
										$response_message .= "Your request to be an examiner deleted successfully.";
									}
									/*
										User option == 6
										he needs to unjoin from examiners list
									*/
									else if($option == 6)
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
						if(isset($_SESSION["USER_LEVEL"])) {
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
									echo "<button type='button' class='btn btn-primary round' onclick=\"sendQuestionnaireRequest('player-join','Join as player');\" >Join questionnaire </button>";
								}
								/*
									If he have an active player request
								*/
								else if(get("questionnaire")["active-player-request"]) {
									echo "<button type='submit' class='btn btn-primary round' name='player-cancel-request' >Delete join request</button>";
								}
								/*
									If he is an accepted player
								*/
								else if(get("questionnaire")["player-participation"]) {
									/*
										He can unjoin from the players list
									*/
									echo "<button type='submit' class='btn btn-primary' name='player-unjoin' >Unjoin as player</button>";
								}
							}
							/*
								Else If he is an examiner
							*/
							else if($_SESSION["USER_LEVEL"] >= 2) {
								/*
									Echo dropdown button
								*/
								echo "<div class='dropdown' style='margin-left:73%'>
										    <button class='btn btn-primary dropdown-toggle round' type='button' data-toggle='dropdown'>Options
											  <span class='caret'></span></button>
											  <ul class='dropdown-menu'>
									";


									/*
										If he isnt a player
										and he didnt have an active request to be a player
									*/
									if(!get("questionnaire")["active-player-request"] && !get("questionnaire")["player-participation"])
									{
										/*
											He can make a request to be a player
										*/
										echo "<li><input type='button' class='btn btn-link' onclick=\"sendQuestionnaireRequest('player-join','Join as player');\" value='Join questionnaire' > </li>";
									}
									/*
										If he have an active player request
									*/
									else if(get("questionnaire")["active-player-request"]) {
										echo "<li><input type='submit' class='btn btn-link' name='player-cancel-request' value='Delete join request' > </li>";
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
										echo "<li><input type='button' class='btn btn-link' onclick=\"sendQuestionnaireRequest('examiner-join','Join as examiner')\" value='Send examiner request' > </li>";
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
									/*
										Close dropdown button
									*/
									echo "</ul></div>";
							}
						}
					?>
		    </ul>
			</div>
			</form>
	</div>

<?php load("QUESTIONNAIRE_OPTIONS"); ?>
<?php endif; ?>
