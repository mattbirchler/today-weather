<?php

$weather_json = file_get_contents($weather_url);
$weather_array = json_decode($weather_json, true);

////////////////// SET VARIABLES //////////////////

///////// DATE AND TIME /////////
$timeZone = $weather_array[timezone];
$rawTime = $weather_array['currently']['time'];
$curDate = gmdate("D F j, Y", $rawTime);
$currTime2 = new DateTime('@' . $rawTime);
$currTime2->setTimeZone(new DateTimeZone($timeZone));
$currTime2 = $currTime2->format('g:i a');

///////// CURRENT CONDITIONS /////////
$curTemp = round($weather_array['currently']['temperature']);
$todayHigh = round($weather_array['daily']['data']['0']['temperatureMax']);
$todayLow = round($weather_array['daily']['data']['0']['temperatureMin']);
$curSummary = $weather_array['currently']['summary'];
$curIcon = $weather_array['currently']['icon'];
$curFeelsLike = round($weather_array['currently']['apparentTemperature']);
$minSum = $weather_array['minutely']['summary'];
$dewPoint = $weather_array['currently']['dewPoint'];
$windSpeed = $weather_array['currently']['windSpeed'];
$nearestStormDistance = $weather_array['currently']['nearestStormDistance'];
$windDirRaw = $weather_array['currently']['windBearing'];
if ($windDirRaw >= 0 && $windDirRaw <=22) {
    $windDirection = "N";
} elseif ($windDirRaw >= 23 && $windDirRaw <=68) {
    $windDirection = "NE";
} elseif ($windDirRaw >= 69 && $windDirRaw <=114) {
    $windDirection = "E";
} elseif ($windDirRaw >= 115 && $windDirRaw <=160) {
    $windDirection = "SE";
} elseif ($windDirRaw >= 161 && $windDirRaw <=206) {
    $windDirection = "S";
} elseif ($windDirRaw >= 207 && $windDirRaw <=252) {
    $windDirection = "SW";
} elseif ($windDirRaw >= 253 && $windDirRaw <=298) {
    $windDirection = "W";
} elseif ($windDirRaw >= 299 && $windDirRaw <=344) {
    $windDirection = "NW";
} elseif ($windDirRaw >= 345 && $windDirRaw <=359) {
    $windDirection = "N";
};

if ($_GET['metric'] == "true" || $units == "metric") {
    $curTemp = $curTemp - 32;
    $curTemp = round($curTemp/1.8);
    $curTemp = $curTemp . "°C";

    $todayHigh = $todayHigh -32;
    $todayHigh = round($todayHigh/1.8);

    $todayLow = $todayLow -32;
    $todayLow = round($todayLow/1.8);

    $curFeelsLike = $curFeelsLike -32;
    $curFeelsLike = round($curFeelsLike/1.8);
    $curFeelsLike = $curFeelsLike . "°C";

    $dewPoint = $dewPoint -32;
    $dewPoint = round($dewPoint/1.8, 2);

    $windSpeed = round($windSpeed * 1.60934);
    $windSpeed = $windSpeed . " kph";

    $nearestStormDistance = round($nearestStormDistance * 1.60934);
    $nearestStormDistance = $nearestStormDistance . " km";
} else {
    $curTemp = $curTemp . "°F";
    $curFeelsLike = $curFeelsLike . "°F";
    $windSpeed = $windSpeed . " mph";
    $nearestStormDistance = $nearestStormDistance . " miles";
}


// echo $curIcon;

/////////// NEXT HOUR INFORMATION ///////////

$min05 = $weather_array['minutely']['data'][5]['precipProbability'] * 100;
$min10 = $weather_array['minutely']['data'][10]['precipProbability'] * 100;
$min15 = $weather_array['minutely']['data'][15]['precipProbability'] * 100;
$min20 = $weather_array['minutely']['data'][20]['precipProbability'] * 100;
$min25 = $weather_array['minutely']['data'][25]['precipProbability'] * 100;
$min30 = $weather_array['minutely']['data'][30]['precipProbability'] * 100;
$min35 = $weather_array['minutely']['data'][35]['precipProbability'] * 100;
$min40 = $weather_array['minutely']['data'][40]['precipProbability'] * 100;
$min45 = $weather_array['minutely']['data'][45]['precipProbability'] * 100;
$min50 = $weather_array['minutely']['data'][50]['precipProbability'] * 100;
$min55 = $weather_array['minutely']['data'][55]['precipProbability'] * 100;
$min60 = $weather_array['minutely']['data'][60]['precipProbability'] * 100;

$minIntensity05 = $weather_array['minutely']['data'][5]['precipIntensity'] * 1000;
$minIntensity10 = $weather_array['minutely']['data'][10]['precipIntensity'] * 1000;
$minIntensity15 = $weather_array['minutely']['data'][15]['precipIntensity'] * 1000;
$minIntensity20 = $weather_array['minutely']['data'][20]['precipIntensity'] * 1000;
$minIntensity25 = $weather_array['minutely']['data'][25]['precipIntensity'] * 1000;
$minIntensity30 = $weather_array['minutely']['data'][30]['precipIntensity'] * 1000;
$minIntensity35 = $weather_array['minutely']['data'][35]['precipIntensity'] * 1000;
$minIntensity40 = $weather_array['minutely']['data'][40]['precipIntensity'] * 1000;
$minIntensity45 = $weather_array['minutely']['data'][45]['precipIntensity'] * 1000;
$minIntensity50 = $weather_array['minutely']['data'][50]['precipIntensity'] * 1000;
$minIntensity55 = $weather_array['minutely']['data'][55]['precipIntensity'] * 1000;
$minIntensity60 = $weather_array['minutely']['data'][60]['precipIntensity'] * 1000;

$hourly_array = array($min05, $min10, $min15, $min20, $min25, $min30, $min35, $min40, $min45, $min50, $min55, $min60);
$hourly_intensity_array = array($minIntensity05, $minIntensity10, $minIntensity15, $minIntensity20, $minIntensity25, $minIntensity30, $minIntensity35, $minIntensity40, $minIntensity45, $minIntensity50, $minIntensity55, $minIntensity60);


// SET CONDITION ICON
if ($curIcon == "clear-day") {
  $icon_svg = "CLEAR_DAY";
}
elseif ($curIcon == "clear-night") {
  $icon_svg = "CLEAR_NIGHT";
}
elseif ($curIcon == "partly-cloudy-day") {
  $icon_svg = "PARTLY_CLOUDY_DAY";
}
elseif ($curIcon == "partly-cloudy-night") {
  $icon_svg = "PARTLY_CLOUDY_NIGHT";
}
elseif ($curIcon == "cloudy") {
  $icon_svg = "CLOUDY";
}
elseif ($curIcon == "rain") {
  $icon_svg = "RAIN";
}
elseif ($curIcon == "sleet") {
  $icon_svg = "SLEET";
}
elseif ($curIcon == "snow") {
  $icon_svg = "SNOW";
}
elseif ($curIcon == "wind") {
  $icon_svg = "WIND";
}
elseif ($curIcon == "fog") {
  $icon_svg = "FOG";
}






?>
