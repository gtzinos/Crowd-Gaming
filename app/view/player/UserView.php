<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<?php
		/*
			Emfanise mono liga stoixeia , px onoma , eponumo ktlp.
		 */

		if(exists("user")){
			var_dump( get("user") );
		}else{
			print 'User doesnt exist';
		}
	?>

<?php endif; ?>
