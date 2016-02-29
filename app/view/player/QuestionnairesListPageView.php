<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/player/QuestionnairesList.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>


	<div id="section" class="container-fluid">
	  <div class="col-xs-12 questionnaire-group">
			<div class="col-xs-12 questionnaire-item">
				<div class="col-xs-12 questionnaire-header">
					<label> Questionaire 1 bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</label>
				</div>
				<div class="col-xs-12 questionnaire-info">
						<div class="col-xs-6">
							<br>
							<p>
								Start : 28/02/2016 5:00:00
							</p>
							<p>
								End : 28/02/2016 6:00:00
							</p>
								<p>
									Joined: 10
								</p>
						</div>
						<div class="col-xs-6" style="margin-top:5%;">
							<button type="button" class="btn btn-primary btn-md round submit">Learn More</button>
						</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 questionnaire-group">
			<div class="col-xs-12 questionnaire-item">
				<div class="col-xs-12 questionnaire-header">
					<label> Questionaire 1 bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</label>
				</div>
				<div class="col-xs-12 questionnaire-info">
						<button type="button" class="btn btn-primary btn-md round submit">Join Us</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
