		var imgSource = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/green-dot.png';
		var imgWay = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
		var rendererOptions = {
      		draggable: true,
      		suppressInfoWindows: true
    	};
	    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
	    var directionsService = new google.maps.DirectionsService();
	    var gmarkers = [];
	    var map = null;
	    var stepMarkers = [];
	    var startLocation = null;
	    var endLocation = null;
	    var directionsResponse = null;
	    var debug = false;
	    var polyline = new google.maps.Polyline({
	    	path: [],
	    	strokeColor: '#FF0000',
	    	strokeWeight: 3
	    });
	    var boston = new google.maps.LatLng(17,78);

	    // === create a polyline encoder Object ===
	    var polylineEncoder = new PolylineEncoder();

	    var icons = new Array();
		icons["red"] = new google.maps.MarkerImage("http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png");
		function getMarkerImage(iconColor) {
		   if ((typeof(iconColor)=="undefined") || (iconColor==null)) { 
		      iconColor = "red"; 
		   }
		   if (!icons[iconColor]) {
		      icons[iconColor] = new google.maps.MarkerImage("http://www.google.com/intl/en_us/mapfiles/ms/micons/"+ iconColor +"-dot.png");
		   } 
		   return icons[iconColor];

		}

		  // Marker sizes are expressed as a Size of X,Y
		  // where the origin of the image (0,0) is located
		  // in the top left of the image.
		 
		  // Origins, anchor positions and coordinates of the marker
		  // increase in the X direction to the right and in
		  // the Y direction down.

		  var iconImage = new google.maps.MarkerImage('http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png');
		 
		      // Shapes define the clickable region of the icon.
		      // The type defines an HTML &lt;area&gt; element 'poly' which
		      // traces out a polygon as a series of X,Y points. The final
		      // coordinate closes the poly by connecting to the first
		      // coordinate.
		 
		var infowindow = new google.maps.InfoWindow(
		  { 
		    size: new google.maps.Size(150,50)
		  });

	    function createMarker(latlng, label, html, color) {
// alert("createMarker("+latlng+","+label+","+html+","+color+")");
		    var contentString = '<b>'+label+'<\/b><br>'+html;
		    var marker = new google.maps.Marker({
		        position: latlng,
		        map: map,
		        icon: getMarkerImage(color),
		        title: label,
		        zIndex: Math.round(latlng.lat()*-100000)<<5
		        });
		        marker.myname = label;
		        gmarkers.push(marker);

		    google.maps.event.addListener(marker, 'click', function() {
		        infowindow.setContent(contentString); 
		        infowindow.open(map,marker);
		        });
						
		        return marker;
		}

		function addStepMarkers(result) {
		  polyline = new google.maps.Polyline({
		  	path: [],
		  	strokeColor: '#FF0000',
		  	strokeWeight: 3
		  });
		  infowindow.close();
		  for (var i=gmarkers.length-1;i>=0;i--) {
		    gmarkers[i].setMap(null);
		    gmarkers.pop();
		  }
		  if (startLocation && startLocation.marker) startLocation.marker.setMap(null);
		  if (endLocation && endLocation.marker) endLocation.marker.setMap(null);
		  var startLocation = new Object();
		  var endLocation = new Object();
		  var bounds = new google.maps.LatLngBounds();
		  for (var i=0;i<stepMarkers.length;i++) {
		    stepMarkers[i].setMap(null);
		  }
		  stepMarkers = [];
		  for (var h = 0; h < result.routes.length; h++) {
		    var route = result.routes[h];
		    // alert("processing "+route.legs.length+" legs");
		    // For each route, display summary information.
		    var legs = route.legs;
		         for (i=0;i<legs.length;i++) {
		           if (i == 0) { 
		             startLocation.latlng = legs[i].start_location;
		             startLocation.address = legs[i].start_address;
		             startLocation.marker = createMarker(legs[i].start_location,"start",legs[i].start_address,"green");
		           } else { 
		             waypts[i] = new Object();
		             waypts[i].latlng = legs[i].start_location;
		             waypts[i].address = legs[i].start_address;
		           	 waypts[i].marker = createMarker(legs[i].start_location,"waypoint"+i,legs[i].start_address,"blue");
		           }
		           endLocation.latlng = legs[i].end_location;
		           endLocation.address = legs[i].end_address;
		           var steps = legs[i].steps;
		           // alert("processing "+steps.length+" steps");
		           for (j=0;j<steps.length;j++) {
		             var nextSegment = steps[j].path;
		             var stepText = "";
		             if (j>0) stepText = "<a href='javascript:google.maps.event.trigger(stepMarkers["+(j-1)+"], \"click\")'>Prev<\/a>"
		             if (j<(steps.length-1)) {
		               if (stepText != "") { stepText += " - "; }
		               stepText += "<a href='javascript:google.maps.event.trigger(stepMarkers["+(j+1)+"], \"click\")'>Next<\/a>"
		             }
		             stepText = steps[j].instructions+"<br>"+stepText;
		             stepMarkers.push(createMarker(steps[j].start_location,"step",stepText,"blue"));
		             stepMarkers[stepMarkers.length-1].step_instructions = steps[j].instructions;
		             // alert("processing "+nextSegment.length+" points");
		             for (k=0;k<nextSegment.length;k++) {
		               polyline.getPath().push(nextSegment[k]);
		               bounds.extend(nextSegment[k]);
		             }
		           }
		     }
		   }
		   // alert("[1]polyline contains "+polyline.getPath().getLength()+" points");
		   return polyline;
		}

		function encodePolyline() {
		  directionsResponse = directionsDisplay.getDirections();
		  if (!directionsResponse) { alert("no route"); return; }

		  polyline = addStepMarkers(directionsResponse);
		 
		  // encoded polyline
		    var points = [];
		    for (var i=0; i< polyline.getPath().getLength(); i++) {
		      points[i] = polyline.getPath().getAt(i);
		    }
		    var encodedPoly = polylineEncoder.dpEncodeToJSON(points,"#FF0000",4,0.8);
		    console.log(encodedPoly.points);
		  //  document.getElementById('polyline').value += "<levels><![CDATA["+encodedPoly.levels+"]]><\/levels>\n";
		   // document.getElementById('polyline').value += "<\/encodedline>\n";
		 
		  document.getElementById("encoded_polyline").value = encodedPoly.points;                 
		} 

		 function initialize() {
		 	var southWest = new google.maps.LatLng( 18.4, 77 );
			var northEast = new google.maps.LatLng( 16.3, 80 );
 			var hyderabadBounds = new google.maps.LatLngBounds( southWest, northEast );
 			var options = {
			    bounds: hyderabadBounds,
			    componentRestrictions: { country: 'in' }
			};
		 	var autocompleteSource = new google.maps.places.Autocomplete(source, options);
		    var autocompleteDest = new google.maps.places.Autocomplete(dest, options);
		    var myOptions = {
		      zoom: 8,
		      mapTypeId: google.maps.MapTypeId.ROADMAP,
		      center: boston
		    };

		    map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
		    directionsDisplay.setMap(map);
		 	
		    google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
		      computeTotalDistance(directionsDisplay.directions);
		      addStepMarkers(directionsDisplay.directions);
		    });
		   // getParameters();
		    //calcRoute();
		  }
			function calcRoute() {
			    var start = document.getElementById("source").value;
			    var end =  document.getElementById("dest").value;
			    
			    var request = {
			      origin: start,
			      destination: end,
			      travelMode: google.maps.DirectionsTravelMode.DRIVING 
			    };
			    directionsService.route(request, function(response, status) {
			      if (status == google.maps.DirectionsStatus.OK) {
			        directionsResponse = response;
			        directionsDisplay.setDirections(response);
			        // alert("[2]polyline contains "+polyline.getPath().getLength()+" points");
			        polyline = addStepMarkers(response);
			        // alert("[3]polyline contains "+polyline.getPath().getLength()+" points");
			        encodePolyline();
			     }
			    });

			  }
 
			  function computeTotalDistance(result) {
			    var total = 0;
			    var myroute = result.routes[0];
			    for (i = 0; i < myroute.legs.length; i++) {
			      total += myroute.legs[i].distance.value;
			    }
			    total = total / 1000.
			   // document.getElementById("total").innerHTML = total + " km";
			  }
		

		google.maps.event.addDomListener(window, 'load', initialize);