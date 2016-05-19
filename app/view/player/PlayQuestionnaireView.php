<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/library/moment-develop/min/moment.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/jQuery-countdown/dist/jquery.countdown.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/jquery-clock.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/player/PlayQuestionnaire.js"); ?>"> </script>

<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
    $questionnaire = get("questionnaire")["questionnaire"];
    echo "<script>
            var questionnaire_id = " . $questionnaire->getId() . ";
            var time_left = " . intval(get("questionnaire")["time-left"]) . ";
          </script>";
  ?>
  <div id="count-down" style="color:red;display:none" class="col-xs-offset-7 col-sm-offset-10"> </div>
  <div id="auto-refresh" style="color:red;font-size:30px;display:none" class="col-xs-offset-8 col-sm-offset-10"><span title="Auto refresh" class="fa fa-refresh" onclick="changeAutoRefreshStatus()"> </span></div>
  <legend class="text-center header" id="questionnaire-name" style="display:none"><?php echo $questionnaire->getName() ?></legend>
  <div class="container-fluid col-xs-12 col-sm-offset-2 col-sm-8">

      <div class="panel-group" id="accordion">

      </div>
        <form role="form">
      <div class="radio" style="border-color:lightblue">
        <label><input type="radio" name="optradio">Option 1</label>
      </div>
      <div class="radio">
        <label><input type="radio" name="optradio">Option 2</label>
      </div>
      <div class="radio disabled">
        <label><input type="radio" name="optradio" disabled>Option 3</label>
      </div>
    </form>
  </div>
  <?php
    load("PLAY_GAME");
  ?>

<?php endif; ?>
