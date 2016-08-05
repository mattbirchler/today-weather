<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width">
<body onload="getLocation()">

<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude;
    console.log("lat is " + position.coords.latitude);
    console.log("lng is " + position.coords.longitude);
}
</script>

</body>
</html>
