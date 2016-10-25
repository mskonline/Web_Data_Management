/*
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
*/

var username = "saikumarm";
var request = new XMLHttpRequest();
var gmarker;

var map,
		geocoder,
		glocation,
		gAddress,
		infowindow,
		textArea,
		clearBtn;

window.onload = function(){
	textArea = document.getElementById('textArea');
	clearBtn = document.getElementById('clearBtn');

	textArea.append('\n');
	clearBtn.addEventListener('click',function(e){
		textArea.innerHTML = '';
	});
}

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

	//reversegeocode();

	//Initialize a mouse click event on map which then calls reversegeocode function
	google.maps.event.addListener(map, 'click', function(event) {
	   reversegeocode(event.latLng);
	});
}

// Reserse Geocoding
function reversegeocode(location) {
	// Removing old marker
	if(gmarker != undefined){
		gmarker.setMap(null);
		gmarker = null;
	}

	// Adding new marker at the mouse click location
	gmarker = new google.maps.Marker({
			position: location,
			map: map
	});

	glocation = location;

  //get the latitude and longitude from the mouse click and get the address.
  //call geoname api asynchronously with latitude and longitude
	geocoder.geocode({'location': location}, function(results, status) {
    if (status === 'OK') {
      if (results[1]) {
				gAddress = results[1].formatted_address;

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
				try {
					var xml = request.responseXML.documentElement;
					var temperature = xml.getElementsByTagName("temperature");
					var windSpeed = xml.getElementsByTagName("windSpeed");
					var clouds = xml.getElementsByTagName("clouds");

					var t = temperature[0].innerHTML;
					var ws = windSpeed[0].innerHTML;
					var clds = clouds[0].innerHTML;
					var msg = 'Address: ' + gAddress + '<br>Temperature: '+ t + ' C' + '<br>Windspeed: ' + ws + '<br>Clouds: ' + clds;

					infowindow.setContent(msg);
	        infowindow.open(map, gmarker);

					msg = 'Address: ' + gAddress + ' - \n\tTemperature: '+ t + ' C' + ' Windspeed: ' + ws + ' Clouds: ' + clds;
					textArea.append(msg + '\n');
				} catch (e) {
					console.log(e);
					alert('Something went wrong. Please try again');
				}
    }
}

function sendRequest (location) {
		var lat = location.lat(), lng = location.lng();
    request.onreadystatechange = displayResult;
    request.open("GET"," http://api.geonames.org/findNearByWeatherXML?lat="+lat+"&lng="+lng+"&username="+username,true);
    //request.withCredentials = "true";
    request.send(null);
}
