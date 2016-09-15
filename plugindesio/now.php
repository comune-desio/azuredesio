<?php
  require __DIR__ . '/../vendor/autoload.php';

  $dotenv = new Dotenv\Dotenv(__DIR__, "../_env");
  $dotenv->load();

  $token = getenv("WUNDERGROUND_API_TOKEN");
  $meteo = file_get_contents("http://api.wunderground.com/api/${token}/conditions/lang:IT/q/Italy/Desio.json");

  $json = json_decode($meteo, true);
  $condizione = $json['current_observation']['weather'];
  $temp= $json['current_observation']['temp_c'];
  $umidita=$json['current_observation']['relative_humidity'];
  $icon=$json['current_observation']['icon'];
  
  
//  \\u2600 sole
//  \\u26c5 parzialmente nuvoloso
//  \\u2601 nuvoloso
//  \\u26a1 temporale
//  \\u2614 pioggia
//  \\u2744 neve
  
  switch ($icon) {
    case "clear":
      $icont="\\u2600";
      break;
    case "sunny":
      $icont="\\u2600";
      break;
    case "cloudy":
      $icont="\\u2601";
      break;
    case "rain":
      $icont="\\u2614";
      break;
    case "partlycloudy":
      $icont="\\u26c5";
      break;
  }
  
   $icont = preg_replace("/\\\\u([0-9a-fA-F]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", $icont);

  echo 'Condizioni: '.$condizione." ".$icont."\r\n";
  echo 'Temperatura: '.$temp."° C\r\n";
  echo 'Umidità: '.$umidita."\r\n";
?>
