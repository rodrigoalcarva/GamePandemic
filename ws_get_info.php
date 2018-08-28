<?php
  require_once "lib/nusoap.php";

  function infoJogo($ID) {
    include "phpScripts/accessBD.php";
    $infoToReturn = array();

    $infoQuery = "SELECT * FROM GameState WHERE ID = $ID";
    $getInfo = mysqli_query($conn, $infoQuery) or die("$infoQuery failed");

    if(mysqli_num_rows($getInfo) > 0) {
      $row = mysqli_fetch_array($getInfo);
      $roomName = $row['roomName'];

      $numPlayersQuery = "SELECT numAtuaisJog FROM Rooms WHERE nome = '$roomName'";
      $getNumPlayers = mysqli_query($conn, $numPlayersQuery) or die("$numPlayersQuery failed");

      $numPlayers = mysqli_fetch_array($getNumPlayers)["numAtuaisJog"];

      array_push($infoToReturn, $numPlayers);

      $allDiseases = array_merge(explode("/", $row["diseaseYellow"]), explode("/", $row["diseaseBlue"]), explode("/", $row["diseaseRed"]), explode("/", $row["diseaseBlack"]));
      $allPlayers = array($row["player1City"], $row["player2City"], $row["player3City"], $row["player4City"]);
      $allPlayersCities = array();


      array_push($infoToReturn, $allDiseases);


      foreach ($allPlayers as $playerCity) {
        $citiesQuery = "SELECT * FROM Cities WHERE mainCity = '$playerCity'";
        $getCities = mysqli_query($conn, $citiesQuery) or die("$citiesQuery failed");

        $allCitiesRow = mysqli_fetch_array($getCities);

        array_push($allPlayersCities, $allCitiesRow);
      }

      array_push($infoToReturn, $allPlayersCities);

      array_push($infoToReturn, explode("/", $row["researchCenter"]));

      return $infoToReturn;
    }

    else {
      return "Sala nao existe";
    }
  }

  $server = new soap_server();
  $server->register("infoJogo", // nome metodo
                    array('nome' => 'xsd:string'), // input
                    array('return' => 'xsd:string'), // output
                    'uri:cumpwsdl', // namespace
                    'urn:cumpwsdl#infoJogo', // SOAPAction
                    'rpc', // estilo
                    'encoded' // uso
                    );

  $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
  $server->service($HTTP_RAW_POST_DATA);
?>
