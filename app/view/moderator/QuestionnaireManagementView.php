<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/moderator/QuestionnaireManagement.css"); ?>">

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/QuestionnaireManagement.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/confirm-dialog.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
    if(isset($_GET["sort"]))
    {
      echo "<script> var questionnaire_sort = '" . $_GET["sort"] . "'; </script>";
    }
    else {
      echo "<script> var questionnaire_sort = ''; </script>";
    }

  ?>
	<legend class="text-center header">Questionnaire management panel</legend>
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
    <div class="container-fluid">
      <div class="list-group" id="questionnaire-list">

      </div>

      <?php
        load("CONFIRM_QUESTIONNAIRE_DELETION");
      ?>

    </div>


<?php endif; ?>
