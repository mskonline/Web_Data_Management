/*
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
*/

var api_key = "fe68ebb8ef6e83fa4d3208acab2b2d68";

function initPage(){
  var input = document.getElementById('form-input');

  // Adding KeyPress event for the 'Enter' key
  input.addEventListener('keypress', function(e){
    var keycode = e.keyCode;

    // 'Enter' key is pressed
    if(keycode == 13)
      sendRequest();
  });
}

function sendRequest () {
  var elem = document.getElementById('output');
  elem.style.display = "none";

  var xhr = new XMLHttpRequest();
  var city = encodeURI(document.getElementById("form-input").value);

  var units;
  if(document.getElementById('def_units').checked)
    units = 'default';
  else if (document.getElementById('met_units').checked)
    units = 'metric';
  else {
    units = 'imperial';
  }

  if(city === '') {
    alert('Please enter city.');
    return;
  }

  xhr.open("GET", "proxy.php?q=" + city + "&appid=" + api_key + "&format=json&units=" + units, true);
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

  var units;
  if(document.getElementById('def_units').checked)
    units = ' Kelvin';
  else if (document.getElementById('met_units').checked)
    units = ' Celcius';
  else {
    units = ' Fahrenheit';
  }

  var body = document.body;
  var elem = document.getElementById('wIcon');
  var iconUrl = 'http://openweathermap.org/img/w/' + resultJson.weather[0].icon + '.png';
  wIcon.style.backgroundImage = 'url('+ iconUrl + ')';

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
  elem.innerHTML = resultJson.main.temp + units;

  elem = document.getElementById('minTemperature');
  elem.innerHTML = resultJson.main.temp_min + units;

  elem = document.getElementById('maxTemperature');
  elem.innerHTML = resultJson.main.temp_max + units;

  elem = document.getElementById('clouds');
  elem.innerHTML = resultJson.clouds.all;

  elem = document.getElementById('visibility');
  elem.innerHTML = findVisibility(resultJson.weather[0].id);

  elem = document.getElementById('advise');

  var advise;

  // Check the weather code.
  if(willItRain(resultJson.weather[0].id)) {
    advise = "It might rain. Take an Umbrella";
  } // Cold weather
  else if(resultJson.main.temp_min < 10) {
    advise = "It will be cold today. Wear a coat";
  } // Clear day
  else {
    advise = "It's a clear day today";
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
  else
    return false;
}

function findVisibility(weatherCode){
  var code = String(weatherCode).charAt(0);
  /*
    From OpenWeather API doc.
    https://openweathermap.org/weather-conditions
    2xx - Clear
    9xx - Extreme (as in Hotness, Coldness etc)

    For only 2xx, 9xx we will assume Good visibility else Bad
    (All other codes eg Rain, Thunderstorm, Snow will have bad visibility)
  */
  if(code == 8 || code == 9)
    return 'Good';
  else
    return 'Bad';
}
