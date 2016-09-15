<?php

  include 'token.php';

  $meteo = file_get_contents("http://api.wunderground.com/api/".$tokenwg."/conditions/lang:IT/q/Italy/Desio.json");
  $json = json_decode($meteo, true);
  $condizione = $json['current_observation']['weather'];
  $temp= $json['current_observation']['temp_c'];
  $umidita=$json['current_observation']['relative_humidity'];
  $icon=$json['current_observation']['icon'];
  switch ($icon) {
    case "rain":
      $icont=":umbrella:";
      break;
    case "partlycloudy":
      $icont=":partly_sunny:";
      break;
  }
  echo 'Condizioni: '.$condizione." ".$icont."\r\n";
  echo 'Temperatura: '.$temp."° C\r\n";
  echo 'Umidità: '.$umidita."\r\n";
?>
