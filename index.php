<!DOCTYPE html>

<?php

@include 'geolocation.php';
@include 'data_manipulation.php';
@include 'functions.php';

?>


<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="apple-mobile-web-app-capable" content="yes"> -->
    <title>Today Weather</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="lxukH.css" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" href="https://today-weather.com/today-weather-twitter.png">
    <link rel="apple-touch-startup-image" href="https://today-weather.com/startup.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="icon" type="image/png" href="https://today-weather.com/today-weather-favocon.png">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic|Oswald:400,700|Dosis:400,500,600,700|Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-3160374858312436",
        enable_page_level_ads: true
      });
    </script>
    <meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@mattbirchler" />
	<meta name="twitter:title" content="Today Weather: Beautiful weather forecasts" />
	<meta name="twitter:description" content="Check the weather on the best looking weather website you've ever seen." />
	<meta name="twitter:image" content="https://today-weather.com/today-weather-twitter.png" />
</head>


<body onload="queryStart()">



<div class="location">
    <form id="geolocationHTML" action="" method="get">
        <input type="hidden" id="hiddenLat" name="lat" value="">
        <input type="hidden" id="hiddenLng" name="lng" value="">
        <input type="submit" name="searchHTML5" value="">
    </form>
</div>

<script>

    function queryStart() {

    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, error);
        } else {
            // x.innerHTML = "Geolocation is not supported by this browser.";
            alert("Your browser does not support geolocation.")
        }


    }

    function showPosition(position) {
        document.getElementById('hiddenLat').value = position.coords.latitude;
        document.getElementById('hiddenLng').value = position.coords.longitude;
        document.getElementById("geolocationHTML").submit();
    }

    function error() {
        alert("Please turn on geolocation in your browser settings to use this feature.");
    }

</script>



<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-28230642-4', 'auto');
    ga('send', 'pageview');

</script>

<div class="banner">
    <a href="/">Today Weather</a>
</div>

<div id="findMe" onclick="getLocation()">
    <span>Find me</span>
    <img id="locateMe" src="placeholder.svg" alt="" />
</div>

<div class="search">
    <form class="locationSearch" action="https://today-weather.com" method="post">
        <input type="text" name="address" id="search_term" placeholder="<?php echo $location ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo $location ?>'">
    </form>
</div>

<div id="data_container">
<div id="now_container">

<div class="sub_banner" id="currently">
    <span class="sub_heading">Currently</span>
</div>

<div class="current_container">

  <?php
  if ( !empty($weather_array['alerts'][0]) ) {
      echo '<div class="alert">';
      echo '<span id="alert_title">' . $weather_array['alerts'][0]['title'] . '</span>';
      echo "<br>";
      echo '<span id="alert_button" onclick="showAlert()">read more</span>';
      echo "<br>";
      echo '<p id="alert_message" class="hide_alert">' . $weather_array['alerts'][0]['description'] . '<br><br><a target="_blank" href="' . $weather_array['alerts'][0]['uri'] . '">NOAA link</a></p>';
      echo '<script type="text/javascript">
          function showAlert() {
              var messageClass = document.querySelector("#alert_message");
              var newClass = "hide_alert";
              messageClass.classList.toggle(newClass);
          }
      </script>
    </div>';
  }
  ?>

  <div id="datetime">
    <?php
      echo $curDate . "<br>" . $currTime2;
      // echo "<br>" . $location;
    ?>
  </div>
  <div class="top_current">
    <?php echo $cssConditions; ?>
    <div class="top_current_right">
      <span id="temp"><?php echo $curTemp; ?></span>
      <br>
      <span id="conditions"><?php echo $curSummary; ?></span>
    </div>
  </div>

  <div id="highLow">
      <span class="condition_label">High:</span> <?php echo $todayHigh ?>°&nbsp;&nbsp;&nbsp;&nbsp; <span class="condition_label">Low:</span> <?php echo $todayLow ?>°
  </div>


  <div class="current_summary">
    <?php echo $minSum; ?>
  </div>
</div>

<?php

$i = array();
foreach ($weather_array['minutely']['data'] as $key => $value) {
  array_push($i, $value['precipProbability']);
  if (++$counter == 24) break;
}
$max_odds = max($i);

$show_percip = "next_hour_rain_container";

if ($max_odds <= 0.15) {
  $show_percip = "next_hour_rain_hide";
}

?>

<div class="<?php echo $show_percip; ?>">
  <div class="rain_banner">
    <!-- Percipitation Soon -->
  </div>
  <div class="next_hour_vals">
    <div class="next_hour_block">
      <?php
        foreach ($weather_array['minutely']['data'] as $key => $value) {
          $minute = $key;
          $percipChance = $value['precipProbability'] * 100;
          if ($percipChance >= 15) {
            echo "Next Hour";
            break;
          }
        }
      ?>
    </div>
    <canvas id="hourRain" width="400" height="180"></canvas>
  </div>
</div>

<span id="details" onclick="showDetails()">Tap for details</span>

