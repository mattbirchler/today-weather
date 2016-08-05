<?php


function nextHourPercip() {
  foreach ($weather_array['minutely']['data'] as $key => $value) {
    $minute = $key;
    $percipChance = $value['precipProbability'];
    echo $percipChance . "% in " . $minute . " minutes\n";
  }

}

$twitter_description = '"It is ' . $temp . ' degrees and ' . $conditions . ' right now."';

$daily_summary = $weather_array['hourly']['summary'];

$counter = 0;
$timeArray = array();
$tempArray = array();
$rainArray = array();
$intensityArray = array();
$humidArray = array();

foreach ($weather_array['hourly']['data'] as $key => $value) {
  // TIME
  $rawTime = $value['time'];
  $currTime = new DateTime('@' . $rawTime);
  $currTime->setTimeZone(new DateTimeZone($timeZone));
  $currTime = $currTime->format('ga');  // or format('ga') for am/pm

  // OTHER
  $temp = round($value['temperature']);
    if ($units == 'metric') {
        $temp = $temp -32;
        $temp = round($temp/1.8, 1);
    }
  $rainChance = $value['precipProbability'] * 100;
  $intensity = $value['precipIntensity'] * 1000;
    if ($intensity > 100) {
      $intensity = 100;
    }
  $conditions = $value['summary'];
  $iconHour = $value['icon'];
  $humidity = $value['humidity'] * 100;

  // echo "<div class='hour_summary'>" . $currTime . "<br><img src='icons/" . $iconHour . ".svg' class='hour_icon'><br><span class='hour_temp'>" . $temp . "°</span></div>";

  array_push($timeArray, $currTime);
  array_push($tempArray, $temp);
  array_push($rainArray, $rainChance);
  array_push($intensityArray, $intensity);
  array_push($humidArray, $humidity);


  if (++$counter == 25) break;

}



if ($weather_array['currently']['icon'] == "clear-day") {
    $cssConditions = "<svg version='1.1'
         id='sunFill'
         class='climacon climacon_sunFill'
         viewBox='15 15 70 70'>
      <g class='climacon_iconWrap climacon_iconWrap-sunFill'>
        <g class='climacon_componentWrap climacon_componentWrap-sun'>
          <g class='climacon_componentWrap climacon_componentWrap-sunSpoke'>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-east'
                  d='M72.03,51.999h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S73.136,51.999,72.03,51.999z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northEast'
                  d='M64.175,38.688c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L64.175,38.688z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north'
                  d='M50.034,34.002c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C52.034,33.106,51.136,34.002,50.034,34.002z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northWest'
                  d='M35.893,38.688l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C37.94,39.469,36.674,39.469,35.893,38.688z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-west'
                  d='M34.034,50c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C33.14,48,34.034,48.896,34.034,50z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southWest'
                  d='M35.893,61.312c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L35.893,61.312z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-south'
                  d='M50.034,65.998c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C48.034,66.893,48.929,65.998,50.034,65.998z'/>
            <path class='climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southEast'
                  d='M64.175,61.312l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C62.126,60.531,63.392,60.531,64.175,61.312z'/>
          </g>
          <g class='climacon_componentWrap climacon_componentWrap_sunBody'>
            <circle class='climacon_component climacon_component-stroke climacon_component-stroke_sunBody'
                    cx='50.034'
                    cy='50'
                    r='11.999'/>
            <circle class='climacon_component climacon_component-fill climacon_component-fill_sunBody'
                    fill='#FFFFFF'
                    cx='50.034'
                    cy='50'
                    r='7.999'/>
          </g>
        </g>
      </g>
    </svg>";
}

elseif ($weather_array['currently']['icon'] == "clear-night") {
    $cssConditions = '<svg version="1.1"
         id="moon"
         class="climacon climacon_moonFill"
         viewBox="15 15 70 70">
      <g class="climacon_iconWrap climacon_iconWrap-moonFill">
        <g class="climacon_componentWrap climacon_componentWrap-moon">
          <path class="climacon_component climacon_component-stroke climacon_component-stroke_moon"
                d="M50,61.998c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C61.998,56.626,56.626,61.998,50,61.998z"/>
          <path
                class="climacon_component climacon_component-fill climacon_component-fill_moon"
                fill="#FFFFFF"
                d="M48.212,42.208c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C52.938,50.884,49.115,47.062,48.212,42.208z"/>
        </g>
      </g>
    </svg>';
}

