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
var map=new google.maps.Map(document.getElementById("mapcanvas"),mapProp);
}

google.maps.event.addDomListener(window, 'load', initialize);