<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/HomePage.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1P_ouQbGN0ehtuSm58zqrYxS-YPk4XwM" type="text/javascript"></script>
	<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
  <script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

  <div class="container-fluid">
		<!-- ShortCut Buttons -->
		<div class="form-group has-feedback row">
			<div class="col-xs-1">
				<a class="gt-submit fa fa-hand-o-left" style="font-size:24px" title="Go Back" href="<?php echo LinkUtils::generatePageLink('questionnaire-groups') . "/" . get("question-group")->getQuestionnaireId(); ?>"></a>
      </div>
		</div>
    <!-- Title -->
    <legend class="text-center header">Edit Questionnaire Group</legend>
    <form method="POST" onsubmit="return checkOptionals();" class="form-horizontal">
      <!-- Question Group Name -->
      <div class="form-group has-feedback">
        <!-- Question Group Name Label -->
        <div class="col-xs-offset-0 col-xs-12 col-sm-8 col-sm-offset-2">
            <label>Name</label>
        </div>
        <div class="col-xs-offset-0 col-xs-12 col-sm-8 col-sm-offset-2 gt-input-group" data-validate="length" data-length="10">
          <?php
						$value = "";
						if(exists("response-code") && get("response-code") != 0)
						{
							$value .= $_POST["name"];
						}
						else if(get("question-group")->getName() != "") {
							$value .= get("question-group")->getName();
						}
						echo "<input class='form-control' value='" . $value . "' id='name' name='name' type='text' placeholder='Group Name' data-toggle='tooltip' gt-error-message='Not a valid question group name' maxlength='50' required>";
					 ?>
					<span class="gt-icon"></span>
        </div>
      </div>
        <!-- Google Map -->
        <div class="form-group has-feedback" >
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
            <div id="googleMap" style="height:300px"></div>
          </div>
        </div>
        <!-- Longitude - Latitude -->
        <div class="form-group has-feedback" >
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-4 gt-input-group" data-validate="length" data-length="1">
						<?php
								$value = "";
								if(exists("response-code") && get("response-code") != 0)
								{
									$value .= $_POST["longitude"];
								}
								else if(get("question-group")->getLongitude() != "") {
									$value .= get("question-group")->getLongitude();
								}
								echo "<input class='form-control' value='" . $value . "' id='longitude' name='longitude' type='text' style='text-align:center' placeholder='Longitude' data-toggle='tooltip' gt-error-message='Not a valid question group description' maxlength='20'/>";
						?>
						<span class="gt-icon"></span>
          </div>
          <div class="col-xs-offset-0 col-xs-12 col-sm-4 gt-input-group" data-validate="length" data-length="1">
							<?php
									$value = "";
									if(exists("response-code") && get("response-code") != 0)
									{
										$value .= $_POST["latitude"];
									}
									else if(get("question-group")->getLatitude() != "") {
										$value .= get("question-group")->getLatitude();
									}
									echo "<input class='form-control' value='" . $value . "' id='latitude' name='latitude' type='text' style='text-align:center' placeholder='Latitude' data-toggle='tooltip' gt-error-message='Not a valid question group description' maxlength='20'/>";
							?>
						<span class="gt-icon"></span>
          </div>

          <!-- Radius -->
          <div style="margin-top:1%" class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-4 gt-input-group" data-validate="number">
						<?php
								$value = "";
								if(exists("response-code") && get("response-code") != 0)
								{
									$value .= $_POST["radius"];
								}
								else if(get("question-group")->getRadius() != "") {
									$value .= get("question-group")->getRadius();
								}
								echo "<input class='form-control' value='" . $value . "' id='radius' name='radius' type='text' style='text-align:center' maxlength='10' placeholder='Radius' value='0'/>";
						?>
						<span class="gt-icon"> </span>
          </div>
          <!-- Search button -->
          <div style="margin-top:1%;" class="col-xs-offset-0 col-xs-3 col-sm-1 gt-input-group">
            <input type="button" class="btn btn-primary" value="Find" onclick="searchPosition()"/>
          </div>
          <!-- Find Current Location -->
          <div style="margin-top:1%;" class="col-xs-offset-0 col-xs-9 col-sm-3 gt-input-group">
            <input type="button" class="form-control btn btn-info" value="Current Location" onclick="findCurrentLocation()"/>
          </div>
        </div>
        <!-- Submit Button -->
        <div class="form-group has-feedback" style="margin-top:3%">
          <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-2">
            <input type="submit" class="form-control btn btn-primary gt-submit " style="text-align:center" value="Update Group" disabled/>

          </div>
        </div>
        <!-- Create question group response label -->
        <div class="form-group">
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-7">

            <label>

              <?php
								/*
									0 All ok
									1 Group name already exists
									2 Group name validation error
									3 latitude validation error
									4 longitude validation error
									5 radius validation error
									6 Database error
								*/
                if(exists("response-code"))
                {
                  /*
                    If response-code == 0
                    then All ok
                  */
                  if(get("response-code") == 0)
                  {
                    echo "<div class='alert alert-success'>Question group updated successfully.</div>";
                  }
                  /*
                    Else If response-code == 1
                    then Group name already exists
                  */
                  else if(get("response-code") == 1)
                  {
                    echo "<div class='alert alert-danger'>Group name already exists.</div>";
                  }
                  /*
                    Else If response-code == 1
                    then Group name validation error
                  */
                  else if(get("response-code") == 2)
                  {
                    echo "<div class='alert alert-danger'>Not a valid question group name.</div>";
                  }
                  /*
                    Else If response-code == 3
                    then latitude validation error
                  */
                  else if(get("response-code") == 3)
                  {
                    echo "<div class='alert alert-danger'>Not a valid latitude.</div>";
                  }
                  /*
                    Else If response-code == 4
                    then longitude validation error
                  */
                  else if(get("response-code") == 4)
                  {
                    echo "<div class='alert alert-danger'>Not a valid longitude.</div>";
                  }
                  /*
                    Else If response-code == 5
                    then  radius validation error
                  */
                  else if(get("response-code") == 5)
                  {
                    echo "<div class='alert alert-danger'>Not a valid radius.</div>";
                  }
                  /*
                    Else If response-code == 6
                    then  Database error
                  */
                  else if(get("response-code") == 6)
                  {
                    echo "<div class='alert alert-danger'>General database error.</div>";
                  }
                  /*
                    Else a new error returned
                  */
                  else
                  {
                    echo "<div class='alert alert-danger'>Unknown error. Please contact with one administrator!</div>";
                  }
                }
              ?>
            </label>
          </div>
        </div>
    </form>
  </div>
	<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroupsUsingGoogleMap.js"); ?>"> </script>
<?php endif; ?>
