<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/examiner/QuestionnaireGroupsList.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/css/bootstrap-select.min.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
  <script type="text/javascript">
  /*
    Initialize javascript variables
  */
    var questionnaire_id = '<?php print get("questionnaire")->getId(); ?>'
  </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroups.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/confirm-dialog.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-select-list/dist/js/bootstrap-select.min.js"); ?>"></script>
  <script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroupMembers.js"); ?>"></script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
<div class="container-fluid">
  <!-- ShortCut Buttons -->
  <div class="form-group has-feedback row">
    <div class="col-xs-1">
      <a class="gt-submit fa fa-hand-o-left" style="font-size:24px" title="Go Back" href="<?php echo LinkUtils::generatePageLink('questionnaire') . "/" . get("questionnaire")->getId(); ?>"></a>
    </div>
  </div>
  <!-- Title -->
  <legend class="text-center header">Question Groups</legend>
  <!-- ShortCut Buttons -->
  <div class="form-group has-feedback row">
    <div class="col-xs-4 col-sm-1">
      <a class="btn btn-primary gt-submit" href="<?php echo LinkUtils::generatePageLink('create-question-group') . "/" . get("questionnaire")->getId(); ?>">Add</a>
    </div>
    <div class="visible-xs col-xs-12">
    </br>
    </div>
    <div class="col-xs-4 col-sm-1">
      <button class="btn" onclick="$('#question-group-users').modal('show')"><i class="fa fa-users bigicon"></i></buton>
    </div>
  </div>
  <?php
    /*
        For each Questionnaire Group
    */
  ?>
  <div class="list-group" id="question-group-list">

  </div>

    <?php
        load("CREATE_QUESTION");
        load("QUESTION_LIST");
        load("EDIT_QUESTION");
        load("QUESTION_GROUP_USERS");
     ?>

<?php elseif($section == "QUESTION_GROUP_LIST" ) : ?>
  <?php
        $questionGroups = get("groups");
        $counter = 0;
        foreach ($questionGroups as $questionGroup) {
            $counter +=1;
            print   "<div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='qgitem" . $questionGroup->getId() . "'>
                        <div class='col-xs-12'>
                            <h4 class='list-group-item-heading'>" . $questionGroup->getName() . "</h4>
                        </div>
                        <div class='col-xs-12' style='margin-top:3%;padding:0px'>
                            <div class='col-xs-12 col-sm-4 col-md-3' style='padding:0px'>
                                <button class='btn btn-info' type='button' onclick='openQuestionDialog(" . $questionGroup->getId() . ")'>New Question</button>
                            </div>
                            <div class='visible-xs col-xs-12'>
                              <br>
                            </div>
                            <div class='col-xs-12 col-sm-2 col-md-1' style='padding:0px'>
                                <a class='btn btn-default' href='" . LinkUtils::generatePageLink('edit-question-group') . "/" . $questionGroup->getId() . "'>Edit</a>
                            </div>
                            <div class='visible-xs col-xs-12'>
                              <br>
                            </div>
                            <div class='col-xs-12 col-sm-2 col-md-2' style='padding:0px'>
                                <button class='btn btn-danger' type='button' onclick=\"delete_question_group(" . $questionGroup->getId() . ",false)\">Delete</button>
                            </div>
                            <div class='col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3'>
                                <button class='btn btn-link' type='button' onclick=\"showModal('question-list'); show_questions(" . $questionGroup->getId() . ");\" >Questions <span class='badge' id='qcounter" . $questionGroup->getId() . "'>" . $questionGroup->getQuestionCount() . "</span></button>
                            </div>
                        </div>
                    </div>";
        }
        if($counter == 0)
        {
          if(get("offset") == 0) {
            print "<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>
                        <div class='col-xs-12'>
                            <div class='alert alert-danger'>We don't have any question group in our database. </div>
                        </div>
                    </a>";
          }
          //else dont print something (no more question groups)
        }
?><?php endif; ?>
