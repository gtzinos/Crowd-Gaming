<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/ExaminerApplications.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">Examiner applications</legend>

  <div class="container-fluid">
    <div class="list-group" id="examiner-aplications-list">

    </div>
  </div>

<?php endif; ?>
