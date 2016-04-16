<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/examiner/QuestionnaireGroupsList.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">

<?php elseif($section == "JAVASCRIPT") : ?>
  <!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1P_ouQbGN0ehtuSm58zqrYxS-YPk4XwM" type="text/javascript"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroupsUsingGoogleMap.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroups.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
<div class="container-fluid">
  <!-- Title -->
  <legend class="text-center header">Questionnaire Groups</legend>
  <!-- ShortCut Buttons -->
  <div class="form-group has-feedback">
    <div class="col-xs-offset-0 col-xs-2">
      <a class="btn btn-primary gt-submit" href="<?php echo LinkUtils::generatePageLink('create-question-group') . "/1"; ?>">Add</a>
    </div>
  </div>
  <?php
    /*
        For each Questionnaire Group
    */

  ?>
  <script>
    function openQuestionDialog()
    {
      $("#create-question").modal("show");
    }

  </script>

  <!-- OTI EXEI EDW MPOREIS NA TO VGALEIS
  <div class="list-group">
    <a href="#" class="list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10">
      <div class="col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-12 col-sm-4 col-md-3" style="padding:0px">
          <button class="btn" type="button" onclick="openQuestionDialog()">New Question</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2" style="padding:0px">
          <button class="btn" type="button">Delete</button>
        </div>
        <div class="col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>

    <a href="#" class="list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10">
      <div class="col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-12 col-sm-4 col-md-3" style="padding:0px">
          <button class="btn" type="button" onclick="openQuestionDialog()">New Question</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2" style="padding:0px">
          <button class="btn gt-confirm-message" type="button">Delete</button>
        </div>
        <div class="col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>
    <a href="#" class="list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10">
      <div class="col-xs-12">
        <h4 class="list-group-item-heading">First List Group Item Heading</h4>
      </div>
      <div class="col-xs-12" style="margin-top:3%;padding:0px">
        <div class="col-xs-12 col-sm-4 col-md-3" style="padding:0px">
          <button class="btn" type="button" onclick="openQuestionDialog()">New Question</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-1" style="padding:0px">
          <button class="btn" type="button">Edit</button>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2" style="padding:0px">
          <button class="btn gt-confirm-message" type="button" >Delete</button>
        </div>
        <div class="col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3">
          <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
        </div>
      </div>
    </a>
    -->
  <script src="<?php print LinkUtils::generatePublicLink("js/common/confirm-dialog.js"); ?>"> </script>

    <?php
        load("CREATE_QUESTION");
     ?>
     
<?php elseif($section == "QUESTION_GROUP_LIST" ) : ?><?php

        $questionGroups = get("groups");

        foreach ($questionGroups as $questionGroup) {
            
            print   '<a href="#" class="list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10">
                        <div class="col-xs-12">
                            <h4 class="list-group-item-heading">First List Group Item Heading</h4>
                        </div>
                        <div class="col-xs-12" style="margin-top:3%;padding:0px">
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding:0px">
                                <button class="btn" type="button" onclick="openQuestionDialog()">New Question</button>
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-1" style="padding:0px">
                                <button class="btn" type="button">Edit</button>
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-2" style="padding:0px">
                                <button class="btn" type="button">Delete</button>
                            </div>
                            <div class="col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3">
                                <button class="btn btn-link" type="button">Questions <span class="badge">2</span></button>
                            </div>
                        </div>
                    </a>';
        }
?><?php endif; ?>
