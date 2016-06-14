<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/moderator/QuestionnaireManagement.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css"); ?>">
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/css/bootstrap-select.min.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/QuestionnaireManagement.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/confirm-dialog.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-switch/dist/js/bootstrap-switch.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/js/bootstrap-select.min.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
    echo "<script>
      var questionnaire_page = '" . LinkUtils::generatePageLink('questionnaire') . "';
    ";
    if(isset($_GET["sort"]))
    {
      echo "var questionnaire_sort = '" . $_GET["sort"] . "';";
    }
    else {
      echo "var questionnaire_sort = '';";
    }
    echo "</script>";
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
        load("QUESTIONNAIRE_MANAGEMENT_SETTINGS");
      ?>

    </div>


<?php endif; ?>
