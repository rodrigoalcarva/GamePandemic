<?php
	session_start();
	include "phpScripts/accessBD.php";
	include "phpScripts/seeGameState.php";

	$name = $_GET["roomName"];
	$currentUser = $_SESSION['username'];
	$players = array();

	//Info sobre players
	$playersQuery = "SELECT userName
	 								FROM Users
									WHERE username in (SELECT userName
																		FROM RoomPlayers
																		WHERE roomName = '$name');";

	$getPlayers = mysqli_query($conn, $playersQuery);

	if(!$getPlayers)
		die("Error, select query failed:" . $playersQuery);

		if(mysqli_num_rows($getPlayers) == 0) {
			header("location: salas.php");
		}

	if(mysqli_num_rows($getPlayers)>0) {
		while ($row = mysqli_fetch_array($getPlayers)) {
			array_push($players, $row['userName']);
		}
	}

	$otherPlayers = array();

	foreach ($players as $el) {
		if ($el != $currentUser)
			array_push($otherPlayers, $el);
	}

	$gameStateQuery = "SELECT * FROM GameState WHERE roomName = '$name'";
  $getGameState = mysqli_query($conn, $gameStateQuery);

  if(!$getGameState)
    die("Error, select query failed:" . $gameStateQuery);

  if(mysqli_num_rows($getGameState) > 0) {
    $row = mysqli_fetch_array($getGameState);
    $speedInfection = $row['speedInfection'];
		$outbreaks = $row['outbreaks'];
		$startTime = $row['startTime'];
		$researchCenter = explode("/", $row['researchCenter']);
		$currentPlayer = $row["currentPlayer"];
		$currentDiscardedCards = explode("/", $row["usedPlayerCards"]);
		$usedInfectionCards = explode("/", $row["usedInfectionCards"]);

		$player1City = array_merge(array($players[0]), explode("/", $row['player1City']));
		$player2City = array_merge(array($players[1]), explode("/", $row['player2City']));
		$player3City = array_merge(array($players[2]), explode("/", $row['player3City']));
		$player4City = array_merge(array($players[3]), explode("/", $row['player4City']));

		$diseaseYellow = array_merge(array("yellow"), explode("/", $row['diseaseYellow']));
		$diseaseBlue = array_merge(array("blue"), explode("/", $row['diseaseBlue']));
		$diseaseRed = array_merge(array("red"), explode("/", $row['diseaseRed']));
		$diseaseBlack = array_merge(array("black"), explode("/", $row['diseaseBlack']));

		$player1Cards = array_merge(array($players[0]), explode("/", $row['player1Cards']));
		$player2Cards = array_merge(array($players[1]), explode("/", $row['player2Cards']));
		$player3Cards = array_merge(array($players[2]), explode("/", $row['player3Cards']));
		$player4Cards = array_merge(array($players[3]), explode("/", $row['player4Cards']));
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Game</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/moves.js"></script>
		<script src="js/citiesConnection.js"></script>
		<script src="js/gameUpdate.js"></script>
		<script type="text/javascript" src="js/chatRoom.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
    <link href="css/game.css" rel="stylesheet">
	</head>
	<body>
		<div id="tables">
			<div id="tables1">
				<div id="blue">
					<table style="width:100%">
						<tr class="preenchido">
					    <th style="width:30%">Cidades - Azul </th>
					    <th style="width:40%">Jogadores</th>
					    <th>Doenças</th>
							<th>Centros</th>
					  </tr>
					  <tr id="Atlanta" class="cidadeB">
					    <th>Atlanta</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City, "Atlanta"); ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Atlanta", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Atlanta") ?></td>
					  </tr>
					  <tr id="Chicago" class="cidadeB">
					    <th>Chicago</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Chicago") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Chicago", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Chicago") ?></td>
					  </tr>
						<tr id="Essen" class="cidadeB">
					    <th>Essen</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City, "Essen") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Essen", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Essen") ?></td>
					  </tr>
						<tr id="Londres" class="cidadeB">
					    <th>Londres</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Londres") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Londres", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Londres") ?></td>
					  </tr>
						<tr id="Madrid" class="cidadeB">
					    <th>Madrid</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Madrid") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Madrid", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Madrid") ?></td>
					  </tr>
						<tr id="Milao" class="cidadeB">
					    <th>Milão</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Milao") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Milao", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Milao") ?></td>
					  </tr>
						<tr id="Montreal" class="cidadeB">
					    <th>Montreal</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Montreal") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Montreal", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Montreal") ?></td>
					  </tr>
						<tr id="NovaIorque" class="cidadeB">
					    <th>Nova Iorque</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Nova Iorque") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Nova Iorque", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Nova Iorque") ?></td>
					  </tr>
						<tr id="Paris" class="cidadeB">
					    <th>Paris</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Paris") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Paris", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Paris") ?></td>
					  </tr>
						<tr id="SaoFrancisco" class="cidadeB">
					    <th>São Francisco</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Sao Francisco") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Sao Francisco", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Sao Francisco") ?></td>
					  </tr>
						<tr id="SaoPetersburgo" class="cidadeB">
					    <th>São Petersburgo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Sao Petersburgo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Sao Petersburgo", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Sao Petersburgo") ?></td>
					  </tr>
						<tr id="Washington" class="cidadeB">
					    <th>Washington</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Washington") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Washington", "blue"); ?></td>
							<td><?php researchInCity($researchCenter,"Washington") ?></td>
					  </tr>
					</table>
				</div>
				<div id="red">
					<table style="width:100%">
						<tr class="preenchido">
					    <th style="width:30%">Cidades - Vermelho</th>
					    <th style="width:40%">Jogadores</th>
					    <th>Doenças</th>
							<th>Centros</th>
					  </tr>
					  <tr id="Banguecoque" class="cidadeR">
					    <th>Banguecoque</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Banguecoque") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Banguecoque", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Banguecoque") ?></td>
					  </tr>
					  <tr id="Beijing" class="cidadeR">
					    <th>Beijing</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Beijing") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Beijing", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Beijing") ?></td>
					  </tr>
					  <tr id="HoChiMinhCity" class="cidadeR">
					    <th>Ho Chi Minh City</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Ho Chi Minh City") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Ho Chi Minh City", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Ho Chi Minh City") ?></td>
					  </tr>
						<tr id="HongKong" class="cidadeR">
					    <th>Hong Kong</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Hong Kong") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Hong Kong", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Hong Kong") ?></td>
					  </tr>
						<tr id="Jakarta" class="cidadeR">
					    <th>Jakarta</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Jakarta") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Jakarta", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Jakarta") ?></td>
					  </tr>
						<tr id="Manila" class="cidadeR">
					    <th>Manila</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Manila") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Manila", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Manila") ?></td>
					  </tr>
						<tr id="Osaka" class="cidadeR">
					    <th>Osaka</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Osaka") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Osaka", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Osaka") ?></td>
					  </tr>
						<tr id="Seoul" class="cidadeR">
					    <th>Seoul</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Seoul") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Seoul", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Seoul") ?></td>
					  </tr>
						<tr id="Shangai" class="cidadeR">
					    <th>Shangai</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Shangai") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Shangai", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Shangai") ?></td>
					  </tr>
						<tr id="Sydney" class="cidadeR">
					    <th>Sydney</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Sydney") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Sydney", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Sydney") ?></td>
					  </tr>
						<tr id="Taipei" class="cidadeR">
					    <th>Taipei</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Taipei") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Taipei", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Taipei") ?></td>
					  </tr>
						<tr id="Tokyo" class="cidadeR">
					    <th>Tokyo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Tokyo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Tokyo", "red"); ?></td>
							<td><?php researchInCity($researchCenter,"Tokyo") ?></td>
					  </tr>
					</table>
				</div>
				<div id="yellow">
					<table style="width:100%">
						<tr class="preenchido">
					    <th style="width:30%">Cidades - Amarelo</th>
					    <th style="width:40%">Jogadores</th>
					    <th>Doenças</th>
							<th>Centros</th>
					  </tr>
						<tr id="Bogota" class="cidadeY">
					    <th>Bogota</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Bogota") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Bogota", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Bogota") ?></td>
					  </tr>
					  <tr id="BuenosAires" class="cidadeY">
					    <th>Buenos Aires</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Buenos Aires") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Buenos Aires", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Buenos Aires") ?></td>
					  </tr>
					  <tr id="CidadeDoMexico" class="cidadeY">
					    <th>Cidade do México</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Cidade Do Mexico") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Cidade Do Mexico", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Cidade Do Mexico") ?></td>
					  </tr>
					  <tr id="Khartoum" class="cidadeY">
					    <th>Khartoum</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Khartoum") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Khartoum", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Khartoum") ?></td>
					  </tr>
						<tr id="Kinshasa" class="cidadeY">
					    <th>Kinshasa</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Kinshasa") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Kinshasa", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Kinshasa") ?></td>
					  </tr>
						<tr id="Joanesburgo" class="cidadeY">
					    <th>Joanesburgo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Joanesburgo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Joanesburgo", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Joanesburgo") ?></td>
					  </tr>
						<tr id="Lagos" class="cidadeY">
					    <th>Lagos</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Lagos") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Lagos", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Lagos") ?></td>
					  </tr>
						<tr id="Lima" class="cidadeY">
					    <th>Lima</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Lima") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Lima", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Lima") ?></td>
					  </tr>
						<tr id="LosAngeles" class="cidadeY">
					    <th>Los Angeles</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Los Angeles") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Los Angeles", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Los Angeles") ?></td>
					  </tr>
						<tr id="Miami" class="cidadeY">
					    <th>Miami</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Miami") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Miami", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Miami") ?></td>
					  </tr>
						<tr id="Santiago" class="cidadeY">
					    <th>Santiago</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Santiago") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Santiago", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Santiago") ?></td>
					  </tr>
						<tr id="SaoPaulo" class="cidadeY">
					    <th>São Paulo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Sao Paulo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Sao Paulo", "yellow"); ?></td>
							<td><?php researchInCity($researchCenter,"Sao Paulo") ?></td>
					  </tr>
					</table>
				</div>
				<div id="black">
					<table style="width:100%">
						<tr class="preenchido">
					    <th style="width:30%">Cidades - Preto</th>
					    <th style="width:40%">Jogadores</th>
					    <th>Doenças</th>
							<th>Centros</th>
					  </tr>
					  <tr id="Argel" class="cidadeBL">
					    <th>Argel</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Argel") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Argel", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Argel") ?></td>
					  </tr>
					  <tr id="Baghdad" class="cidadeBL">
					    <th>Baghdad</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, "Baghdad") ?> </td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Baghdad", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Baghdad") ?></td>
					  </tr>
					  <tr id="Cairo" class="cidadeBL">
					    <th>Cairo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Cairo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Cairo", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Cairo") ?></td>
					  </tr>
						<tr id="Chennai" class="cidadeBL">
					    <th>Chennai</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Chennai") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Chennai", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Chennai") ?></td>
					  </tr>
						<tr id="Deli" class="cidadeBL">
					    <th>Deli</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Deli") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Deli", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Deli") ?></td>
					  </tr>
						<tr id="Istambul" class="cidadeBL">
					    <th>Istambul</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Istambul") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Istambul", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Istambul") ?></td>
					  </tr>
						<tr id="Karachi" class="cidadeBL">
					    <th>Karachi</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Karachi") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Karachi", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Karachi") ?></td>
					  </tr>
						<tr id="Kolkota" class="cidadeBL">
					    <th>Kolkota</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Kolkota") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Kolkota", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Kolkota") ?></td>
					  </tr>
						<tr id="Moscovo" class="cidadeBL">
					    <th>Moscovo</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Moscovo") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Moscovo", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Moscovo") ?></td>
					  </tr>
						<tr id="Mumbai" class="cidadeBL">
					    <th>Mumbai</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Mumbai") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Mumbai", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Mumbai") ?></td>
					  </tr>
						<tr id="Riade" class="cidadeBL">
					    <th>Riade</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Riade") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Riade", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Riade") ?></td>
					  </tr>
						<tr id="Tehran" class="cidadeBL">
					    <th>Tehran</th>
					    <td><?php playerInCity($player1City, $player2City, $player3City, $player4City,"Tehran") ?></td>
							<td><?php diseaseInCity($name, $diseaseYellow, $diseaseBlue, $diseaseRed, $diseaseBlack, "Tehran", "black"); ?></td>
							<td><?php researchInCity($researchCenter,"Tehran") ?></td>
					  </tr>
					</table>
				</div>
			</div>
			<div id="tables2">
				<div id="textMainCity"><h4>Main City:</h4></div>
				<div id="mainCityClick"></div>
				<div id="textOtherCity"><h4>Suas ligações:</h4></div>
				<div id="otherCity"></div>
			</div>
		</div>
		<div id="actions">
			<div id="infGer">
				<div class="infGer1">
					<h5>Velocidade Infeção:</h5>
					<h4><?php echo($speedInfection . 'x'); ?></h4>
				</div>
				<div class="infGer1">
					<h5> Surtos: </h5>
					<h4> <?php echo($outbreaks); ?> </h4>
				</div>
				<div class="infGer1">
					<div id="yellowCured" <?php seeCured("yellow",$name) ?>><p>Amarela</p></div>
					<div id="blueCured" <?php seeCured("blue",$name) ?>><p>Azul</p></div>
					<div id="blackCured" <?php seeCured("black",$name) ?>><p>Preta</p></div>
					<div id="redCured" <?php seeCured("red",$name) ?>><p>Vermelha</p></div>
				</div>
				<div class="infGer1">
					<h5>Horas de Começo:</h5>
					<h4><?php echo($startTime); ?></h4>
				</div>
				<div class="infGer1">
					<div class="showPlayers" id="jog1"><p><?php echo $players[0] ?></p></div>
					<div class="showPlayers" id="jog2"><p><?php echo $players[1] ?></p></div>
					<div class="showPlayers" id="jog3"><p><?php echo $players[2] ?></p></div>
					<div class="showPlayers" id="jog4"><p><?php echo $players[3] ?></p></div>
				</div>
			</div>
			<div id="controlos">
				<div id='losComandos'>
				<?php
					if ($currentUser == $currentPlayer) {
						echo
								"<div id='esqCom'>
									<div id='comando1'>
										<img src='images/move.png'>
										<p>Mover</p>
									</div>
									<div id='comando2'>
										<img src='images/firstkit.png'>
										<p>Tratar <br>doença</p>
									</div>
									<div id='comando3'>
										<img src='images/research.png'>
										<p>Criar<br>centro</p>
									</div>
								</div>
								<div id='cenCom'>
									<div id='comando4'>
										<img src='images/creativity.png'>
										<p>Descobrir<br>cura</p>
									</div>
									<div id='comando5'>
										<img src='images/idea.png'>
										<p>Partilhar<br>carta</p>
									</div>
								</div>
								<div id='dirCom'>

								</div>";
						}
						?>
				</div>
				<div id="minhasCartas">
					<div id="headerCartas">
						<h4>Minhas Cartas</h4>
					</div>
					<div id="lasCartas">
						<?php playerCards($player1Cards,$player2Cards,$player3Cards,$player4Cards, $currentUser); ?>
					</div>
				</div>
				<div id="cartasOutros">
					<div id="headerCartas">
						<h4>Cartas outros jogadores:</h4>
					</div>
					<div id="lasCartas">
						<div class="cartasJog">
							<div class="cardsPlayers">
								<h3>
									<?php
										if (isset($otherPlayers[0])) {
											echo $otherPlayers[0] . ":";
										}
									?>
								</h3>
								<p>
									<?php
										if (isset($otherPlayers[0])) {
											playerCards($player1Cards,$player2Cards,$player3Cards,$player4Cards, $otherPlayers[0]);
										}
										?>
								</p>
							</div>
						</div>
						<br>
						<div class="cartasJog">
							<div class="cardsPlayers">
								<h3>
									<?php
										if (isset($otherPlayers[1])) {
											echo $otherPlayers[1] . ":";
										}
									?>
								</h3>
								<p>
									<?php
										if (isset($otherPlayers[1])) {
											playerCards($player1Cards,$player2Cards,$player3Cards,$player4Cards, $otherPlayers[1]);
										}
										?>
								</p>
							</div>
						</div>
						<br>
						<div class="cartasJog">
							<div class="cardsPlayers">
								<h3>
									<?php
										if (isset($otherPlayers[2])) {
											echo $otherPlayers[2] . ":";
										}
									?>
								</h3>
								<p>
									<?php
										if (isset($otherPlayers[2])) {
											playerCards($player1Cards,$player2Cards,$player3Cards,$player4Cards, $otherPlayers[2]);
										}
										?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="infDesistir">
				<div id="cima">

					<?php
						if ($currentUser == $currentPlayer) {
							echo "<img id='pass' src='images/pass.png'>";
						}
					?>

				</div>
				<div id="baixo">
					<img data-toggle="modal" data-target="#myModal" id="desistir" src="images/des.png">
				</div>
			</div>
		</div>
		<?php
			if (isset($_SESSION["username"])) {
				echo "<div id='chatRoom' class='dropup'>
					<p>ChatRoom</p>
				</div>
				<div id='dropUp' class='dropup-content'>
					<div id='chatRoomTitle'>
						<p>ChatRoom: Global</p>
					</div>
					<div id='messagesChat'>
					</div>
					<div id='sendMessage'>
						<form>
							<input type='text' name='textMens'></input>
							<button type='submit' name='sendMensg'>Enviar</button>
						</form>
					</div>
				</div>";
			}
		 ?>
		<div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">
				<!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Desistir</h4>
	        </div>
	        <div class="modal-body">
	          <p>Tem a certeza que quer desistir ?</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal" id="ConfirmarDesistir">Sim</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
	        </div>
	      </div>
	    </div>
  	</div>

  </body>
</html>