elseif ($weather_array['currently']['icon'] == "partly-cloudy-day") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudSunFill"
       class="climacon climacon_cloudSunFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_cloudSunFill-iconWrap">
      <g class="climacon_componentWrap climacon_componentWrap-sun climacon_componentWrap-sun_cloud">
        <g class="climacon_componentWrap climacon_componentWrap_sunSpoke">
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M80.029,43.611h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S81.135,43.611,80.029,43.611z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M72.174,30.3c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L72.174,30.3z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M58.033,25.614c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C60.033,24.718,59.135,25.614,58.033,25.614z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M43.892,30.3l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C45.939,31.081,44.673,31.081,43.892,30.3z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M42.033,41.612c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C41.139,39.612,42.033,40.509,42.033,41.612z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M43.892,52.925c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L43.892,52.925z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M58.033,57.61c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C56.033,58.505,56.928,57.61,58.033,57.61z"/>
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                d="M72.174,52.925l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C70.125,52.144,71.391,52.144,72.174,52.925z"/>
        </g>
        <g class="climacon_wrapperComponent climacon_wrapperComponent-sunBody">
          <circle
                  class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
                  cx="58.033"
                  cy="41.612"
                  r="11.999"
                  />
          <circle
                  class="climacon_component climacon_component-fill climacon_component-fill_sunBody"
                  fill="#FFFFFF"
                  cx="58.033"
                  cy="41.612" r="7.999"
                  />
        </g>
      </g>
      <g class="climacon_wrapperComponent climacon_wrapperComponent-cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M44.033,65.641c-8.836,0-15.999-7.162-15.999-15.998c0-8.835,7.163-15.998,15.999-15.998c6.006,0,11.233,3.312,13.969,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.26,65.641,47.23,65.641,44.033,65.641z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M60.035,61.641c4.418,0,8-3.582,8-7.998c0-4.418-3.582-8-8-8c-1.6,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.976-9.29-11.668-9.29c-6.627,0-11.999,5.372-11.999,11.999c0,6.627,5.372,11.998,11.999,11.998C47.65,61.641,57.016,61.641,60.035,61.641z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "partly-cloudy-night") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudMoonFill"
       class="climacon climacon_cloudMoonFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloudMoonFill">
      <g class="climacon_wrapperComponent climacon_wrapperComponent-moon climacon_componentWrap-moon_cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_moon"
              d="M61.023,50.641c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C73.021,45.269,67.649,50.641,61.023,50.641z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_moon"
              fill="#FFFFFF"
              d="M59.235,30.851c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C63.961,39.527,60.139,35.705,59.235,30.851z"/>
      </g>
      <g class="climacon_wrapperComponent climacon_wrapperComponent-cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M44.033,65.641c-8.836,0-15.999-7.162-15.999-15.998c0-8.835,7.163-15.998,15.999-15.998c6.006,0,11.233,3.312,13.969,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.26,65.641,47.23,65.641,44.033,65.641z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M60.035,61.641c4.418,0,8-3.582,8-7.998c0-4.418-3.582-8-8-8c-1.6,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.976-9.29-11.668-9.29c-6.627,0-11.999,5.372-11.999,11.999c0,6.627,5.372,11.998,11.999,11.998C47.65,61.641,57.016,61.641,60.035,61.641z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "cloudy") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudFill"
       class="climacon climacon_cloudFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloud">
      <g class="climacon_componentWrap climacon_componentWrap_cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "rain") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudDrizzleFill"
       class="climacon climacon_cloudDrizzleFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloudDrizzleFill">
      <g class="climacon_wrapperComponent climacon_wrapperComponent-drizzle">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-left"
              d="M42.001,53.644c1.104,0,2,0.896,2,2v3.998c0,1.105-0.896,2-2,2c-1.105,0-2.001-0.895-2.001-2v-3.998C40,54.538,40.896,53.644,42.001,53.644z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-middle"
              d="M49.999,53.644c1.104,0,2,0.896,2,2v4c0,1.104-0.896,2-2,2s-1.998-0.896-1.998-2v-4C48.001,54.54,48.896,53.644,49.999,53.644z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-right"
              d="M57.999,53.644c1.104,0,2,0.896,2,2v3.998c0,1.105-0.896,2-2,2c-1.105,0-2-0.895-2-2v-3.998C55.999,54.538,56.894,53.644,57.999,53.644z"/>
      </g>

      <g class="climacon_componentWrap climacon_componentWrap_cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "sleet") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudHailAltFill"
       class="climacon climacon_cloudHailAltFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloudHailAltFill">
      <g class="climacon_wrapperComponent climacon_wrapperComponent-hailAlt">
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
          <circle cx="42" cy="65.498" r="2"/>
        </g>
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
          <circle cx="49.999" cy="65.498" r="2"/>
        </g>
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
          <circle cx="57.998" cy="65.498" r="2"/>
        </g>
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
          <circle cx="42" cy="65.498" r="2"/>
        </g>
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
          <circle cx="49.999" cy="65.498" r="2"/>
        </g>
        <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
          <circle cx="57.998" cy="65.498" r="2"/>
        </g>
      </g>
      <g class="climacon_componentWrap climacon_componentWrap_cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "snow") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudSnowAltFill"
       class="climacon climacon_cloudSnowAltFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloudSnowAltFill">
      <g class="climacon_wrapperComponent climacon_wrapperComponent-snowAlt">
        <g class="climacon_component climacon_component climacon_component-snowAlt">
          <path
                class="climacon_component climacon_component-stroke climacon_component-stroke_snowAlt"
                d="M43.072,59.641c0.553-0.957,1.775-1.283,2.732-0.731L48,60.176v-2.535c0-1.104,0.896-2,2-2c1.104,0,2,0.896,2,2v2.535l2.195-1.268c0.957-0.551,2.18-0.225,2.73,0.732c0.553,0.957,0.225,2.18-0.73,2.731l-2.196,1.269l2.196,1.268c0.955,0.553,1.283,1.775,0.73,2.732c-0.552,0.954-1.773,1.282-2.73,0.729L52,67.104v2.535c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2v-2.535l-2.195,1.269c-0.957,0.553-2.18,0.226-2.732-0.729c-0.552-0.957-0.225-2.181,0.732-2.732L46,63.641l-2.195-1.268C42.848,61.82,42.521,60.598,43.072,59.641z"/>
          <circle
                  class="climacon_component climacon_component-fill climacon_component-fill_snowAlt"
                  fill="#FFFFFF"
                  cx="50"
                  cy="63.641"
                  r="2"/>
        </g>
      </g>
      <g class="climacon_componentWrap climacon_componentWrap_cloud">
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
              d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
        <path
              class="climacon_component climacon_component-fill climacon_component-fill_cloud"
              fill="#FFFFFF"
              d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "wind") {
  $cssConditions = '<svg version="1.1"
       id="wind"
       class="climacon climacon_wind"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-wind">
      <g class="climacon_wrapperComponent climacon_componentWrap-wind">
        <path
              class="climacon_component climacon_component-stroke climacon_component-wind climacon_component-wind_curl"
              d="M65.999,52L65.999,52h-3c-1.104,0-2-0.895-2-1.999c0-1.104,0.896-2,2-2h3c1.104,0,2-0.896,2-1.999c0-1.105-0.896-2-2-2s-2-0.896-2-2s0.896-2,2-2c0.138,0,0.271,0.014,0.401,0.041c3.121,0.211,5.597,2.783,5.597,5.959C71.997,49.314,69.312,52,65.999,52z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-wind"
              d="M55.999,48.001h-2h-6.998H34.002c-1.104,0-1.999,0.896-1.999,2c0,1.104,0.895,1.999,1.999,1.999h2h3.999h3h4h3h3.998h2c3.313,0,6,2.688,6,6c0,3.176-2.476,5.748-5.597,5.959C56.271,63.986,56.139,64,55.999,64c-1.104,0-2-0.896-2-2c0-1.105,0.896-2,2-2s2-0.896,2-2s-0.896-2-2-2h-2h-3.998h-3h-4h-3h-3.999h-2c-3.313,0-5.999-2.686-5.999-5.999c0-3.175,2.475-5.747,5.596-5.959c0.131-0.026,0.266-0.04,0.403-0.04l0,0h12.999h6.998h2c1.104,0,2-0.896,2-2s-0.896-2-2-2s-2-0.895-2-2c0-1.104,0.896-2,2-2c0.14,0,0.272,0.015,0.403,0.041c3.121,0.211,5.597,2.783,5.597,5.959C61.999,45.314,59.312,48.001,55.999,48.001z"/>
      </g>
    </g>
  </svg>';
}

