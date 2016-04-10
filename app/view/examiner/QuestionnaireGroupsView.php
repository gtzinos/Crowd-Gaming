<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
  <!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1P_ouQbGN0ehtuSm58zqrYxS-YPk4XwM" type="text/javascript"></script>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionGroupsUsingGoogleMap.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
<div class="container-fluid">
  <!-- Title -->
  <legend class="text-center header">Create Questionnaire Group</legend>

  <form class="form-horizontal">
    <!-- Question Group Name -->
    <div class="form-group has-feedback">
      <!-- Question Group Name Label -->
      <div class="col-xs-offset-0 col-xs-12 col-sm-8 col-sm-offset-2">
          <label>Name</label>
      </div>
      <div class="col-xs-offset-0 col-xs-12 col-sm-8 col-sm-offset-2 gt-input-group" data-validate="length" data-length="10">
        <input class="form-control" id="name" type="text" placeholder="Group Name" data-toggle="tooltip" gt-error-message="Not a valid question group name" maxlength="50" required>
        <span class="gt-icon"></span>
      </div>
    </div>

    <!-- Question Group Description -->
    <div class="form-group has-feedback" style="margin-top:3%">
        <!-- Question Group Description Label -->
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
            <label>Description</label>
        </div>
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 gt-input-group" data-validate="length" data-length="5">
          <textarea class="form-control" id="description" style="height:170px" placeholder="Group Description" data-toggle="tooltip" gt-error-message="Not a valid question group description" maxlength="255" required></textarea>
          <span class="gt-icon"></span>
        </div>
    </div>

      <!-- Google Map -->
      <div class="form-group has-feedback" >
        <div  class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
          <div id="googleMap" style="height:300px"></div>
        </div>
      </div>
      <!-- Longitude - Latitude -->
      <div class="form-group has-feedback" >
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-4 gt-input-group" data-validate="length" data-length="1">
          <input class="form-control" id="longitude" type="text" style="text-align:center" placeholder="Longitude" data-toggle="tooltip" gt-error-message="Not a valid question group description" maxlength="20" required/>
          <span class="gt-icon"></span>
        </div>
        <div class="col-xs-offset-0 col-xs-12 col-sm-4 gt-input-group" data-validate="length" data-length="1">
          <input class="form-control" id="latitude" type="text" style="text-align:center" placeholder="Latitude" data-toggle="tooltip" gt-error-message="Not a valid question group description" maxlength="20" required/>
          <span class="gt-icon"></span>
        </div>
        <!-- Radius -->
        <div style="margin-top:1%" class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-4 gt-input-group" data-validate="number">
          <input class="form-control" id="radius" type="text" style="text-align:center" maxlength="10" placeholder="Radius"/>
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
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-3">
          <input type="submit" class="form-control btn btn-primary gt-submit round" style="text-align:center" value="Create Group" disabled/>

        </div>
      </div>
  </form>

</div>
<?php endif; ?>
