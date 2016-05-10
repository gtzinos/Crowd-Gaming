<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/player/MyQuestionnaires.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">My Questionnaires</legend>
  <?php
      echo "  <script>
                var questionnaire_page = '" . LinkUtils::generatePageLink('questionnaire') . "';
              </script>";
  ?>
  <div class="container-fluid">
    <div class="list-group" id="my-questionnaires-list">

    </div>
  </div>


<?php endif; ?>
