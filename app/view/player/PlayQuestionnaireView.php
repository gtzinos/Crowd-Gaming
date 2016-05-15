<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/library/jQuery-countdown/dist/jquery.countdown.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/jquery-clock.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/player/PlayQuestionnaire.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
    $questionnaire = get("questionnaire")["questionnaire"];

    $minutes_left = intval(get("questionnaire")["time-left"]);
    if($minutes_left > 0)
    {
      /*
        1 hour => 60 minutes
        1 day = 1440 minutes
      */
      $days_left = 0;
      if($minutes_left >= 1440)
      {
        $days_left = intval($minutes_left / 1440); //days left
        $minutes_left -= intval($days_left * 1440);
      }

      $hours_left = 0;
      if($minutes_left >= 60)
      {
        $hours_left = intval($minutes_left / 60); //days left
        $minutes_left -= intval($hours_left * 60);
      }
    }
    echo "<script>
            var questionnaire_id = " . $questionnaire->getId() . ";
            var time_left = " . get("questionnaire")["time-left"] . ";
          </script>";
          //days_left = " . $days_left . ",
          //hours_left = " . $hours_left . ",
          //minutes_left = " . $minutes_left . ";
  ?>
  <div id="count-down"> </div>
  <legend class="text-center header"><?php echo $questionnaire->getName() ?></legend>
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


<?php endif; ?>
