<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("js/library/hold-on/src/css/HoldOn.min.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/daterangepicker/moment.min.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/jQuery-countdown/dist/jquery.countdown.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/jquery-clock.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/player/PlayQuestionnaire.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/hold-on/src/js/HoldOn.min.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
    $questionnaire = get("questionnaire")["questionnaire"];
    echo "<script>
            var questionnaire_id = " . $questionnaire->getId() . ";
            var time_left = " . intval(get("questionnaire")["time-left-to-end"]) . ";
            var my_questionnaires_page = '" . LinkUtils::generatePageLink("my-questionnaires") . "';
          </script>";
  ?>
  <div id="count-down" style="color:red;display:none" class="col-xs-offset-7 col-sm-offset-10"> </div>
  <div id="auto-refresh" style="color:red;font-size:30px;display:none" class="col-xs-offset-8 col-sm-offset-10"><span title="Auto refresh" class="fa fa-refresh" onclick="changeAutoRefreshStatus()"> </span></div>
  <legend class="text-center header" id="questionnaire-name" style="display:none"><?php echo $questionnaire->getName() ?></legend>
  <div class="container-fluid col-xs-12 col-sm-offset-2 col-sm-8">

      <div class="panel-group" id="accordion">

      </div>

  </div>
  <?php
    load("PLAY_GAME");
  ?>
<?php endif; ?>
