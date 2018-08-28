<?php
  session_start();
  include "accessBD.php";
  include "gameplay.php";
  $name = $_GET["gameRoom"];
  $adminStart = $_GET["adminStart"];

  $gameRoomQuery = "SELECT * FROM Rooms WHERE nome = '$name'";
  $getGameRoom = mysqli_query($conn, $gameRoomQuery);

  if(!$getGameRoom)
    die("Error, select query failed:" . $gameRoomQuery);

  if(mysqli_num_rows($getGameRoom)>0) {
    $row = mysqli_fetch_array($getGameRoom);
    $atualjog = $row['numAtuaisJog'];
    $maxjog = $row['numMaxJog'];
    $admin = $row['admin'];

    //Mudar status
    $updateStatusQuery = "UPDATE Rooms SET estadoJogo = 'Em_Jogo' WHERE nome='$name'";
    $updateStatus = mysqli_query($conn, $updateStatusQuery);

    if(!$updateStatus)
      die("Error, update query failed:" . $updateStatusQuery);

    if ($adminStart = "sim") {
      $updateTimeQuery = "UPDATE Rooms SET timeToStart = 0 WHERE nome='$name'";
      $updateTime = mysqli_query($conn, $updateTimeQuery);

      if(!$updateTime)
        die("Error, update query failed:" . $updateTimeQuery);
    }
  }

  //Info sobre players
	$playersQuery = "SELECT userName
	 								FROM Users
									WHERE username in (SELECT userName
																		FROM RoomPlayers
																		WHERE roomName = '$name');";

	$getPlayers = mysqli_query($conn, $playersQuery);

	if(!$getPlayers)
		die("Error, select query failed:" . $playersQuery);


  $roomPlayers = array();
  if(mysqli_num_rows($getPlayers)>0) {
    while ($row = mysqli_fetch_array($getPlayers)) {
      array_push($roomPlayers, $row["userName"]);
    }
  }

  // Se nao ha minimo de jogadores
  if($atualjog < 2){
    $removePlayerRoomQuery = "DELETE FROM RoomPlayers
  									          WHERE roomName = '$name'";

    $removePlayerRoom = mysqli_query($conn, $removePlayerRoomQuery);

    if(!$removePlayerRoom)
  		die("Error, select query failed:" . $removePlayerRoomQuery);

    $removeRoomQuery = "DELETE FROM Rooms
                          WHERE nome = '$name'";

    $removeRoom = mysqli_query($conn, $removeRoomQuery);

    if(!$removeRoom)
  		die("Error, select query failed:" . $removeRoomQuery);

    header("location: ../salas.php");
  }

  else {
  	$currentPlayer = $roomPlayers[0];

    if ($_SESSION['username'] == $admin) {
      $startTime = date("h:i");
      $yellowCities = array("Bogota", "Buenos Aires", "Cidade Do Mexico", "Khartoum", "Kinshasa", "Joanesburgo", "Lagos", "Lima", "Los Angeles", "Miami", "Santiago", "Sao paulo");
      $blueCities = array("Atlanta", "Chicago", "Essen", "Londres", "Madrid", "Milao", "Montreal", "Nova Iorque", "Paris", "Sao Francisco", "Sao Petersburgo", "Washington");
      $redCities = array("Banguecoque","Beijing","Ho Chi Minh City","Hong Kong","Jakarta","Manila","Osaka","Seoul","Shangai","Sydney","Taipei","Tokyo");
      $blackCities = array("Argel","Baghdad","Cairo","Chennai","Deli","Istambul","Karachi","Kolkota","Moscovo","Mumbai","Riade","Tehran");
      $allCities = array_merge($yellowCities, $blueCities, $redCities, $blackCities);

      $roles = array("cientista","medico","investigador","especialistaEmOperacao");
      $finalRoleArray = array();

      while (sizeof($finalRoleArray) < 4){
        $rand = rand(0, count($roles) - 1);
        if (!in_array($roles[$rand], $finalRoleArray)){
          array_push($finalRoleArray,$roles[$rand]);
        }
      }

      $playerRole1 = $finalRoleArray[0];
      $playerRole2 = $finalRoleArray[1];
      $playerRole3 = $finalRoleArray[2];
      $playerRole4 = $finalRoleArray[3];

      $player1 = $roomPlayers[0];
      $player2 = $roomPlayers[1];
      $player3 = $roomPlayers[2];
      $player4 = $roomPlayers[3];


      if ($atualjog == 2) {
        $player1CardsString = implode("/", giveCards($allCities, 4, $name));
        $player2CardsString = implode("/", giveCards($allCities, 4, $name));

        $associateRoleQuery = "UPDATE RoomPlayers SET rolePlayer = '$playerRole1' WHERE userName = '$player1' ";
        $associateRole = mysqli_query($conn, $associateRoleQuery);

        $associateRoleQuery1 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole2' WHERE userName = '$player2' ";
        $associateRole1 = mysqli_query($conn, $associateRoleQuery1);
      }

      else if ($atualjog == 3) {
        $player1CardsString = implode("/", giveCards($allCities, 3, $name));
        $player2CardsString = implode("/", giveCards($allCities, 3, $name));
        $player3CardsString = implode("/", giveCards($allCities, 3, $name));

        $associateRoleQuery = "UPDATE RoomPlayers SET rolePlayer = '$playerRole1' WHERE userName = '$player1'";
        $associateRole = mysqli_query($conn, $associateRoleQuery);

        $associateRoleQuery1 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole2' WHERE userName = '$player2'";
        $associateRole1 = mysqli_query($conn, $associateRoleQuery1);

        $associateRoleQuery2 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole3' WHERE userName = '$player3'";
        $associateRole2 = mysqli_query($conn, $associateRoleQuery2);
      }

      else if ($atualjog == 4) {
        $player1CardsString = implode("/", giveCards($allCities, 2, $name));
        $player2CardsString = implode("/", giveCards($allCities, 2, $name));
        $player3CardsString = implode("/", giveCards($allCities, 2, $name));
        $player4CardsString = implode("/", giveCards($allCities, 2, $name));

        $associateRoleQuery = "UPDATE RoomPlayers SET rolePlayer = '$playerRole1' WHERE userName = '$player1'";
        $associateRole = mysqli_query($conn, $associateRoleQuery);

        $associateRoleQuery1 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole2' WHERE userName = '$player2'";
        $associateRole1 = mysqli_query($conn, $associateRoleQuery1);

        $associateRoleQuery2 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole3' WHERE userName = '$player3'";
        $associateRole2 = mysqli_query($conn, $associateRoleQuery2);

        $associateRoleQuery3 = "UPDATE RoomPlayers SET rolePlayer = '$playerRole4' WHERE userName = '$player4'";
        $associateRole3 = mysqli_query($conn, $associateRoleQuery3);
      }

      $usedPlayerCardsString = " ";

      $diseaseYellow = array();
      $diseaseBlue = array();
      $diseaseRed = array();
      $diseaseBlack = array();

      $usedInfectionCards = array();

      $level3Inf = infectCities($diseasesCities, 3, 3);
      $level2Inf = infectCities($diseasesCities, 3, 2);
      $level1Inf = infectCities($diseasesCities, 3, 1);

      $diseaseYellow = array_merge($level3Inf["diseaseYellow"], $level2Inf["diseaseYellow"], $level1Inf["diseaseYellow"]);
      $diseaseBlue = array_merge($level3Inf["diseaseBlue"], $level2Inf["diseaseBlue"], $level1Inf["diseaseBlue"]);
      $diseaseRed = array_merge($level3Inf["diseaseRed"], $level2Inf["diseaseRed"], $level1Inf["diseaseRed"]);
      $diseaseBlack = array_merge($level3Inf["diseaseBlack"], $level2Inf["diseaseBlack"], $level1Inf["diseaseBlack"]);

      $diseaseYellowString = implode("/", $diseaseYellow);
      $diseaseBlueString = implode("/", $diseaseBlue);
      $diseaseRedString = implode("/", $diseaseRed);
      $diseaseBlackString = implode("/", $diseaseBlack);
      $usedInfectionString = implode("/", $usedInfectionCards);

      $addGameQuery = "INSERT INTO GameState (roomName, player1City, player2City, player3City, player4City, player1Cards, player2Cards, player3Cards, player4Cards, diseaseYellow, diseaseBlue, diseaseRed, diseaseBlack,currentPlayer, researchCenter, speedInfection, outbreaks, startTime, usedPlayerCards, usedInfectionCards)
                      VALUES ('$name','Atlanta','Atlanta', 'Atlanta', 'Atlanta', '$player1CardsString', '$player2CardsString', '$player3CardsString', '$player4CardsString', '$diseaseYellowString', '$diseaseBlueString', '$diseaseRedString', '$diseaseBlackString','$currentPlayer', 'Atlanta', 1, 0, '$startTime', '$usedPlayerCardsString', '$usedInfectionString')";

      $addGame = mysqli_query($conn, $addGameQuery);

      if(!$addGame)
        die("Error, insert query failed:" . $addGameQuery);

    }

    header("location: ../gamePage.php?roomName=$name");
  }
?>
