<?php

// Old Key: AIzaSyAFvN0L5V9h8yJcPqVI1AZo196QiS9z9lw

if ($_GET['lng']) {

    $weather_url = "https://api.forecast.io/forecast/7779924cd6027a3456e74141d70d7c50/" . $_GET['lat'] . "," . $_GET['lng'];
    $weather_json = file_get_contents($weather_url);
    $weather_array = json_decode($weather_json, true);
    // print_r($weather_array);

    $googleApi = "https://maps.googleapis.com/maps/api/geocode/json";
    $googleKey="AIzaSyCCcYZ3lSNTjwjF-5CmeTXp6jlzoXwAcd4";
    $geoLat = urlencode($_GET['lat']);
    $geoLng = urlencode($_GET['lng']);
    $google_post_url = $googleApi . "?latlng=" . $geoLat . "," . $geoLng . "&key=" . $googleKey;

    $google_json = file_get_contents($google_post_url);
    $google_array = json_decode($google_json, true);

    $location = $google_array['results']['0']['formatted_address'];

    for (
        $i=0;
        $i < count($google_array['results']['0']['address_components']);
        $i++)
    {
        if ($google_array['results']['0']['address_components'][$i]['types']['0'] == 'country') {
            $country = $google_array['results']['0']['address_components'][$i]['short_name'];
            break;
        }

    }

    // If need other countries: BS, BZ, KY, PW

    if ($country == "US") {
        $units = "imperial";
    } else {
        $units = "metric";
    }


}

elseif( empty( $_POST['address']) && empty($_GET['lng']) ) {

    $geolocation = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));

    $latit = $geolocation['geoplugin_latitude'];
    $longt = $geolocation['geoplugin_longitude'];
    $city = $geolocation['geoplugin_city'];

    $googleApi = "https://maps.googleapis.com/maps/api/geocode/json";
    $googleKey="AIzaSyCCcYZ3lSNTjwjF-5CmeTXp6jlzoXwAcd4";
    $geoLat = urlencode($geolocation['geoplugin_latitude']);
    $geoLng = urlencode($geolocation['geoplugin_longitude']);
    $google_post_url = $googleApi . "?latlng=" . $geoLat . "," . $geoLng . "&key=" . $googleKey;

    $google_json = file_get_contents($google_post_url);
    $google_array = json_decode($google_json, true);

    $location = $google_array['results']['0']['formatted_address'];

    for (
        $i=0;
        $i < count($google_array['results']['0']['address_components']);
        $i++)
    {
        if ($google_array['results']['0']['address_components'][$i]['types']['0'] == 'country') {
            $country = $google_array['results']['0']['address_components'][$i]['short_name'];
            break;
        }

    }

    if ($country == "US") {
        $units = "imperial";
    } else {
        $units = "metric";
    }

    $weather_url = "https://api.forecast.io/forecast/7779924cd6027a3456e74141d70d7c50/" . $latit . "," . $longt;

}

// https://maps.googleapis.com/maps/api/geocode/json?address=new york&key=AIzaSyAFvN0L5V9h8yJcPqVI1AZo196QiS9z9lw

elseif ( !empty($_POST['address']) && empty($_GET['lng']) ) {
    $googleApi = "https://maps.googleapis.com/maps/api/geocode/json";
    $googleKey="AIzaSyCCcYZ3lSNTjwjF-5CmeTXp6jlzoXwAcd4";
    $address_term = urlencode($_POST['address']);

    $google_post_url = $googleApi . "?address=" . $address_term . "&key=" . $googleKey;

    $google_json = file_get_contents($google_post_url);
    $google_array = json_decode($google_json, true);

    // Test the post URL
    // echo $google_post_url;

    $latit = $google_array['results']['0']['geometry']['location']['lat'];
    $longt = $google_array['results']['0']['geometry']['location']['lng'];

    $location = $google_array['results']['0']['formatted_address'];

    for (
        $i=0;
        $i < count($google_array['results']['0']['address_components']);
        $i++)
    {
        if ($google_array['results']['0']['address_components'][$i]['types']['0'] == 'country') {
            $country = $google_array['results']['0']['address_components'][$i]['short_name'];
            break;
        }

    }

    if ($country == "US") {
        $units = "imperial";
    } else {
        $units = "metric";
    }

    $weather_url = "https://api.forecast.io/forecast/7779924cd6027a3456e74141d70d7c50/" . $latit . "," . $longt;

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
    $curSummary = $weather_array['currently']['summary'];
    $curIcon = $weather_array['currently']['icon'];
    $curFeelsLike = round($weather_array['currently']['apparentTemperature']);
    $minSum = $weather_array['minutely']['summary'];
    // echo $curIcon;






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
}






?>
