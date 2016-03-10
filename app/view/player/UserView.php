<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<?php
		/*
			Emfanise mono liga stoixeia , px onoma , eponumo ktlp.
		 */

		if(exists("user"))
		{
			var_dump( get("user") );
		}
		/*
			User doesnt exists
		*/
		else
		{
			echo "<div class='text-center'> <label class='alert alert-danger '> User doesn't exist </label> </div>";
		}
	?>

<?php endif; ?>
