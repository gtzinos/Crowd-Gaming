<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
  <!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1P_ouQbGN0ehtuSm58zqrYxS-YPk4XwM" type="text/javascript"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroupsUsingGoogleMap.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
<div class="container-fluid">
  <!-- Title -->
  <legend class="text-center header">Questionnaire Groups</legend>
  <!-- ShortCut Buttons -->
  <div class="form-group has-feedback">
    <div class="col-xs-offset-0 col-xs-1 col-md-1">
      <a class="btn btn-primary gt-submit" href="<?php echo LinkUtils::generatePageLink('create-questionnaire-groups') ?>">Add</a>
    </div>
  </div>

</div>
<?php endif; ?>
