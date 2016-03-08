<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/player/QuestionnairesList.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>


<?php elseif($section == "MAIN_CONTENT" ) : ?>
<legend class="text-center header"> Enjoy our questionnaires </legend>
	<!-- Sort by form -->
	<div class="form-group container-fluid">
		<div class='col-xs-12 row'>
			<label for="questionnaire-sort">Sort By:</label>
		</div>
		<div class="col-xs-12 col-sm-2 row">
			<form class="form-horizontal" method="GET">
				<select id="sortmethod" name="sort" class="form-control" onchange="this.form.submit()">
					<option value='date'>Date</option>
					<option value='name'>Name</option>
					<option value='pop'>Popularity</option>
				</select>
			</form>
		</div>
	</div>
	<!-- Script to change the selected index -->
	<script>
			$('#sortmethod').val("<?php echo get("sort") ?>");
	</script>
	<!-- Questionnaires list design -->
	<div class="container-fluid col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
	  <div class="panel-group" id="accordion">
		<?php
			/*
					For each questionnaire
			*/
		  foreach(get("questionnaires") as $questionnaires)
			{
				/*
					First of all we need
					to find the correct image.
					public / private icon
				*/
				$icon = 'fa fa-globe';
				if($questionnaires["questionnaire"] -> getPublic() == 0)
				{
					$icon = 'glyphicon glyphicon-lock';
				}

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
												<span> <i class='" . $icon . " smallicon'></i> </span>
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
									 ";


					 						if($questionnaires["player-participation"])
					 						{
					 							echo "You and ";
					 						}
					 						echo $questionnaires["participations"] . " users";


									 			//	. $questionnaires["participations"] .
									echo "		</div>
									 			<div class='col-xs-offset-6 col-xs-4 col-sm-offset-9 col-sm-3'>
													<a class='btn btn-primary round' target='_blank' type='button' href=\""
													. LinkUtils::generatePageLink('questionnaire') . "/"
												  . $questionnaires["questionnaire"]->getId() . "\">Read More
													</a>
												</div>
											</div>
									  </div>
									</div>
							</div>
						  ";
			}

			if(get("pages_count") == 0)
			{
				echo "<center><label class='alert alert-danger'>We dont have questionnaires in our database.</label></center>";
			}
		?>
		</div>
	</div>

	<!-- Pager form -->
	<div class="container-fluid col-xs-12 col-sm-offset-2 col-sm-8	">

		<center>
			<ul class="pagination">

					<?php
							$pageLink = LinkUtils::generatePageLink('questionnaireslist') . '/' . get('sort') . '/';

							echo "<li> <a href='" . $pageLink . '1' ."'>I<</a></li>";
							if(get("page") > 1 && get("pages_count") > 1)
							{
								echo "<li> <a href='" . $pageLink . (get("page")-1) ."'>" . (get("page")-1) . "</a></li>";
							}
							else
							{
								echo "<li class='disabled'> <a href='href='#' onclick='return false'>.</a></li>";
							}

							echo "<li class='active'> <a onclick='return false'>" . get("page") . "</a></li>";

							if(get("page") < get("pages_count"))
							{
								echo "<li> <a href='" . $pageLink . (get("page")+1) ."'>" . (get("page")+1) . "</a></li>";
							}
							else {
								echo "<li class='disabled'> <a href='href='#' onclick='return false'>.</a></li>";
							}

							if(get("pages_count") > 0)
							{
								echo "<li> <a href='" . $pageLink . get("pages_count") ."'>>I</a></li>";
							}
							else {
								echo "<li> <a href='" . $pageLink . '1' ."'>>I</a></li>";
							}

					?>
			</ul>
		</center>
	</div>

<?php endif; ?>
