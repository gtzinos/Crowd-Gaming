<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/PublicationRequests.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
      echo "  <script>
                var user_page = '" . LinkUtils::generatePageLink('user') . "';
                var questionnaire_page = '" . LinkUtils::generatePageLink('questionnaire') . "';
              </script>";
  ?>
  <legend class="text-center header">Publication Requests</legend>

  <div class="container-fluid">
    <div class="list-group" id="publication-requests-list">

    </div>
  </div>

<?php endif; ?>
