<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<div id="section" class="container-fluid">
	  	<h1>
				Hello <?php print get("name") .' '. get("surname"); ?>
			</h1>
	  	<h3>
				Your account has been successfully created!
			</h3>
			<p>
				Only thing left to do is to verify your email.
				An email has been sent to <?php print get("email"); ?> ,
				please click the link that has been sent to you and your
				account will be activated.
			</p>
	</div>
<?php endif; ?>
