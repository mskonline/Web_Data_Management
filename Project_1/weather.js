var api_key = "fe68ebb8ef6e83fa4d3208acab2b2d68";

function sendRequest () {
    var elem = document.getElementById('output');
    elem.style.display = "none";

    var xhr = new XMLHttpRequest();
    var city = encodeURI(document.getElementById("form-input").value);
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
  console.log(resultJson);
  var elem = document.getElementById('cityName');
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

  elem = document.getElementById('minTemperature');
  elem.innerHTML = resultJson.main.temp_min;

  elem = document.getElementById('maxTemperature');
  elem.innerHTML = resultJson.main.temp_max;

  elem = document.getElementById('visibility');
  //elem.innerHTML = resultJson.;

  elem = document.getElementById('clouds');
  elem.innerHTML = resultJson.clouds.all;

  var advise = "It's a clear day today";
  elem = document.getElementById('advise');

  // Cloudy
  if(resultJson.clouds.all > 60)
    advise = "It might rain. Take an Umbrella";

  // Cold weather
  if(resultJson.main.temp_min < 10)
    advise = "It will be cold today. Wear a coat";

  elem.innerHTML = advise;

  elem = document.getElementById('output');
  elem.style.display = "block";
}
