var map;
var markers = [];
var infoWindow = new google.maps.InfoWindow();
var locationSelect;
google.maps.visualRefresh = true;

function initialize() {
	var myOptions = {
        center: new google.maps.LatLng(17.5, 78.5),
        zoom:8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById("mapcanvas"),
    myOptions);
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
        document.getElementById("lat").value = event.latLng.lat();
        document.getElementById("lng").value = event.latLng.lng();
    });
    searchLocationsNear();
}
var marker;
function placeMarker(location) {
    if(marker){ //on vérifie si le marqueur existe
        marker.setPosition(location); //on change sa position
    }else{
        marker = new google.maps.Marker({ //on créé le marqueur
            position: location, 
            map: map, 
            icon: 'images/current.png'
            
        });
    }
   
   getAddress(location, function(address){
        document.getElementById("location").value = address;
    });
} 
function searchLocationsNear() {
    //downloadUrl('deletemarkers.jsp',function(data){ console.log("hello");});
    var searchUrl = 'api/report';
    downloadUrl(searchUrl, function(data) {
        var json = JSON.parse(data);
        var report = json.report;
        console.log(report)
        //console.log(locations);
        var bounds = new google.maps.LatLngBounds();
        for (var i = report.length-1; i>=0 ; i--) {
            var user = report[i].user;
            var date = report[i].date;
            var time = report[i].time;
            var type = report[i].type;
            var title = report[i].title;
            var desc = report[i].description;
            var image = report[i].image_url;
            var latlng = new google.maps.LatLng(
                parseFloat(report[i].latitude),
                parseFloat(report[i].longitude)
            );
            console.log(latlng);
            createMarker(user, date, time, type, title, desc, image, latlng);
            bounds.extend(latlng);
        }
    });

 

}

function createMarker(user, date, time, type, title, desc, image, latlng) {
    var html = "<div id= 'info-window'><b>" + title + '</b><br>' + time + ', ' +  date + '<br>' + desc + '<br>' + "<a href=" + image + "><img width='150' src=" + image + "></a></div>";
    if(type == 'Accident')
    {
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            icon: 'images/accident.png'
        });
    }
    else
    {
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            icon: 'images/jam.png'
        });
    }
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    });
    markers.push(marker);
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
        }
    };
        request.open('GET', url, true);
        request.setRequestHeader("Accept", "application/json; charset=utf-8");
        request.send(null);
}

function parseXml(str) {
    if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
    } 
    else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
    }
}

function doNothing() {

}

function getAddress(latLng, fn) {
    var address = null;
    geocoder.geocode( {'latLng': latLng},
    function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            fn(results[0].formatted_address);
        }
        else {
            //returnAddress(status);
        }
    });
}



   
google.maps.event.addDomListener(window, 'load', initialize); 