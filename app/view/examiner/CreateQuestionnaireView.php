<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
		<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionnaire.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
			<?php
					echo "  <script>
										var questionnaire_view_page = '" . LinkUtils::generatePageLink('questionnaire') . "';
									</script>";
			?>
			<legend class="text-center header">Create a new questionnaire</legend>
			<form method="POST" class="form-horizontal" onsubmit="return false">
					<!-- Questionnaire Name -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="email">Name</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="length" data-length="2">
								 <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="questionnaire-name" type="text" maxlength="255" placeholder="Questionnaire name (Required)" required>
								 <span class="gt-icon"></span>
							</div>
					</div>
					<!-- Questionnaire Description -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="email">Description</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="length" data-length="30">
								 <textarea class="form-control mce-editor" style="height:150px" id="editor" data-toggle="tooltip" id="editor" id="questionnaire-description" required></textarea>
								 	<span class="gt-icon"></span>
							</div>
					</div>
					<!-- Allow multiple groups playthrough ? -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="allow-multiple-groups-playthrough">Allow multiple groups playthrough ?</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="select">
								<select id="allow-multiple-groups-playthrough" class="form-control" required>
									<option value="-" disabled selected>Allow ?</option>
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
								<span class="gt-icon"></span>
							</div>
					</div>
					<!-- Score rights -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="score_rights">Who will have access on scores ?</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="select">
								<select id="score_rights" class="form-control">
									<option value="-" disabled selected>Who ? (Optional)</option>
									<option value="1">Everyone</option>
									<option value="2">Examiners, Moderators</option>
									<option value="3">Coordinator, Moderators</option>
								</select>
								<span class="gt-icon"></span>
							</div>
					</div>
					<!-- Password Required -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="email">Would you like users send a password ?</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="select">
								<select id="message-required" class="form-control" required>
									<option value="-" disabled selected>Password Required</option>
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>
								 <span class="gt-icon"></span>
							</div>
					</div>
					<!-- Questionnaire password -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="password">Questionnaire password</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="length" data-length="3">
								<input disabled id="questionnaire-password" type="password" class="form-control" maxlength="255" gt-error-message="Must contain at least 3 character">
								 <span class="gt-icon"></span>
							</div>
					</div>
					<br>
					<!-- Response Label Field -->
					<div class="form-group">
						<div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
							<div id="create-questionnaire-spinner"></div>
							<label id="questionnaire-create-response" class="responseLabel">
							</label>
						</div>
					</div>
					<!-- Create questionnaire submit button -->
					<div class="form-group has-feedback">
						<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6">
							<button id="create-questionnaire-submit" type="button" class="btn btn-primary gt-submit" onclick="createQuestionnaire()">Create questionnaire</button>
						</div>
					</div>
		</form>
		<!-- fa fa-pencil-square-o -->
	</div>

<?php endif; ?>
