<?php
//see players in city
function playerInCity($player1City, $player2City, $player3City, $player4City, $city) {
  if (in_array($city, $player1City))
    echo $player1City[0] . " ";

  if (in_array($city, $player2City))
    echo $player2City[0] . " ";

  if (in_array($city,$player3City))
    echo $player3City[0];

  if (in_array($city, $player4City))
    echo  $player4City[0];
}

//see diseases in city
function diseaseInCity($roomName, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, $city, $tableColor) {
  include "accessBD.php";
  $totalDisease = 0;

  $citiesQuery = "SELECT city0, city1, city2, city3, city4, city5 FROM Cities WHERE mainCity = '$city'";
  $getCities = mysqli_query($conn, $citiesQuery) or die("$citiesQuery failed");

  $allCitiesRow = mysqli_fetch_array($getCities);

  $yellowNum = array_count_values($diseaseYellow)[$city];
  $blueNum = array_count_values($diseaseBlue)[$city];
  $redNum = array_count_values($diseaseRed)[$city];
  $blackNum = array_count_values($diseaseBlack)[$city];

  //Cidades
  $yellowCities = array("Bogota", "Buenos Aires", "Cidade Do Mexico", "Khartoum", "Kinshasa", "Joanesburgo", "Lagos", "Lima", "Los Angeles", "Miami", "Santiago", "Sao Paulo");
  $blueCities = array("Atlanta", "Chicago", "Essen", "Londres", "Madrid", "Milao", "Montreal", "Nova Iorque", "Paris", "Sao Francisco", "Sao Petersburgo", "Washington");
  $redCities = array("Banguecoque","Beijing","Ho Chi Minh City","Hong Kong","Jakarta","Manila","Osaka","Seoul","Shangai","Sydney","Taipei","Tokyo");
  $blackCities = array("Argel","Baghdad","Cairo","Chennai","Deli","Istambul","Karachi","Kolkota","Moscovo","Mumbai","Riade","Tehran");

  if (in_array($city, $diseaseYellow)) {
    $totalDisease += $yellowNum;
  }

  if (in_array($city, $diseaseBlue)) {
    $totalDisease += $blueNum;
  }

  if (in_array($city,$diseaseRed)) {
    $totalDisease += $redNum;
  }

  if (in_array($city,$diseaseBlack)) {
    $totalDisease += $blackNum;

  }

  if ($totalDisease > 0) {
    echo $tableColor . '-' . $totalDisease . 'x';
  }

  if ($totalDisease > 3) {
    while ($totalDisease > 3) {
      if (in_array($city, $diseaseYellow)) {
        unset($diseaseYellow[array_search($city, $diseaseYellow)]);
      }

      if (in_array($city, $diseaseBlue)) {
        unset($diseaseBlue[array_search($city, $diseaseBlue)]);
      }

      if (in_array($city, $diseaseRed)) {
        unset($diseaseRed[array_search($city, $diseaseRed)]);
      }

      if (in_array($city, $diseaseBlack)) {
        unset($diseaseBlack[array_search($city, $diseaseBlack)]);
      }

      $totalDisease --;
    }

    foreach ($allCitiesRow as $el) {
      if (isset($el)) {
        if (in_array($el, $yellowCities) && array_count_values($diseaseYellow)[$el] < 3)
          array_push($diseaseYellow, $el);

        if (in_array($el, $blueCities) && array_count_values($diseaseBlue)[$el] < 3)
          array_push($diseaseBlue, $el);

        if (in_array($el, $redCities) && array_count_values($diseaseRed)[$el] < 3)
          array_push($diseaseRed, $el);

        if (in_array($el, $blackCities) && array_count_values($diseaseBlack)[$el] < 3)
          array_push($diseaseBlack, $el);
      }
    }

    $diseaseYellowString = implode("/", array_slice($diseaseYellow, 1));
    $diseaseBlueString = implode("/", array_slice($diseaseBlue, 1));
    $diseaseRedString = implode("/", array_slice($diseaseRed, 1));
    $diseaseBlackString = implode("/", array_slice($diseaseBlack, 1));

    $updateQuery = "UPDATE GameState
                    SET diseaseYellow = '$diseaseYellowString',
                    diseaseBlue = '$diseaseBlueString',
                    diseaseRed = '$diseaseRedString',
                    diseaseBlack = '$diseaseBlackString',
                    outbreaks = outbreaks + 1
                    WHERE roomName = '$roomName'";

    $update = mysqli_query($conn, $updateQuery) or die("Error, update query failed:" . $updateQuery);
  }
}

//see research center in city
function researchInCity($researchCenter,$city){
  if (in_array($city, $researchCenter))
    echo "Criado";
}

//see player cards
function playerCards($player1Cards,$player2Cards,$player3Cards,$player4Cards, $player){
  if ($player == $player1Cards[0])
    echo implode(array_slice($player1Cards, 1), "<br>");

  if ($player == $player2Cards[0])
    echo implode(array_slice($player2Cards, 1), "<br>");

  if ($player == $player3Cards[0])
    echo implode(array_slice($player3Cards, 1), "<br>");

  if ($player == $player4Cards[0])
    echo implode(array_slice($player4Cards, 1), "<br>");
}

function seeCured($doenca,$roomName){
    include "accessBD.php";
    $seeDiseasesCured = "SELECT curedYellow, curedBlue,curedRed, curedBlack FROM GameState WHERE roomName = '$roomName'";
    $getDiseasesCured = mysqli_query($conn, $seeDiseasesCured);

    if(!$getDiseasesCured)
      die("Error, select query failed:" . $seeDiseasesCured);

    if(mysqli_num_rows($getDiseasesCured) > 0) {
      $row = mysqli_fetch_array($getDiseasesCured);

      if($row["curedYellow"] == "sim" && $doenca == "yellow"){
        echo "class = 'diseaseCured'";
      }

      if($row["curedBlue"] == "sim" && $doenca == "blue"){
        echo "class = 'diseaseCured'";
      }

      if($row["curedRed"] == "sim" && $doenca == "red"){
        echo "class = 'diseaseCured'";
      }

      if($row["curedBlack"] == "sim" && $doenca == "black"){
        echo "class = 'diseaseCured'";
      }
    }
}
?>
