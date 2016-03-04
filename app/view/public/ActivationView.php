<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<?php
		/*
			Everything is ok
		*/
		if(get("response-code") == 0)
		{
			echo "<h1>Your email verified successfully.</h1>";
			echo "<p>Now you can log in with this on our system.</p>";
		}
		/*
			Error code = 1
			Invalid activation link
		*/
		else if(get("response-code") == 1)
		{
			echo "<h1>Invalid activation link.</h1>";
		}
		/*
			Error code = 2
			General database error
		*/
		else if(get("response-code") == 2)
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
