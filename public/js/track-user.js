$(document).ready(function() {
	setValue();
    setInterval("setValue()",5000);
});

function setValue() {
	$.getJSON( "/api/trackuser", function( data ) {
		clearLocations();
		$.each( data, function( key, val ) {
			var latlng = new google.maps.LatLng(val.latitude,val.longitude);
			addMarker(latlng, val.track_id, val.status);
			//console.log(latlng);
			console.log( val.latitude, val.longitude, val.track_id);
		});
		map.fitBounds(bounds);
	});
}	

/*
  Adds a marker to the map
  @param latlng, name, status
    latlng The location that is to be added to map
    name For generating content of popup on clicking marker
    status Status of the user either 1(normal tracking) or 2(panic tracking)
*/
function addMarker(latLng, name, status) 
{	
	if( status == 2 )
	{
		var marker = new google.maps.Marker({
        	position: latLng,
        	map: map, 
        	animation: google.maps.Animation.BOUNCE,
        	icon: 'images/panic.png'
    	});
	}
	else
	{	var marker = new google.maps.Marker({
        	position: latLng,
        	map: map,
        	icon: 'images/track.png'
    	});
	}
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