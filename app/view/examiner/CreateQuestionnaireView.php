<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionnaire.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
			<legend class="text-center header">Create a new questionnaire</legend>
			<form method="POST" class="form-horizontal" action="return false">
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
								 <textarea class="form-control mce-editor" style="height:150px" id="editor" data-toggle="tooltip" gt-error-message="Must contain at least 30 characters" id="editor" id="questionnaire-description" placeholder="Questionnaire Description (Required) *Length >= 20" required ></textarea>
								 	<span class="gt-icon"></span>
							</div>
					</div>
					<!-- Message Required -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
								<label for="email">Would you like users send a password ?</label>
							</div>
							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="length" data-length="2">
								<select id="message-required" class="form-control" data-toggle="tooltip" gt-error-message="Not a valid gender type" required>
									<option value="-" disabled selected>Message Required</option>
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>
								 <span class="gt-icon"></span>
							</div>
					</div>
					<br>
					<!-- Create questionnaire submit button -->
					<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6">
						<button type="button" class="btn btn-primary gt-submit" onclick="createQuestionnaire()">Create questionnaire</button>
					</div>
					<!-- Response Label Field -->
          <div class="form-group" style="margin-top:5%">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
              <label id="questionnaire-create-response" class="responseLabel">
                <?php
                   /*
                     Display errors
                   */
                ?>
              </label>
            </div>
          </div>
		</form>
		<!-- fa fa-pencil-square-o -->


	</div>

<?php endif; ?>
