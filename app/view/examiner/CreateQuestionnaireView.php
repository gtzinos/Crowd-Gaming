<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/manageQuestionnaires.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
			<legend class="text-center header">Create a new questionnaire</legend>
			<form method="POST" class="form-horizontal" action="return false">
					<!-- Questionnaire Name -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-2 col-md-offset-2 col-md-1">
								<span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
							</div>
							<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
								 <input class="form-control" id="questionnaire-name" type="text" maxlength="255" placeholder="Questionnaire name (Required) *Length >= 2" required >
								 <span></span>
							</div>
					</div>
					<!-- Questionnaire Description -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-2 col-md-offset-2 col-md-1">
								<span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
							</div>
							<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="20">
								 <textarea style="height:100px" class="form-control" id="questionnaire-description" placeholder="Questionnaire Description (Required) *Length >= 20" required ></textarea>
								 <span></span>
							</div>
					</div>
					<!-- Message Required -->
					<div class="form-group has-feedback">
							<div class="col-xs-offset-0 col-xs-2 col-md-offset-2 col-md-1">
								<span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
							</div>
							<div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
								<select id="message-required" class="form-control">
									<option value="-" disabled selected>Message Required ? </option>
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>
								 <span></span>
							</div>
					</div>
					<br>
					<!-- Create questionnaire submit button -->
					<div class="col-xs-offset-1 col-xs-9 col-md-offset-3 col-md-6">
						<button type="button" class="btn btn-primary submit" onclick="createQuestionnaire()" >Create questionnaire</button>
					</div>
					<!-- Spinner and Response Label Field -->
          <div class="form-group">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-6">
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
