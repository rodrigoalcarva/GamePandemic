<?php
require_once "lib/nusoap.php";

$client = new nusoap_client('http://appserver-01.alunos.di.fc.ul.pt/~asw002/Pandemic/ws_get_info.php');

$error = $client->getError();
$result = $client->call('infoJogo', array('ID' => 0));

$showedCities = array();

if ($result == "Sala nao existe") {
  echo "$result \n";
}

else {
  echo "Cidades infetadas: \n";

  foreach ($result[1] as $el) {
    if (!in_array($el, $showedCities) && strlen($el)) {
      array_push($showedCities, $el);
      echo "$el \n" ;
    }
  }

  $numP = 1;

  echo "\n";
  echo "Jogadores: \n \n";

  for ($i=0; $i < $result[0]; $i++) {
    $playerCityShowed = array();

    echo "Jogador $numP \n";
    $numP ++;

    foreach ($result[2][$i] as $city) {
      if (!in_array($city, $playerCityShowed) && strlen($city)) {
        array_push($playerCityShowed, $city);
        echo "$city \n";
      }
    }
    echo "\n";
  }

  echo "\n";

  echo "Centros: \n";
  foreach ($result[3] as $center) {
    echo "$center \n";
  }
}
?>
