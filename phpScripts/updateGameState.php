<?php
  include "accessBD.php";
  session_start();
  $roomName = $_GET["roomName"];
  $response = array();
  $playersName = array();
  $players = array();

  if (isset($roomName)) {
    $getPlayersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$roomName'";
    $getPlayers = mysqli_query($conn, $getPlayersQuery);

    if(!$getPlayers)
      die("Error, select query failed:" . $getPlayersQuery);

    if(mysqli_num_rows($getPlayers)>0) {
      while ($player = mysqli_fetch_array($getPlayers)["userName"]) {
        array_push($playersName, $player);
      }
    }

    $getGameQuery = "SELECT * FROM GameState WHERE roomName = '$roomName'";
    $getGame= mysqli_query($conn, $getGameQuery) or die("Error, select query failed:" . $getGameQuery);

    if(mysqli_num_rows($getGame)>0) {
      $row = mysqli_fetch_array($getGame);

      //update players
      $playersCities = array($row["player1City"], $row["player2City"], $row["player3City"], $row["player4City"]);

      for ($i=0; $i < sizeof($playersName); $i++) {
        $players[$playersName[$i]] = $playersCities[$i];
      }

      array_push($response, $players);

      // update disease
      $totalDisease = 0;
      $diseaseYellow = explode("/", $row["diseaseYellow"]);
      $diseaseBlue = explode("/", $row["diseaseBlue"]);
      $diseaseRed = explode("/", $row["diseaseRed"]);
      $diseaseBlack = explode("/", $row["diseaseBlack"]);
      $allCitiesDiseases = array_merge($diseaseYellow, $diseaseBlue);
      $allCitiesDiseases = array_merge($allCitiesDiseases, $diseaseRed);
      $allCitiesDiseases = array_merge($allCitiesDiseases, $diseaseBlack);

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

      foreach ($allCitiesDiseases as $city) {
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

      $newDiseaseQuery = "SELECT * FROM GameState WHERE roomName = '$roomName'";
      $getNewDisease= mysqli_query($conn, $newDiseaseQuery) or die("Error, select query failed:" . $newDiseaseQuery);

      $newDiseaseRow = mysqli_fetch_array($getNewDisease);

      $diseases = array($row["diseaseYellow"], $row["diseaseBlue"], $row["diseaseRed"], $row["diseaseBlack"]);

      array_push($response, $diseases);

      //update centers
      array_push($response, $row["researchCenter"]);

      //update turn
      if ($_SESSION["username"] == $row["currentPlayer"]) {
        array_push($response, True);
      }

      else {
        array_push($response, False);
      }

      //update player cards
      $currentPlayer = array_search($_SESSION["username"], array_keys($players));
      $currentPlayerCards = "player" . ($currentPlayer + 1) . "Cards";
      $currentCards = $row[$currentPlayerCards];

      array_push($response, $currentCards);

      //update infection speed
      array_push($response, $row["speedInfection"]);

      //update player cards
      $otherPlayersCards = array();

      if ($row["player1Cards"] != "" &&  $currentPlayerCards != "player1Cards")
        array_push($otherPlayersCards, explode("/", $row["player1Cards"]));

      if ($row["player2Cards"] != "" &&  $currentPlayerCards != "player2Cards")
        array_push($otherPlayersCards, explode("/", $row["player2Cards"]));

      if ($row["player3Cards"] != "" &&  $currentPlayerCards != "player3Cards")
        array_push($otherPlayersCards, explode("/", $row["player3Cards"]));

      if ($row["player4Cards"] != "" &&  $currentPlayerCards != "player4Cards")
        array_push($otherPlayersCards, explode("/", $row["player4Cards"]));

      array_push($response, $otherPlayersCards);
    }

    //ends game
    if ($row["curedYellow"] == "sim" && $row["curedBlue"] == "sim" && $row["curedRed"] == "sim" && $row["curedBlack"] == "sim" || sizeof($currentDiscardedCards) > 46 || $row["outbreaks"] >= 8) {
      if (sizeof($currentDiscardedCards) > 46 || $row["outbreaks"] >= 8) {
				$_SESSION["messageReceived"] = "Derrota";
			}
			else {
				$_SESSION["messageReceived"] = "Vitória";
			}

			//Apaga jogadores
			$removePlayerRoomQuery = "DELETE FROM RoomPlayers
 	  									          WHERE roomName = '$roomName'";

 	    $removePlayerRoom = mysqli_query($conn, $removePlayerRoomQuery);

	    if(!$removePlayerRoom)
	  		die("Error, delete query failed:" . $removePlayerRoomQuery);

			//Get informacao da sala
      $getRoomQuery = "SELECT admin, numAtuaisJog FROM Rooms
                       WHERE nome = '$roomName'";

      $getRoom = mysqli_query($conn, $getRoomQuery);

      if(!$getRoom)
         die("Error, delete query failed:" . $getRoomQuery);

      if(mysqli_num_rows($getRoom)>0) {
        $row = mysqli_fetch_array($getRoom);
        $admin = $row["admin"];
        $numPlayers = $row["numAtuaisJog"];
        $description = $row["description"];
      }

			//Apaga sala
			$removeRoomQuery = "DELETE FROM Rooms
                      		WHERE nome = '$roomName'";

      $removeRoom = mysqli_query($conn, $removeRoomQuery);

      if(!$removeRoom)
         die("Error, delete query failed:" . $removeRoomQuery);

			//Apaga game state
			$removeGameStateQuery = "DELETE FROM GameState
	                     				 WHERE roomName = '$roomName'";

	    $removeGameState = mysqli_query($conn, $removeGameStateQuery);

	    if(!$removeGameState)
	    	die("Error, delete query failed:" . $removeGameStateQuery);

			$usedPlayerCardsString = implode("/", $currentDiscardedCards);
      $usedInfectionCardsString = implode("/", $usedInfectionCards);

			$addFinishedGameQuery = "INSERT INTO FinishedGames (name, admin, numPlayers, descricao, usedPlayerCards, usedDiseaseCards)
                               VALUES ('$roomName', '$admin', '$numPlayers', '$description', '$usedPlayerCardsString', '$usedInfectionCardsString')";

	    $addFinishedGame = mysqli_query($conn, $addFinishedGameQuery);

	    if(!$addFinishedGame)
	    	die("Error, delete query failed:" . $addFinishedGameQuery);

			echo json_encode("finish");
		}

    else {
      echo json_encode($response);
    }
  }
?>
