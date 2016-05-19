<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/player/MyQuestionnaires.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/daterangepicker/moment.min.js"); ?>"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/library/jQuery-countdown/dist/jquery.countdown.min.js"); ?>"> </script>
<script src="<?php print LinkUtils::generatePublicLink("js/common/jquery-clock.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">My Questionnaires</legend>
  <?php
      echo "  <script>
                var questionnaire_page = '" . LinkUtils::generatePageLink('play-questionnaire') . "';
                var play_questionnaire_page = '" . LinkUtils::generatePageLink('play-questionnaire') . "';
              </script>";
  ?>
  <div class="container-fluid">
    <div class="list-group" id="my-questionnaires-list">

    </div>
  </div>


<?php endif; ?>
