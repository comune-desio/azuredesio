<?php
  require __DIR__."/../vendor/autoload.php";

  $dotenv = new Dotenv\Dotenv(__DIR__, "../_env");
  $dotenv->load();

  $token = getenv("WUNDERGROUND_API_TOKEN");
  $meteo = file_get_contents("http://api.wunderground.com/api/${token}/conditions/lang:IT/q/Italy/Desio.json");

  $json = json_decode($meteo, true);
  $condizione = $json["current_observation"]["weather"];
  $temp = $json["current_observation"]["temp_c"];
  $umidita = $json["current_observation"]["relative_humidity"];
  $icon = $json["current_observation"]["icon"];


  $unicode_mapping = [
    "sole" => "\\u2600",
    "parzialmente nuvoloso" => "\\u26c5",
    "nuvoloso" => "\\u2601",
    "temporale" => "\\u26a1",
    "pioggia" => "\\u2614",
    "neve" => "\\u2744"
  ];
  $icon_mapping = [
    "clear" => $unicode_mapping["sole"],
    "sunny" => $unicode_mapping["sole"],
    "cloudy" => $unicode_mapping["nuvoloso"],
    "rain" => $unicode_mapping["pioggia"],
    "partlycloudy" => $unicode_mapping["parzalmente nuvoloso"]
  ];
  $icont = $icon_mapping[$icon];
  // TODO: handle when $icon is not a valid key

   $icont = preg_replace("/\\\\u([0-9a-fA-F]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", $icont);

  echo "Condizioni: ${condizione} ${icont}\r\n";
  echo "Temperatura: ${temp}° C\r\n";
  echo "Umidità: ${umidita}\r\n";
?>
