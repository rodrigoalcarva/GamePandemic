<?php
  require_once "lib/nusoap.php";

  function fazJogada($ID, $username, $password, $jogada, $cidade = none) {
    include "phpScripts/accessBD.php";

    $loginQuery = "SELECT * FROM Users WHERE username = '$username'";
    $getLogin = mysqli_query($conn, $loginQuery) or die("Nao aceite");

    $loginRow = mysqli_fetch_array($getLogin);

    $hashed_password = sha1($password);


    //check password
    if ($hashed_password == $loginRow["password"]) {
      $players = array();

      $gameQuery = "SELECT * FROM GameState WHERE ID = $ID";
      $getGame = mysqli_query($conn, $gameQuery) or die("Nao aceite");

      $gameRow = mysqli_fetch_array($getGame);
      $roomName = $gameRow["roomName"];

      //check if current player
      if ($gameRow["currentPlayer"] == $username) {
        $playersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$roomName'";

        $getPlayers = mysqli_query($conn, $playersQuery) or die("Nao aceite");

        while ($playersRow = mysqli_fetch_array($getPlayers)) {
          array_push($players, $playersRow['userName']);
        }

        $player = array_search($username, $players);
        $currentPlayerCity = "player" . ($player + 1) . "City";
        $currentPlayerCards = "player" . ($player + 1) . "Cards";

        $currentCity = $gameRow[$currentPlayerCity];
        $currentCards = explode("/", $gameRow[$currentPlayerCards]);
        $diseaseYellow = explode("/", $gameRow['diseaseYellow']);
        $diseaseBlue = explode("/", $gameRow['diseaseBlue']);
        $diseaseRed = explode("/", $gameRow['diseaseRed']);
        $diseaseBlack = explode("/", $gameRow['diseaseBlack']);
        $currentCenter = $gameRow["researchCenter"];

        if (strlen($gameRow["usedPlayerCards"]) == 0) {
          $usedPlayerCards = array();
        }

        else {
          $usedPlayerCards = explode("/", $gameRow["usedPlayerCards"]);
        }

        if ($gameRow['numPlays'] < 4) {
          if ($jogada == "move") {
            $citiesQuery = "SELECT city0, city1, city2, city3, city4, city5 FROM Cities WHERE mainCity = '$currentCity'";

            $getCities = mysqli_query($conn, $citiesQuery) or die("Nao aceite");

            $citiesRow = mysqli_fetch_array($getCities);

            $connectedCities = array($citiesRow['city0'], $citiesRow['city1'], $citiesRow['city2'], $citiesRow['city3'], $citiesRow['city4'], $citiesRow['city5']);

            if (in_array($cidade, $connectedCities)) {
              $updateQuery = "UPDATE GameState
                              SET $currentPlayerCity = '$cidade',
                              numPlays = numPlays + 1
                              WHERE roomName = '$roomName'";

              $update = mysqli_query($conn, $updateQuery) or die("Nao aceite");

              return "Aceite";
            }

            else
              return "Nao aceite";
          }

          else if ($jogada == "treat") {
            $roleQuery = "SELECT rolePlayer FROM RoomPlayers WHERE userName = '$username'";

            $getCurrentRole = mysqli_query($conn, $roleQuery) or die("Nao aceite");

            $currentRole = mysqli_fetch_array($getCurrentRole)["rolePlayer"];

            $toSet = "";

            //doenca amarela
            if (in_array($currentCity, $diseaseYellow)) {
              if ($currentRole == "medico") {
                while (in_array($currentCity, $diseaseYellow)) {
                  unset($diseaseYellow[array_search($currentCity, $diseaseYellow)]);
                }
              }

              else
                unset($diseaseYellow[array_search($currentCity, $diseaseYellow)]);

              $finalDiseaseYellow = implode("/", $diseaseYellow);

              $toSet = "SET diseaseYellow = '$finalDiseaseYellow'";
            }

            //doenca azul
            else if (in_array($currentCity, $diseaseBlue)) {
              if ($currentRole == "medico") {
                while (in_array($currentCity, $diseaseBlue)) {
                  unset($diseaseBlue[array_search($currentCity, $diseaseBlue)]);
                }
              }

              else
                unset($diseaseBlue[array_search($currentCity, $diseaseBlue)]);

              $finalDiseaseBlue = implode("/", $diseaseBlue);

              $toSet = "SET diseaseBlue = '$finalDiseaseBlue'";
            }

            //doenca vermelha
            else if (in_array($currentCity, $diseaseRed)) {
              if ($currentRole == "medico") {
                while (in_array($currentCity, $diseaseRed)) {
                  unset($diseaseRed[array_search($currentCity, $diseaseRed)]);
                }
              }

              else
                unset($diseaseRed[array_search($currentCity, $diseaseRed)]);

              $finalDiseaseRed = implode("/", $diseaseRed);

              $toSet = "SET diseaseRed = '$finalDiseaseRed'";
            }

            if (strlen($toSet)) {
              $updateQuery = "UPDATE GameState " . $toSet . ", numPlays = numPlays + 1 WHERE roomName = '$roomName'";

              $update = mysqli_query($conn, $updateQuery) or die("Nao aceite");

              return "Aceite";
            }

            else
              return "Nao aceite";
          }

          else if ($jogada == "create") {
            if (in_array($currentCity, $currentCards)) {
              unset($currentCards[array_search($currentCity, $currentCards)]);
              $finalCurrentCards = implode("/", $currentCards);
              array_push($usedPlayerCards, $currentCity);
              $usedPlayerCardsString = implode("/", $usedPlayerCards);

              $currentCenter = $currentCenter . "/" . $currentCity;

              $updateQuery = "UPDATE GameState
                              SET researchCenter = '$currentCenter',
                              $currentPlayerCards = '$finalCurrentCards',
                              usedPlayerCards = '$usedPlayerCardsString',
                              numPlays = numPlays + 1
                              WHERE roomName = '$roomName'";

              $update = mysqli_query($conn, $updateQuery) or die("Nao aceite");

              return "Aceite";
            }

            else
              return "Nao aceite";
          }
        }
        else
          return "Nao aceite";

      }

      else
        return "Nao aceite";
    }

    else
      return "Nao aceite";
  }

  $server = new soap_server();
  $server->register("fazJogada", // nome metodo
                    array('nome' => 'xsd:string'), // input
                    array('return' => 'xsd:string'), // output
                    'uri:cumpwsdl', // namespace
                    'urn:cumpwsdl#saudacao', // SOAPAction
                    'rpc', // estilo
                    'encoded' // uso
                    );

  $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
  $server->service($HTTP_RAW_POST_DATA);
?>
