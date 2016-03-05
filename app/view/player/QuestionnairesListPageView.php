<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/player/QuestionnairesList.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
	<script src="<?php print LinkUtils::generatePublicLink("js/player/QuestionnaireRequests.js"); ?>"></script>

<?php elseif($section == "MAIN_CONTENT" ) : ?>
<legend class="text-center header"> Enjoy our questionnaires </legend>

	<div class="form-group container-fluid">
		<div class='col-xs-12 row'>
			<label for="questionnaire-sort">Sort By:</label>
		</div>
		<div class="col-xs-12 col-sm-2 row">
			<select class="form-control" id="questionnaire-sort">
				<option value='1'>Name</option>
				<option value='2'>Popularity</option>
			</select>
		</div>
	</div>

	<div class="container-fluid col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
	  <div class="panel-group" id="accordion">
		<?php

			/*
				#1 Paramater = Button text
				#2 Parameter = Method to call
			*/
			$joined["0"] = array("Join Now" , "joinQuestionnaire");
			$joined["1"] = array("Unjoin" , "unJoinQuestionnaire");
			$i=0;
		  foreach(get("questionnaires") as $questionnaires)
			{
				/*

				*/

				$i++;
				echo "<div class='panel panel-info'>
			      			<div class='panel-heading text-center'>
			        			<p class='panel-title'>
											<a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $i . "'>
										"
											. $questionnaires["questionnaire"]->getName() .
										"
											</a>
										</p>
									</div>
									<div id='collapse" . $i . "' class='panel-collapse collapse'>
										<div class='panel-body' >
											<div class='questionnaire-time col-xs-12'>
												Time left : 14 Days
											</div>
											<div class='questionnaire-description col-xs-12'>
										"
											. $questionnaires["questionnaire"]->getSmallDescription() .
									 "  	<a href='#'>Learn More</a>
									 		</div>
											<div class='questionnaire-more-info'>
												<div style='margin-top:1%' class='col-xs-offset-0 col-xs-12'>
												Members:
									 "
									 				. $questionnaires["participations"] .
									 "		</div>
									 			<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>
													<button class='btn btn-primary round' type='button' onclick='"
													 . $joined[$questionnaires["user-participates"]][1] .
													 	"(" . $questionnaires["questionnaire"]->getId() . ")'>" . $joined[$questionnaires["user-participates"]][0] . " </button>
												</div>
											</div>
									  </div>
									</div>
							</div>
						  ";
			}
		?>
		</div>
	</div>

	<div class="container-fluid col-xs-12 col-sm-offset-2 col-sm-8	">
		<ul class="pager">
		  <li class="previous"><a href="#">Previous</a></li>
			<li>
				<label>
					<?php
						if(!isset($_GET['qp']))
							$_GET['qp'] = 1;
						echo "Page " . $_GET['qp'];
					?>
				</label>
			</li>
		  <li class="next"><a href="#">Next</a></li>
		</ul>
	</div>

<?php load("REQUEST_JOIN_QUESTIONNAIRE"); ?>
<?php endif; ?>
