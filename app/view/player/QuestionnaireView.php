<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

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
						if(get("questionnaire")["user-participates"])
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
			<div style="margin-left:73%">
				<button class="btn btn-primary round" type="button" onclick="showModal('questionnaire-options')">Options</button>
			</div>
		</div>

	</div>

<?php load("QUESTIONNAIRE_OPTIONS"); ?>
<?php endif; ?>
