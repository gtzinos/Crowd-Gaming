<?php if($section == "CSS") : ?>
<?php elseif($section == "JAVASCRIPT") : ?>
<script src="http://maps.googleapis.com/maps/api/js"> </script>

<script>
    var myCenter=new google.maps.LatLng(51.508742,-0.120850);
    function initialize()
    {
      var mapProp = {
        center:myCenter,
        zoom:5,
        mapTypeId:google.maps.MapTypeId.HYBRID
      };
      var map=new google.maps.Map(
        document.getElementById("googleMap"),
        mapProp
      );
      var marker=new google.maps.Marker({
         position:myCenter
       });
      marker.setMap(map);
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
<div class="container-fluid">
  <!-- Title -->
  <legend class="text-center header">Create Questionnaire Group</legend>

  <form>
    <!-- Question Group Name Label -->
    <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" >
        <label>Name</label>
    </div>
    <!-- Question Group Name -->
    <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" >
        <input class="form-control" id="name" type="text" style="text-align:center" placeholder="Group Name"/>
    </div>
    <!-- Question Group Description Label -->
    <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" >
        <label>Description</label>
    </div>
    <!-- Question Group Description -->
    <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" >
        <textarea id="description" style="text-align:center;height:170px" placeholder="Group Description"></textarea>
    </div>

      <!-- Google Map -->
      <div class="form-control col-xs-offset-0 col-xs-12 col-md-offset-1 col-sm-10" id="googleMap" style="height:170px"></div>
      <!-- Longitude - Latitude -->
      <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" style="margin-top:3%" >
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <input class="form-control" id="latitude" type="text" style="text-align:center" placeholder="Latitude"/>
        </div>
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <input class="form-control" id="longitude" type="text" style="text-align:center" placeholder="Longitude"/>
        </div>
      </div>
      <!-- Google maps buttons -->
      <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" >
        <!-- Find Current Location -->
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <button class="form-control btn btn-info">Current Location</button>
        </div>
        <!-- Find Location on Map -->
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <button class="form-control btn btn-primary">Search Now</button>
        </div>
      </div>

      <!-- DeviationLongitude - DeviationLatitude -->
      <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" style="margin-top:3%" >
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <input class="form-control" id="dlatitude" type="text" style="text-align:center" placeholder="Deviation Latitude"/>
        </div>
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-5">
          <input class="form-control" id="dlongitude" type="text" style="text-align:center" placeholder="Deviation Longitude"/>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group has-feedback col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10" style="margin-top:3%">
        <div class="gt-input-group col-xs-offset-0 col-xs-12 col-sm-3">
          <input type="button" class="form-control btn btn-primary gt-submit" value="Create Group"/>
        </div>

      </div>
  </form>
<?php endif; ?>
