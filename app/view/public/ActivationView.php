<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<?php

		if(get("error-code") == 0)
		{
			echo "<h1>Register completed successfull.</h1>";
			echo "<p>Now you can log in on our system.</p>"
		}
		else if(get("error-code") == 1)
		{
			echo "<h1>Invalid activation link.</h1>"
		}
		else if(get("error-code") == 2)
		{
			echo "<h1>Something going wrong (General Database Error)</h1>";
		}
		else {
			echo "<h1>Something going wrong.Please contact with one administrator.</h1>";
		}
	?>

<?php endif; ?>
