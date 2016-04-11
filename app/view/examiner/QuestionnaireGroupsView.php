<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/examiner/QuestionnaireGroupsList.css"); ?>">
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
  <?php
    /*
        For each Questionnaire Group
    */

  ?>
  <div class="list-group col-xs-offset-0 col-xs-12">
    <a href="#" class="list-group-item col-md-offset-1 col-md-10">
      <div class="qgroup-name col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-3">
          <button class="btn" type="button">New Question</button>
        </div>
        <div class="col-xs-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-2" style="padding:0px">
          <button class="btn" type="button">Delete</button>
        </div>
        <div class="col-xs-offset-3 col-xs-3 ">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>

    <a href="#" class="list-group-item col-md-offset-1 col-md-10">
      <div class="qgroup-name col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-3">
          <button class="btn" type="button">New Question</button>
        </div>
        <div class="col-xs-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-2" style="padding:0px">
          <button class="btn" type="button">Delete</button>
        </div>
        <div class="col-xs-offset-3 col-xs-3 ">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>


    <a href="#" class="list-group-item col-md-offset-1 col-md-10">
      <div class="qgroup-name col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-3">
          <button class="btn" type="button">New Question</button>
        </div>
        <div class="col-xs-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-2" style="padding:0px">
          <button class="btn" type="button">Delete</button>
        </div>
        <div class="col-xs-offset-3 col-xs-3 ">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>
<?php endif; ?>
