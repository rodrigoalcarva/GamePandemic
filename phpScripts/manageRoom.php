<?php
	session_start();
	include "accessBD.php";
	$name = $_GET["name"];
	$exitRoom = $_GET["exit"];
	$currentUser = $_SESSION['username'];
	$restrain = False;

	if (isset($name)) {
		$gameRoomQuery = "SELECT numAtuaisJog, numMaxJog, restriction, admin FROM Rooms WHERE nome = '$name'";
		$getGameRoom = mysqli_query($conn, $gameRoomQuery);

		if(!$getGameRoom)
			die("Error, select query failed:" . $gameRoomQuery);

		if(mysqli_num_rows($getGameRoom)>0) {
			$row = mysqli_fetch_array($getGameRoom);
			$atualjog = $row['numAtuaisJog'];
			$maxjog = $row['numMaxJog'];

			if (isset($row['restriction']) && $currentUser != $row['admin']) {
				$restriction = explode("/", $row['restriction']);

				$UserQuery = "SELECT * FROM Users WHERE username = '$currentUser'";
				$getUser = mysqli_query($conn, $UserQuery);

				if(!$getUser)
					die("Error, select query failed:" . $UserQuery);

				if(mysqli_num_rows($getUser)>0) {
					$row = mysqli_fetch_array($getUser);

					if ($restriction[0] == "idade") {
						$birthday = $row["birthday"];

						if (date_diff(date_create($birthday), date_create('today'))->y < $restriction[1]) {
							$_SESSION["messageReceived"] = "Nao corresponde a restricoes";
							header("location: ../salas.php");
							$restrain = True;
						}
					}

					else if ($restriction[0] == "concelho" && $row["concelho"] != $restriction[1]) {
						$_SESSION["messageReceived"] = "Nao corresponde a restricoes";
						header("location: ../salas.php");
						$restrain = True;
					}

					else if ($restriction[0] == "distrito" && $row["distritc"] != $restriction[1]) {
						$_SESSION["messageReceived"] = "Nao corresponde a restricoes";
						header("location: ../salas.php");
						$restrain = True;
					}

					else if ($restriction[0] == "pais" && $row["country"] != $restriction[1]) {
						$_SESSION["messageReceived"] = "Nao corresponde a restricoes";
						header("location: ../salas.php");
						$restrain = True;
					}

				}
			}

			if (!$restrain) {
				//Ve numero de jogadores
				if ($atualjog == $maxjog) {
					header("location: ../salas.php");
				}

				else {
					//Adiciona user
					$addPlayerQuery = "INSERT INTO RoomPlayers
														VALUES ('$name', '$currentUser','')";

					$addPlayer = mysqli_query($conn, $addPlayerQuery);

					if(!$addPlayer)
						die("Error, select query failed:" . $addPlayerQuery);

					$updateCounterQuery = "UPDATE Rooms SET numAtuaisJog = numAtuaisJog + 1 WHERE nome = '$name'";
					$updateCounter = mysqli_query($conn, $updateCounterQuery);

					if(!$updateCounter)
						die("Error, update query failed:" . $updateCounterQuery);

				  header("location: ../playRoom.php?name=$name");
				}
			}
		}
	}



	if (isset($exitRoom)) {
		//Remove user
		$removePlayerQuery = "DELETE FROM RoomPlayers
												WHERE userName = '$currentUser'
												AND roomName = '$exitRoom'";

		$removePlayer = mysqli_query($conn, $removePlayerQuery);

		if(!$removePlayer)
			die("Error, delete query failed:" . $removePlayerQuery);

		$updateCounterQuery = "UPDATE Rooms SET numAtuaisJog = numAtuaisJog - 1 WHERE nome = '$exitRoom'";
		$updateCounter = mysqli_query($conn, $updateCounterQuery);

		if(!$updateCounter)
			die("Error, update query failed:" . $updateCounterQuery);

	  header("location: ../playRoom.php?name=$name");

		//fecha ou deixa sala aberta
		$players = array();

		$playersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$exitRoom'";
		$getPlayers = mysqli_query($conn, $playersQuery);

		if(!$getPlayers)
			die("Error, select query failed:" . $playersQuery);

		if(mysqli_num_rows($getPlayers)>0) {
			while ($row = mysqli_fetch_array($getPlayers)) {
				array_push($players, $row['userName']);
			}
		}

		else if(mysqli_num_rows($getPlayers) == 0) {
			$closeRoomQuery = "DELETE FROM Rooms
													WHERE nome = '$exitRoom'";

			$closeRoom = mysqli_query($conn, $closeRoomQuery);

			if(!$closeRoom)
				die("Error, delete query failed:" . $closeRoomQuery);
		}


		//Muda admin
		$gameRoomQuery = "SELECT admin FROM Rooms WHERE nome = '$exitRoom'";
		$getGameRoom = mysqli_query($conn, $gameRoomQuery);

		if(!$getGameRoom)
			die("Error, select query failed:" . $gameRoomQuery);

		if(mysqli_num_rows($getGameRoom)>0) {
			$row = mysqli_fetch_array($getGameRoom);
			if ($row['admin'] == $currentUser) {

				$changeAdminQuery = "UPDATE Rooms SET admin = '$players[0]' WHERE nome = '$exitRoom'";
				$changeAdmin = mysqli_query($conn, $changeAdminQuery);

				if(!$changeAdmin)
					die("Error, update query failed:" . $changeAdminQuery);
			}
		}

		header("location: ../salas.php");
	}
?>
