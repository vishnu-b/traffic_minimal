var map;
var markers = [];
var bounds;

/*
This function initializes the google map canvas with all the properties
and assign it to 'mapcanvas' div
*/
function initialize()
{
  var mapProp = {
    center:new google.maps.LatLng(17,78),
    zoom:8,
    panControlOptions: {
      position: google.maps.ControlPosition.RIGHT_BOTTOM
    },
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL,
      position: google.maps.ControlPosition.RIGHT_BOTTOM
    },
    mapTypeId:google.maps.MapTypeId.ROADMAP
    };
  bounds = new google.maps.LatLngBounds();  
  map = new google.maps.Map(document.getElementById("mapcanvas"),mapProp);
}

google.maps.event.addDomListener(window, 'load', initialize);

/*
  Adds a marker to the map
  @param latlng, name, status
    latlng The location that is to be added to map
    name For generating content of popup on clicking marker
    status Status of the user either 1(normal tracking) or 2(panic tracking)
*/
function addMarker(latLng, name, status) 
{
    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });
    var html = "</b>" + name + "</b>";

    var infoWindow = new google.maps.InfoWindow({
      content: html
    });
    
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.open(map, marker);
    });

    bounds.extend(latLng);
    markers.push(marker);
}
/*
  Clearing the map 
*/
function clearLocations()
{
  //infoWindow.close();

  for (var i = 0; i < markers.length; i++)
  {
    //console.log(i);
    markers[i].setMap(null);
  }
  markers.length = 0;
  bounds = new google.maps.LatLngBounds();
}