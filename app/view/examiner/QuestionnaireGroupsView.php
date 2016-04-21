<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/examiner/QuestionnaireGroupsList.css"); ?>">
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/craftpip-jquery-confirm/dist/jquery-confirm.min.css"); ?>">

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


  <div class="list-group" id="question-group-list">

  </div>

    <?php
        load("CREATE_QUESTION");
        load("QUESTION_LIST");
        load("EDIT_QUESTION");
     ?>

<?php elseif($section == "QUESTION_GROUP_LIST" ) : ?>

  <?php

        $questionGroups = get("groups");
        $counter = 0;
        foreach ($questionGroups as $questionGroup) {
            $counter +=1;
            print   "<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='qgitem" . $questionGroup->getId() . "'>
                        <div class='col-xs-12'>
                            <h4 class='list-group-item-heading'>" . $questionGroup->getName() . "</h4>
                        </div>
                        <div class='col-xs-12' style='margin-top:3%;padding:0px'>
                            <div class='col-xs-12 col-sm-4 col-md-3' style='padding:0px'>
                                <button class='btn' type='button' onclick='openQuestionDialog(" . $questionGroup->getId() . ")'>New Question</button>
                            </div>
                            <div class='col-xs-12 col-sm-2 col-md-1' style='padding:0px'>
                                <button class='btn' type='button'>Edit</button>
                            </div>
                            <div class='col-xs-12 col-sm-2 col-md-2' style='padding:0px'>
                                <button class='btn' type='button' onclick=\"delete_question_group(" . $questionGroup->getId() . ",false)\">Delete</button>
                            </div>
                            <div class='col-xs-12 col-sm-offset-1 col-sm-3 col-md-offset-3 col-md-3'>
                                <button class='btn btn-link' type='button' onclick=\"showModal('question-list'); show_questions(" . $questionGroup->getId() . ");\" >Questions <span class='badge' id='qcounter" . $questionGroup->getId() . "'>" . $questionGroup->getQuestionCount() . "</span></button>
                            </div>
                        </div>
                    </a>";
        }
        if($counter == 0)
        {
          print "<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>
                      <div class='col-xs-12'>
                          <div class='alert alert-danger'>We don't have any question group in our database. </div>
                      </div>
                  </a>";
        }
?><?php endif; ?>
