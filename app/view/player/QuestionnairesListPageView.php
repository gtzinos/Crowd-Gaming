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
			<form class="form-horizontal" method="GET">
				<select name="sort" class="form-control" onchange="this.form.submit()" >
					<option value='new'>Date</option>
					<option value='name'>Name</option>
					<option value='pop'>Popularity</option>
				</select>
			</form>
		</div>
	</div>

	<div class="container-fluid col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
	  <div class="panel-group" id="accordion">
		<?php

		  foreach(get("questionnaires") as $questionnaires)
			{
				/*
					Design for each questionnaire
				*/
				echo "<div class='panel panel-info'>
			      			<div class='panel-heading text-center'>
			        			<p class='panel-title'>
											<a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $questionnaires["questionnaire"]->getId() . "'>
										"
											. $questionnaires["questionnaire"]->getName() .
										"
											</a>
										</p>
									</div>
									<div id='collapse" . $questionnaires["questionnaire"]->getId() . "' class='panel-collapse collapse'>
										<div class='panel-body'>
											<div class='questionnaire-time' style='margin-left:98%;'>
												<span> <i class='fa fa-globe smallicon'></i> </span>
											</div>
											<div class='questionnaire-description col-xs-12'>
										"
											. $questionnaires["questionnaire"]->getSmallDescription() .
									 "  	. . .
									 		</div>
											<div class='questionnaire-more-info'>
												<div style='margin-top:1%' class='col-xs-offset-0 col-xs-12'>
													<label>
														Members
													</label> :
									 "
									 				. $questionnaires["participations"] .
									 "		</div>
									 			<div class='col-xs-offset-4 col-xs-4 col-sm-offset-8 col-sm-4'>
													<a class='btn btn-primary round' target='_blank' type='button' href=\""
													. LinkUtils::generatePageLink('become-examiner') . "/"
												  . $questionnaires["questionnaire"]->getId() . "\">	Learn More
													</a>
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
		  <li class="previous"><a href="#"><label><</label></a></li>
			<li>
				<label>
					<?php
						if(!isset($_GET['qp']))
							$_GET['qp'] = 1;
						echo "Page " . $_GET['qp'];
					?>
				</label>
			</li>
		  <li class="next"><a href="#"><label>></label></a></li>
		</ul>
	</div>

<?php load("REQUEST_JOIN_QUESTIONNAIRE"); ?>
<?php endif; ?>