elseif ($weather_array['currently']['icon'] == "fog") {
  $cssConditions = '<svg
       version="1.1"
       id="cloudFogAltFill"
       class="climacon climacon_cloudFogAltFill"
       viewBox="15 15 70 70">
    <g class="climacon_iconWrap climacon_iconWrap-cloudFogAltFill">
      <g class="climacon_wrapperComponent climacon_wrapperComponent-Fog">
        <g class="climacon_componentWrap climacon_componentWrap_cloud">
          <path
                class="climacon_component climacon_component-fill climacon_component-fill_cloud"
                fill="#FFFFFF"
                d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
        </g>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M29.177,55.641c-0.262-0.646-0.473-1.314-0.648-2h43.47c0,0.685-0.069,1.349-0.181,2H29.177z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M36.263,35.643c2.294-1.271,4.93-1.999,7.738-1.999c2.806,0,5.436,0.73,7.728,1.999H36.263z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M28.142,47.642c0.085-0.682,0.218-1.347,0.387-1.999h40.396c0.552,0.613,1.039,1.281,1.455,1.999H28.142z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M29.177,43.643c0.281-0.693,0.613-1.359,0.984-2h27.682c0.04,0.068,0.084,0.135,0.123,0.205c0.664-0.114,1.339-0.205,2.033-0.205c2.451,0,4.729,0.738,6.627,2H29.177z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M31.524,39.643c0.58-0.723,1.225-1.388,1.92-2h21.123c0.689,0.61,1.326,1.28,1.902,2H31.524z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M71.816,51.641H28.142c-0.082-0.656-0.139-1.32-0.139-1.999h43.298C71.527,50.285,71.702,50.953,71.816,51.641z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M71.301,57.641c-0.246,0.699-0.555,1.367-0.921,2H31.524c-0.505-0.629-0.957-1.299-1.363-2H71.301z"/>
        <path
              class="climacon_component climacon_component-stroke climacon_component-stroke_fogLine"
              d="M33.444,61.641h35.48c-0.68,0.758-1.447,1.435-2.299,2H36.263C35.247,63.078,34.309,62.4,33.444,61.641z"/>
      </g>

    </g>
  </svg>';
} else {
    $cssConditions = "BROKEN";
}







$dayArray = array();
$rainChanceArray = array();
$intesityWeekArray = array();
$highTempArray = array();
$lowTempArray = array();
$humidityArray = array();

foreach ($weather_array['daily']['data'] as $key => $value) {
  // TIME
  $rawTime = $value['time'];
  $day = new DateTime('@' . $rawTime);
  $day->setTimeZone(new DateTimeZone($timeZone));
  $day = $day->format('D');  // or format('ga') for am/pm

  // OTHER
  $temp = round($value['temperature']);
  $rainChance = $value['precipProbability'] * 100;
  $intensity = $value['precipIntensity'] * 1000;
  $max = round($value['temperatureMax']);
  $min = round($value['temperatureMin']);
  $humidity = $value['humidity'] * 100;

  if ($units == 'metric') {
      $max = $max -32;
      $max = round($max/1.8, 1);

      $min = $min -32;
      $min = round($min/1.8, 1);
  }

  array_push($dayArray, $day);
  array_push($rainChanceArray, $rainChance);
  array_push($highTempArray, $max);
  array_push($lowTempArray, $min);
  array_push($humidityArray, $humidity);
  array_push($intesityWeekArray, $intensity);

}

?>
