<?php
  include "accessBD.php";
  include "seeGameState.php";
  session_start();
  $roomName = $_GET["room"];
  $seeCity = $_GET["seeCity"];
  $moveTo = $_GET["moveTo"];
  $createCenter = $_GET["createCenter"];
  $cure = $_GET["cure"];
  $trata = $_GET["trata"];
  $pass = $_GET["pass"];
  $currentPlayer = $_GET["currentPlayer"];
  $giveUp = $_GET["giveUp"];
  $seeShare = $_GET["seeShare"];
  $shareWith = $_GET["shareWith"];
  $moveAllCities = $_GET["allCities"];

  //Cidades
  $yellowCities = array("Bogota", "Buenos Aires", "Cidade Do Mexico", "Khartoum", "Kinshasa", "Joanesburgo", "Lagos", "Lima", "Los Angeles", "Miami", "Santiago", "Sao Paulo");
  $blueCities = array("Atlanta", "Chicago", "Essen", "Londres", "Madrid", "Milao", "Montreal", "Nova Iorque", "Paris", "Sao Francisco", "Sao Petersburgo", "Washington");
  $redCities = array("Banguecoque","Beijing","Ho Chi Minh City","Hong Kong","Jakarta","Manila","Osaka","Seoul","Shangai","Sydney","Taipei","Tokyo");
  $blackCities = array("Argel","Baghdad","Cairo","Chennai","Deli","Istambul","Karachi","Kolkota","Moscovo","Mumbai","Riade","Tehran");

  //Baralho com doenca;
  $allCities = array_merge($yellowCities, $blueCities, $redCities, $blackCities);

  $diseasesCities = array_merge($yellowCities, $blueCities, $redCities, $blackCities);

  $players = array();

  $playersQuery = "SELECT userName
                   FROM RoomPlayers
                   WHERE roomName = '$roomName'";

  $getPlayers = mysqli_query($conn, $playersQuery);

  if(!$getPlayers)
    die("Error, select query failed:" . $playersQuery);

  if(mysqli_num_rows($getPlayers)>0) {
    while ($row = mysqli_fetch_array($getPlayers)) {
      array_push($players, $row['userName']);
    }
  }

  $currentPlayerQuery = "SELECT *
                      FROM GameState
                      WHERE roomName = '$roomName'";

  $getCurrentPlayer = mysqli_query($conn, $currentPlayerQuery) or die("Error, select query failed:" . $currentPlayerQuery);


  if(mysqli_num_rows($getCurrentPlayer)>0) {
    $row = mysqli_fetch_array($getCurrentPlayer);
    $currentPlayerName = $row["currentPlayer"];
    $currentPlayer = array_search($currentPlayerName, $players);
    $currentPlayerCity = "player" . ($currentPlayer + 1) . "City";
    $currentPlayerCards = "player" . ($currentPlayer + 1) . "Cards";

    $currentCity = $row[$currentPlayerCity];
    $currentCards = explode("/", $row[$currentPlayerCards]);
    $currentCenter = $row["researchCenter"];

    if (strlen($row["usedPlayerCards"]) == 0) {
      $usedPlayerCards = array();
    }

    else {
      $usedPlayerCards = explode("/", $row["usedPlayerCards"]);
    }

    $numPlays = $row["numPlays"];
    $speedInfection = $row["speedInfection"];
    $diseaseYellow = explode("/", $row['diseaseYellow']);
    $diseaseBlue = explode("/", $row['diseaseBlue']);
    $diseaseRed = explode("/", $row['diseaseRed']);
    $diseaseBlack = explode("/", $row['diseaseBlack']);
    $usedInfectionCards = explode("/", $row['usedInfectionCards']);
  }

  $currentRoleQuery = "SELECT rolePlayer FROM RoomPlayers WHERE userName = '$currentPlayerName'";
  $getCurrentRole = mysqli_query($conn, $currentRoleQuery) or die("Error, select query failed:" . $currentRoleQuery);;

  $currentRole = mysqli_fetch_array($getCurrentRole)["rolePlayer"];

  if ($numPlays == 4 && !isset($pass)) {
    echo json_encode("Numero maximo de jogadas");
    exit();
  }

  //ver cidades possiveis
  if (isset($seeCity)) {

    if ($seeCity == "all") {
      if (in_array($currentCity, $currentCards)) {
        echo json_encode($allCities);
      }
      else {
        echo json_encode("Sem carta de cidade");
      }
    }

    else {
      $connectedCitiesQuery = "SELECT city0, city1, city2, city3, city4, city5
                          FROM Cities
                          WHERE mainCity = '$currentCity'";

      $getConnectedCities = mysqli_query($conn, $connectedCitiesQuery);

    	if(!$getConnectedCities)
    		die("Error, select query failed:" . $connectedCitiesQuery);

    	if(mysqli_num_rows($getConnectedCities)>0) {
        $row = mysqli_fetch_array($getConnectedCities);
        $conectCities = [$row['city0'], $row['city1'], $row['city2'], $row['city3'], $row['city4'], $row['city5']];

        $allCities = array_merge($conectCities, $currentCards, explode("/", $currentCenter));

        $allCitiesFinal = array();

        foreach ($allCities as $el) {
          if (strlen($el) > 0 && !in_array($el, $allCitiesFinal) && $el != $currentCity)
            array_push($allCitiesFinal, $el);
        }
        echo json_encode($allCitiesFinal);
    	}
    }
  }

  //Mover para cidade
  if (isset($moveTo)) {
    $connectedCitiesQuery = "SELECT city0, city1, city2, city3, city4, city5
                        FROM Cities
                        WHERE mainCity = '$currentCity'";

    $getConnectedCities = mysqli_query($conn, $connectedCitiesQuery);

  	if(!$getConnectedCities)
  		die("Error, select query failed:" . $connectedCitiesQuery);

  	if(mysqli_num_rows($getConnectedCities)>0) {
      $row = mysqli_fetch_array($getConnectedCities);
      $conectCities = [$row['city0'], $row['city1'], $row['city2'], $row['city3'], $row['city4'], $row['city5']];
    }

    if (isset($moveAllCities)) {
      unset($currentCards[array_search($currentCity, $currentCards)]);
      $finalCurrentCards = implode("/", $currentCards);
      array_push($usedPlayerCards, $currentCity);
      $usedPlayerCardsString = implode("/", $usedPlayerCards);

      $updateQuery = "UPDATE GameState
                      SET $currentPlayerCity = '$moveTo',
                      numPlays = numPlays + 1,
                      $currentPlayerCards = '$finalCurrentCards',
                      usedPlayerCards = '$usedPlayerCardsString'
                      WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);

      echo json_encode("carta de atual cidade gasta");
    }

    else if (in_array($moveTo, $conectCities)) {
      $updateQuery = "UPDATE GameState
                      SET $currentPlayerCity = '$moveTo',
                      numPlays = numPlays + 1
                      WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);

      echo json_encode("cidade conectada");
    }

    else if (in_array($moveTo, $currentCards)) {
      unset($currentCards[array_search($moveTo, $currentCards)]);
      $finalCurrentCards = implode("/", $currentCards);
      array_push($usedPlayerCards, $moveTo);
      $usedPlayerCardsString = implode("/", $usedPlayerCards);

      $updateQuery = "UPDATE GameState
                      SET $currentPlayerCity = '$moveTo',
                      $currentPlayerCards = '$finalCurrentCards',
                      usedPlayerCards = '$usedPlayerCardsString',
                      numPlays = numPlays + 1
                      WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);


      echo json_encode("usada carta da cidade");
    }
  }

  //Criar centro
  if (isset($createCenter)) {
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

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);

      echo json_encode("criou centro");
    }

    else {
      echo json_encode("não da para criar centro");
    }
  }

  //Curar doença
  if (isset($cure)) {
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

    //doenca preta
    else if (in_array($currentCity, $diseaseBlack)) {
      if ($currentRole == "medico") {
        while (in_array($currentCity, $diseaseBlack)) {
          unset($diseaseBlack[array_search($currentCity, $diseaseBlack)]);
        }
      }

      else
        unset($diseaseBlack[array_search($currentCity, $diseaseBlack)]);

      $finalDiseaseYellow = implode("/", $diseaseBlack);

      $toSet = "SET diseaseBlack = '$finalDiseaseBlack'";
    }

    if (strlen($toSet)) {
      $updateQuery = "UPDATE GameState " . $toSet . ", numPlays = numPlays + 1 WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);

      echo json_encode("removido 1 cubo de doenca");
    }

    else {
      echo json_encode("Impossivel remover");
    }
  }

  //Trata doenca
  if (isset($trata)) {
    $trataYellow = 0;
    $trataBlue = 0;
    $trataRed = 0;
    $trataBlack = 0;

    foreach ($currentCards as $el) {
      if (in_array($el, $yellowCities) && $trataYellow < 5) {
        $trataYellow ++;
      }

      if (in_array($el, $blueCities) && $trataBlue < 5) {
        $trataBlue ++;
      }

      if (in_array($el, $redCities) && $trataRed < 5) {
        $trataRed ++;
      }

      if (in_array($el, $blackCities) && $trataBlack < 5) {
        $trataBlack ++;
      }
    }

    $trata = "";
    $doenca = "";

    if ($trataYellow == 5  || ($trataYellow == 4 && $currentRole == "cientista")) {
      $toSet = "SET curedYellow = 'sim', ";
      $possibleCure = True;
      $trata = $yellowCities;
      $doenca = 'yellow';
    }

    else if ($trataBlue == 5 || ($trataYellow == 4 && $currentRole == "cientista")) {
      $toSet = "SET curedBlue = 'sim', ";
      $possibleCure = True;
      $trata = $blueCities;
      $doenca = 'blue';
    }

    else if ($trataRed == 5 || ($trataYellow == 4 && $currentRole == "cientista")) {
      $toSet = "SET curedRed = 'sim', ";
      $possibleCure = True;
      $trata = $redCities;
      $doenca = 'red';
    }

    else if ($trataBlack == 5 || ($trataYellow == 4 && $currentRole == "cientista")) {
      $toSet = "SET curedBlack = 'sim', ";
      $possibleCure = True;
      $trata = $blackCities;
      $doenca = 'black';
    }

    if ($possibleCure) {
      foreach ($currentCards as $el) {
        if (in_array($el, $trata)) {
          unset($currentCards[array_search($el, $currentCards)]);
          array_push($usedPlayerCards, $el);
        }
      }
      $usedPlayerCardsString = implode("/", $usedPlayerCards);

      $finalCurrentCards = implode("/", $currentCards);

      $updateQuery = "UPDATE GameState " .
                      $toSet .
                      "$currentPlayerCards = '$finalCurrentCards',
                      usedPlayerCards = '$usedPlayerCardsString',
                      numPlays = numPlays + 1
                      WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);

      echo json_encode("Descoberta cura para a doença $doenca");
    }

    else {
      echo json_encode("sem cartas necessarias");
    }
  }

  //see possible players to share
  if (isset($seeShare)) {
    $playerCitiesQuery = "SELECT player1City, player2City, player3City, player4City
                            FROM GameState
                            WHERE roomName= '$roomName'";

    $getplayerCities = mysqli_query($conn, $playerCitiesQuery);

  	if(!$getplayerCities)
  		die("Error, select query failed:" . $playerCitiesQuery);

  	if(mysqli_num_rows($getplayerCities)>0) {
      $row = mysqli_fetch_array($getplayerCities);

      $playerCities = array($row['player1City'], $row['player2City'], $row['player3City'], $row['player4City']);
      $playerCities = array_slice($playerCities,0 , sizeof($players));
      $playerCitiesFinal = array();

      for ($i=0; $i < sizeof($playerCities); $i++) {
        if ($playerCities[$i] == $currentCity && $players[$i] != $players[$currentPlayer]) {
          array_push($playerCitiesFinal, $players[$i]);
        }
      }

      echo json_encode($playerCitiesFinal);
  	}
  }

  //Share with player
  if (isset($shareWith)) {
    if (in_array($currentCity, $currentCards)) {
      $playerToShareCards = "player" . (array_search($shareWith, $players) + 1) . "Cards";

      $playerToShareQuery = "SELECT $playerToShareCards
                          FROM GameState
                          WHERE roomName = '$roomName'";

      $getPlayerToShare = mysqli_query($conn, $playerToShareQuery);

      if(!$getPlayerToShare)
        die("Error, select query failed:" . $playerToShareQuery);


      if(mysqli_num_rows($getPlayerToShare)>0) {
        $row = mysqli_fetch_array($getPlayerToShare);

        $playerCards = explode("/", $row[$playerToShareCards]);

        array_push($playerCards, $currentCity);

        $currentCityCard = array_search($currentCity, $currentCards);

        unset($currentCards[$currentCityCard]);

        $currentCardsString = implode("/", $currentCards);
        $playerCardsString = implode("/", $playerCards);

        $updateQuery = "UPDATE GameState
                        SET $playerToShareCards = '$playerCardsString',
                        $currentPlayerCards = '$currentCardsString',
                        numPlays = numPlays + 1
                        WHERE roomName = '$roomName'";

        $update = mysqli_query($conn, $updateQuery);

        if(!$update)
           die("Error, select query failed:" . $updateQuery);
        }

        echo json_encode("Carta partilhada");
      }

    else {
      echo json_encode("Não tem carta da cidade");
      }
  }

  //end turn
  if (isset($pass)) {
    if (sizeof($currentCards) >= 6 ) {
      array_splice($currentCards, 0, 1);
      array_splice($currentCards, 1, 1);
    }

    //tirar cartas
    $currentCardsString = implode("/", array_merge(giveCards($allCities, 2, $roomName), $currentCards));

    $speedInfectionQuery = "SELECT speedInfection
                            FROM GameState
                            WHERE roomName = '$roomName'";

    $getSpeedInfection = mysqli_query($conn, $speedInfectionQuery) or die("Error, select query failed:" . $cityDiseaseQuery);

    $updatedSpeedInfection = mysqli_fetch_array($getSpeedInfection)["speedInfection"];

    //espalhar doenca
    $citiesInf = infectCities($diseasesCities, $speedInfection, 1);

    $diseaseYellowString = implode("/", array_merge($citiesInf["diseaseYellow"], $diseaseYellow));
    $diseaseBlueString = implode("/", array_merge($citiesInf["diseaseBlue"], $diseaseBlue));
    $diseaseRedString = implode("/", array_merge($citiesInf["diseaseRed"], $diseaseRed));
    $diseaseBlackString = implode("/", array_merge($citiesInf["diseaseBlack"], $diseaseBlack));

    if ($updatedSpeedInfection > $speedInfection)
      $usedInfectionCardsString = "";

    else
      $usedInfectionCardsString = implode("/", $usedInfectionCards);

    //proximo jogador
    $nextPlayer = $players[($currentPlayer + 1) % sizeof($players)];

    $updateQuery = "UPDATE GameState
                    SET currentPlayer = '$nextPlayer',
                    $currentPlayerCards = '$currentCardsString',
                    diseaseYellow = '$diseaseYellowString',
                    diseaseBlue = '$diseaseBlueString',
                    diseaseRed = '$diseaseRedString',
                    diseaseBlack = '$diseaseBlackString' ,
                    usedInfectionCards = '$usedInfectionCardsString',
                    numPlays = 0
                    WHERE roomName = '$roomName'";

    $update = mysqli_query($conn, $updateQuery);

    if(!$update)
       die("Error, select query failed:" . $updateQuery);

    //echo json_encode($nextPlayer);
  }

  //desistir
  if (isset($giveUp)) {
    $sessionPlayer = $_SESSION['username'];
    $usedPlayerCardsString = implode("/", array_merge($usedPlayerCards, $currentCards));
    $currentCardsString = "";

    //remover jogador
    $removePlayerRoomQuery = "DELETE FROM RoomPlayers
  									          WHERE userName = '$sessionPlayer'";

    $removePlayerRoom = mysqli_query($conn, $removePlayerRoomQuery);

    if(!$removePlayerRoom)
  		die("Error, select query failed:" . $removePlayerRoomQuery);

    $updatedPlayers = array();

    $playersQuery = "SELECT userName
                     FROM RoomPlayers
                     WHERE roomName = '$roomName'";

    $getPlayers = mysqli_query($conn, $playersQuery);

    if(!$getPlayers)
      die("Error, select query failed:" . $playersQuery);

    if(mysqli_num_rows($getPlayers)>0) {
      while ($row = mysqli_fetch_array($getPlayers)) {
        array_push($updatedPlayers, $row['userName']);
      }
    }

    if (sizeof($updatedPlayers) < 2) {
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

      $usedPlayerCardsString = implode("/", $usedPlayerCards);
      $usedInfectionCardsString = implode("/", $usedInfectionCards);

      $addFinishedGameQuery = "INSERT INTO FinishedGames (name, admin, numPlayers, descricao, usedPlayerCards, usedDiseaseCards)
                               VALUES ('$roomName', '$admin', '$numPlayers', '$description', '$usedPlayerCardsString', '$usedInfectionCardsString')";

	    $addFinishedGame = mysqli_query($conn, $addFinishedGameQuery);

	    if(!$addFinishedGame)
	    	die("Error, delete query failed:" . $addFinishedGameQuery);
    }

    else {
      if ($currentPlayer ==  $sessionPlayer) {
        //proximo jogador
        $nextPlayer = $updatedPlayers[0];

        $updateQuery = "UPDATE GameState
                        SET currentPlayer = '$nextPlayer',
                        numPlays = 0
                        WHERE roomName = '$roomName'";

        $update = mysqli_query($conn, $updateQuery);

        if(!$update)
           die("Error, select query failed:" . $updateQuery);
      }

      $updateQuery = "UPDATE GameState
                      SET usedPlayerCards = '$usedPlayerCardsString'
                      WHERE roomName = '$roomName'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);


      $currentPlayerQuery = "UPDATE Rooms
                            SET numAtuaisJog = numAtuaisJog - 1
                            WHERE nome = '$roomName'";

      $getCurrentPlayer = mysqli_query($conn, $currentPlayerQuery);
    }
  }

  //see currentPlayer
  if (isset($currentPlayer) && !isset($seeCity) && !isset($moveTo) && !isset($createCenter) && !isset($cure) && !isset($trata) && !isset($pass) && !isset($seeShare) && !isset($shareWith)) {
    $CurrentQuery = "SELECT currentPlayer
                    FROM GameState
                    WHERE roomName = '$roomName'";

    $getCurrent = mysqli_query($conn, $CurrentQuery);

    if(!$getCurrent)
       die("Error, select query failed:" . $CurrentQuery);

    if(mysqli_num_rows($getCurrent)>0) {
      $row = mysqli_fetch_array($getCurrent);
    }
    echo json_encode($row["currentPlayer"]);
  }


  //give cards to player
  function giveCards($cards, $cardsToGive, $roomName) {
    include "accessBD.php";
    session_start();

    global $usedPlayerCards;
    $finalArray = array();
    $cardsGiven = 0;

    if ($speedInfection == 0) {
      $allCards = array_merge($cards, array("Epidemia","Epidemia","Epidemia","Epidemia","Epidemia"));
    }

    if ($speedInfection == 1) {
      $allCards = array_merge($cards, array("Epidemia","Epidemia","Epidemia","Epidemia"));
    }

    if ($speedInfection == 2) {
      $allCards = array_merge($cards, array("Epidemia","Epidemia","Epidemia"));
    }

    if ($speedInfection == 3) {
      $allCards = array_merge($cards, array("Epidemia","Epidemia"));
    }

    if ($speedInfection >= 4) {
      $allCards = array_merge($cards, array());
    }

    while ($cardsGiven < $cardsToGive) {
      $cityToPlace = $allCards[rand(0, sizeof($allCards)-1)];

      if (!in_array($cityToPlace, $usedCards)) {
        if ($cityToPlace == "Epidemia") {
          $cityDiseaseQuery = "SELECT *
                              FROM GameState
                              WHERE roomName = '$roomName'";

          $getcityDisease = mysqli_query($conn, $cityDiseaseQuery);

          if(!$getcityDisease)
            die("Error, select query failed:" . $cityDiseaseQuery);


          if(mysqli_num_rows($getcityDisease)>0) {
            $row = mysqli_fetch_array($getcityDisease);
            $diseaseYellow = explode("/", $row['diseaseYellow']);
            $diseaseBlue = explode("/", $row['diseaseBlue']);
            $diseaseRed = explode("/", $row['diseaseRed']);
            $diseaseBlack = explode("/", $row['diseaseBlack']);
          }

          //infeta cidades
          $turnInfect = infectCities($cards, 1, 3);

          $diseaseYellowString = implode("/", array_merge($turnInfect['diseaseYellow'], $diseaseYellow));
          $diseaseBlueString = implode("/", array_merge($turnInfect['diseaseBlue'], $diseaseBlue));
          $diseaseRedString = implode("/", array_merge($turnInfect['diseaseRed'], $diseaseRed));
          $diseaseBlackString = implode("/", array_merge($turnInfect['diseaseBlack'],  $diseaseBlack));

          $updateEpidemicQuery = "UPDATE GameState
                                  SET speedInfection = speedInfection + 1,
                                  diseaseYellow = '$diseaseYellowString',
                                  diseaseBlue = '$diseaseBlueString',
                                  diseaseRed = '$diseaseRedString',
                                  diseaseBlack = '$diseaseBlackString',
                                  usedInfectionCards = ''
                                  WHERE roomName = '$roomName'";

          $update = mysqli_query($conn, $updateEpidemicQuery);


          if(!$update)
             die("Error, update query failed:" . $updateEpidemicQuery);
        }

        else {
          array_push($usedCards, $cityToPlace);
          array_push($finalArray, $cityToPlace);
        }
        $cardsGiven ++;
      }
    }

    return $finalArray;
  }

  //take infection cards
  function infectCities($cards, $cardsToGive, $levelOfInfection) {
    global $usedInfectionCards, $yellowCities, $blueCities, $redCities, $blackCities;
    $cardsGiven = 0;
    $diseaseYellow = array();
    $diseaseBlue = array();
    $diseaseRed = array();
    $diseaseBlack = array();

    while ($cardsGiven < $cardsToGive) {
      $cityToPlace = $cards[rand(0, sizeof($cards)-1)];

      if (!in_array($cityToPlace, $usedInfectionCards)) {

        //se for amarela
        if (in_array($cityToPlace, $yellowCities)) {
          for ($i=0; $i < $levelOfInfection; $i++) {
            array_push($diseaseYellow, $cityToPlace);
          }
          array_push($usedInfectionCards, $cityToPlace);
          $cardsGiven++;
        }

        //se for azul
        else if (in_array($cityToPlace, $blueCities)) {
          for ($i=0; $i < $levelOfInfection; $i++) {
            array_push($diseaseBlue, $cityToPlace);
          }
          array_push($usedInfectionCards, $cityToPlace);
          $cardsGiven++;
        }

        //se for vermelha
        else if (in_array($cityToPlace, $redCities)) {
          for ($i=0; $i < $levelOfInfection; $i++) {
            array_push($diseaseRed, $cityToPlace);
          }
          array_push($usedInfectionCards, $cityToPlace);
          $cardsGiven++;
        }

        //se for preta
        else if (in_array($cityToPlace, $blackCities)) {
          for ($i=0; $i < $levelOfInfection; $i++) {
            array_push($diseaseBlack, $cityToPlace);
          }
          array_push($usedInfectionCards, $cityToPlace);
          $cardsGiven++;
        }

      }
    }

    $finalArray = array("diseaseYellow" => $diseaseYellow,
                        "diseaseBlue" => $diseaseBlue,
                        "diseaseRed" => $diseaseRed,
                        "diseaseBlack" => $diseaseBlack);
    return $finalArray;
  }
?>
