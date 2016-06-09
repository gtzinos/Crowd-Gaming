<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/ExaminerApplications.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <?php
      echo "  <script>
                var user_page = '" . LinkUtils::generatePageLink('user') . "';
              </script>";
  ?>
  <legend class="text-center header">Examiner applications</legend>

  <div class="container-fluid">
    <div class="list-group" id="examiner-applications-list">

    </div>
  </div>

<?php endif; ?>
