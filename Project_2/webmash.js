/*
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
*/

var username = "saikumarm";
var request = new XMLHttpRequest();
var gmarker;

var map;
var geocoder;
var glocation;
var infowindow;

//initMap() which initiates map to a location
function initMap() {

	var initCords = {lat: 32.75, lng: -97.13};
	geocoder = new google.maps.Geocoder;
	infowindow = new google.maps.InfoWindow;

	//initialize map
	map = new google.maps.Map(document.getElementById('map'), {
		center: initCords,
		zoom: 17
	});

	placeMarker(initCords);

	//Initialize a mouse click event on map which then calls reversegeocode function
	google.maps.event.addListener(map, 'click', function(event) {
	   placeMarker(event.latLng);
	});
}

function placeMarker(location) {
		if(gmarker != undefined){
			gmarker.setMap(null);
			gmarker = null;
		}

    gmarker = new google.maps.Marker({
        position: location,
        map: map
    });

		glocation = location;
		reversegeocode(location);
}


// Reserse Geocoding
function reversegeocode(location) {

  //get the latitude and longitude from the mouse click and get the address.
  //call geoname api asynchronously with latitude and longitude
	geocoder.geocode({'location': location}, function(results, status) {
    if (status === 'OK') {
      if (results[1]) {
        infowindow.setContent(results[1].formatted_address);
        infowindow.open(map, gmarker);

				sendRequest(glocation)
      } else {
        window.alert('No results found');
      }
    } else {
      window.alert('Geocoder failed due to: ' + status);
    }
  });
}// end of geocodeLatLng()

function displayResult () {
    if (request.readyState == 4) {
        var xml = request.responseXML.documentElement;
        var temperature = xml.getElementsByTagName("temperature");
				//document.getElementById("output").innerHTML = value;
				alert(value);
    }
}

function sendRequest (location) {
    request.onreadystatechange = displayResult;
    request.open("GET"," http://api.geonames.org/findNearByWeatherXML?lat="+location.lat+"&lng="+location.lng+"&username="+username,true);
    request.withCredentials = "true";
    request.send(null);
}
