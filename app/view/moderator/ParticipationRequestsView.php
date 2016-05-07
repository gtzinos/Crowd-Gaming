<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/ParticipationRequests.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">Participation Requests</legend>

  <div class="container-fluid">
    <div class="list-group" id="participation-requests-list">

    </div>
  </div>

<?php endif; ?>