<div class="current_details">



<script type="text/javascript">
    function showDetails() {
        var messageClass = document.querySelector("#details_table");
        var newClass = "show_details";
        messageClass.classList.toggle(newClass);
    }
</script>

<table id="details_table" class="show_details" style="width:100%">
  <tr>
    <td class="condition_label">Feels Like</td>
    <td><?php echo $curFeelsLike; ?></td>
  </tr>
  <tr>
    <td class="condition_label">Humidity</td>
    <td><?php echo $weather_array['currently']['humidity'] * 100 . "%"; ?></td>
  </tr>
  <tr>
    <td class="condition_label">Dew Point</td>
    <td><?php echo $dewPoint; ?></td>
  </tr>
  <tr>
    <td class="condition_label">Wind Speed</td>
    <td><?php echo $windSpeed ?></td>
  </tr>
  <tr>
    <td class="condition_label">Wind Direction</td>
    <td><?php echo $windDirection; ?></td>
  </tr>
  <tr>
    <td class="condition_label">Visibility</td>
    <td><?php echo $weather_array['currently']['visibility']; ?></td>
  </tr>
  <tr>
    <td class="condition_label">Pressure</td>
    <td><?php echo round($weather_array['currently']['pressure']); ?> mb</td>
  </tr>
  <tr>
    <td class="condition_label">Nearest Storm</td>
    <td><?php echo $nearestStormDistance ?></td>
  </tr>
</table>
</div>

</div>

<div class="hour_24_container">
  <div class="sub_banner" id="hour_24">
    <span class="sub_heading">24 Hour Forecast</span>
  </div>

  <div class="twentyfour_hour_hour">
    <span id="summey24"><?php echo $daily_summary; ?></span>
  </div>


<div class="daily_chart">
    <canvas id="24hourchart" width="400px" height="290px"></canvas>
    <canvas id="24hourrain" width="400px" height="290px"></canvas>
    <canvas id="24humidity" width="400px" height="290px"></canvas>
</div>

</div>
</div>

<div class="inline_ad">

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Today Weather -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-3160374858312436"
         data-ad-slot="5373893106"
         data-ad-format="auto"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>

<div class="week_view">
    <div class="sub_banner" id="currently">
        <span class="sub_heading">7 Day Forecast</span>
    </div>
    <div class="weekly_chart">
        <canvas id="weekly_temp" width="400px" height="220px"></canvas>
        <canvas id="weekly_rain" width="400px" height="220px"></canvas>
        <canvas id="weekly_humidity" width="400px" height="220px"></canvas>
    </div>
</div>

<script type="text/javascript" src="chart.js"></script>

<script>
var timeOfDay = [
    <?php
        for ($x = 1; $x < 25; $x++) {
            $time = $x;
            echo "'" . $timeArray[$time] . "', ";
        }
     ?>];

var tempOfHour = [
    <?php
        for ($x = 1; $x < 25; $x++) {
            echo $tempArray[$x] . ", ";
        }
     ?>];

var rainOfHour = [
    <?php
        for ($x = 1; $x < 25; $x++) {
            echo $rainArray[$x] . ", ";
        }
     ?>];

var intensityOfHour = [
    <?php
        for ($x = 1; $x < 25; $x++) {
            echo $intensityArray[$x] . ", ";
        }
     ?>];

var humidity = [
    <?php
        for ($x = 1; $x < 25; $x++) {
            echo $humidArray[$x] . ", ";
        }
     ?>];

var nextHourPercip = [
    <?php
        foreach ($hourly_array as $value) {
            echo $value . ", ";
        }
     ?>];

var nextHourIntensity = [
    <?php
        foreach ($hourly_intensity_array as $value) {
            if ( $value > 100 ) {
                $value = 100;
            };
            echo $value . ", ";
        }
     ?>];

var weeklyRainArray = [
    <?php
        foreach ($rainChanceArray as $value) {
            echo $value . ", ";
        }
    ?>];

var weeklyRainIntensity = [
    <?php
        foreach ($intesityWeekArray as $value) {
            echo $value . ", ";
        }
    ?>];

var weeklyHighArray = [
    <?php
        foreach ($highTempArray as $value) {
            echo $value . ", ";
        }
    ?>];

var weeklyLowArray = [
    <?php
        foreach ($lowTempArray as $value) {
            echo $value . ", ";
        }
    ?>];

var weeklyHumidityArray = [
    <?php
        foreach ($humidityArray as $value) {
            echo $value . ", ";
        }
    ?>];

var weeklyDays = [
    <?php
        foreach ($dayArray as $value) {
            echo "'" . $value . "', ";
        }
    ?>];

</script>

<script src="script.js"></script>


</body>
</html>



<footer>
    <a href="https://today-weather.com/about.php">FAQ</a> | Built on <a href="https://developer.forecast.io">Dark Sky</a>
    <br><br>
    &#169; 2016 <a href="https://birchtree.me" class="footer_link" target="_blank">Matt Birchler</a>
</footer>
