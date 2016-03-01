<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

	<div id="section" class="container-fluid">
      <div class="row">
  	  	<h1>
  				Hello <?php print get("name") .' '. get("surname"); ?>
  			</h1>
      </div>
      <div class="row">
  	  	<h3>
  				Your account has been successfuly deleted.
  			</h3>
      </div>
      <div class="row">
  			<p>
  				You cant use this (<?php print get("email"); ?>) email address again.
  			</p>
      </div>
	</div>
<?php endif; ?>
