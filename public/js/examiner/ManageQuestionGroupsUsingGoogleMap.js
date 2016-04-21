/*
  Initialize variables
*/

var my_position=new google.maps.LatLng(51.508742,-0.120850); //starting position
var map; // map variable
var marker; // marker variable
var zoom = 5; // zoom counter
var circle; // circle variable
var radius = 0; // circle radius
/*
  Initialize function.
  We call initialize() on load
*/
function initialize()
{
  /*
    Map properties
  */
  var mapProp = {
    center:my_position, //initialize position
    zoom:zoom, //zoom
    zoomControl:true,
    mapTypeControl:true,
    mapTypeId:google.maps.MapTypeId.HYBRID // map type
  };
  /*
    Create a map variable
  */

  map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

  /*
    Place a marker on current position (After the window loading)
  */
  //findCurrentLocation();

  /*
    On click event
    we call placeMarker(location)
  */
  google.maps.event.addListener(map, 'click', function(event) {
      /*
        Place the marker
      */
      placeMarker(event.latLng);
  });
  /*
    If Latitude && longitude didnt empty
  */
  if($("#latitude").val() != "" && $("#longitude").val() != "")
  {
    searchPosition();
  }
}
/*
  On map load call initialize()
*/
google.maps.event.addDomListener(window, 'load', initialize);
/*
  Place a marker on the map
*/
function placeMarker(location) {
   /*
      Override old marker
   */
   if(marker != null) marker.setMap(null);
   marker = new google.maps.Marker({position: location,map: map});
   /*
     Override new position
   */
   my_position = new google.maps.LatLng(marker.getPosition().lat(),marker.getPosition().lng());
   /*
      Set Zoom
   */
   if(map.getZoom() < 8)
      map.setZoom(8);
   /*
      Change camera
   */
   map.setCenter(marker.getPosition());
   /*
      Set values on form
   */
   $("#longitude").val(marker.getPosition().lng());
   $("#latitude").val(marker.getPosition().lat());

   /*
      If new radius is number
   */
   if($.isNumeric($("#radius").val()))
   {
     radius = $("#radius").val();
     if(circle != null)
     {
       circle.setMap(null);
     }
   }
   /*
      Set radius if radius > 0
   */
   if(radius > 0)
   {
     circle = new google.maps.Circle({
       center:my_position,
       radius:parseInt(radius,10), //parse to integer
       strokeColor:"#0000FF",
       strokeOpacity:0.8,
       strokeWeight:2,
       fillColor:"#0000FF",
       fillOpacity:0.4
      });

     circle.setMap(map);
   }
   /*
      On click event listener for marker
   */
   google.maps.event.addListener(marker, 'click', function(event) {
     /*
       Set new zoom
     */
     if(map.getZoom() < 10)
        map.setZoom(10);
     /*
        Change camera
     */
     map.setCenter(marker.getPosition());
   });
}
/*
  Find current location
*/
function findCurrentLocation()
{
  /*
    Find current location
    #1 Done = call setPosition(position)
    #2 Fail = call showError(error)
  */
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setPosition,showError);
  }
  /*
    Error : Geolocation is not supported
  */
  else {
    alert("Geolocation is not supported by this browser.");
  }
}
/*
    Set marker on a new position
*/
function setPosition(location)
{
  /*
      Create a new position
  */
  my_position=new google.maps.LatLng(location.coords.latitude,location.coords.longitude);
  /*
    Place the marker
  */
  placeMarker(my_position);
}
/*
  Show error code message
*/
function showError(error) {
    /*
      For each error code
    */
    switch(error.code) {
        /*
          PERMISSION_DENIED
        */
        case error.PERMISSION_DENIED:
            alert("Please enable your locator.");
            break;
        /*
          POSITION_UNAVAILABLE
        */
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        /*
          TIMEOUT
        */
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        /*
          UNKNOWN_ERROR
        */
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
/*
  Search for a custom position
*/
function searchPosition()
{
  /*
    If Latitude && longitude didnt empty
  */
  if($("#latitude").val() != "" && $("#longitude").val() != "")
  {
      /*
        Create a new position
      */
      my_position = new google.maps.LatLng($("#latitude").val(),$("#longitude").val());

      /*
        Place the marker
      */
      placeMarker(my_position);
  }
  /*
    Else something going wrong with required fields
  */
  else {
      /*
        Longitude was empty
      */
      if($("#longitude").val() == "")
      {
        alert("Longitude field is empty.");
      }
      /*
        Latitude was empty
      */
      else if($("#latitude").val() == "" )
      {
        alert("Latitude field it empty.");
      }
  }
}
