<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<?php
		/*
			Everything is ok
		*/
		if(get("error-code") == 0)
		{
			echo "<h1>Register completed successfull.</h1>";
			echo "<p>Now you can log in on our system.</p>";
		}
		/*
			Error code = 1
			Invalid activation link
		*/
		else if(get("error-code") == 1)
		{
			echo "<h1>Invalid activation link.</h1>";
		}
		/*
			Error code = 2
			General database error
		*/
		else if(get("error-code") == 2)
		{
			echo "<h1>Something going wrong (General Database Error)</h1>";
		}
		/*
			Else
			Something going wrong
		*/
		else
		{
			echo "<h1>Something going wrong.Please contact with one administrator.</h1>";
		}
	?>

<?php endif; ?>
