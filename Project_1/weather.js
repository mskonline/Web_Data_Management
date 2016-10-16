/*
Student Name:  Sai Kumar Mankan
ID: 1001236131
Email: saikumar.manakan@mavs.uta.edu
*/

var api_key = "fe68ebb8ef6e83fa4d3208acab2b2d68";

function sendRequest () {
    var elem = document.getElementById('output');
    elem.style.display = "none";

    var xhr = new XMLHttpRequest();
    var city = encodeURI(document.getElementById("form-input").value);

    if(city === '') {
      alert('Please enter city.');
      return;
    }

    xhr.open("GET", "proxy.php?q="+city+"&appid="+api_key+"&format=json&units=metric", true);
    xhr.setRequestHeader("Accept","application/json");

    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            var json = JSON.parse(this.responseText);
            displayResults(json);
        }
    };
    xhr.send(null);
}

function displayResults(resultJson){

  if(resultJson == undefined){
    alert('Something went wrong. Please try again');
    return;
  }

  var body = document.body;
  var elem = document.getElementById('wIcon');
  var url = 'http://openweathermap.org/img/w/' + resultJson.weather[0].icon + '.png';
  wIcon.style.backgroundImage = 'url('+ url + ')';

  elem = document.getElementById('cityName');
  elem.innerHTML = resultJson.name;

  elem = document.getElementById('geoCordinates');
  elem.innerHTML = resultJson.coord.lat + ' ' + resultJson.coord.lon;

  elem = document.getElementById('sunriseTime');
  elem.innerHTML = (new Date(resultJson.sys.sunrise * 1000));

  elem = document.getElementById('sunsetTime');
  elem.innerHTML = (new Date(resultJson.sys.sunset * 1000));

  elem = document.getElementById('pressure');
  elem.innerHTML = resultJson.main.pressure;

  elem = document.getElementById('humidity');
  elem.innerHTML = resultJson.main.humidity;

  elem = document.getElementById('temperature');
  elem.innerHTML = resultJson.main.temp + ' Celcius';

  elem = document.getElementById('minTemperature');
  elem.innerHTML = resultJson.main.temp_min + ' Celcius';

  elem = document.getElementById('maxTemperature');
  elem.innerHTML = resultJson.main.temp_max + ' Celcius';

  elem = document.getElementById('clouds');
  elem.innerHTML = resultJson.clouds.all;

  elem = document.getElementById('advise');

  // Check the weather code.
  if(willItRain(resultJson.weather[0].id)) {
    advise = "It might rain. Take an Umbrella";
  } // Cold weather
  else if(resultJson.main.temp_min < 10) {
    advise = "It will be cold today. Wear a coat";
  } // Clear day
  else {
    var advise = "It's a clear day today";
  }

  elem.innerHTML = advise;

  elem = document.getElementById('output');
  elem.style.display = "inline-block";
}

function willItRain(weatherCode){
  var code = String(weatherCode).charAt(0);

  /*
    From OpenWeather API doc.
    https://openweathermap.org/weather-conditions
    2xx - Thunderstorm
    3xx - Drizzle
    5xx - Rain
  */

  if(code >= 2 && code <=5)
    return true;
  else {
    return false;
  }
}
