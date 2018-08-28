<?php
	session_start();
	include "phpScripts/accessBD.php";
	$name = $_GET["name"];
	$players = array();
	$currentUser = $_SESSION['username'];

	$gameRoomQuery = "SELECT * FROM Rooms WHERE nome = '$name'";
	$getGameRoom = mysqli_query($conn, $gameRoomQuery);

	if(!$getGameRoom)
		die("Error, select query failed:" . $gameRoomQuery);

	if(mysqli_num_rows($getGameRoom)>0) {
		$row = mysqli_fetch_array($getGameRoom);
		$atualjog = $row['numAtuaisJog'];
		$maxjog = $row['numMaxJog'];
		$admin = $row['admin'];

		$estadoJogo = str_replace("_"," ",$row['estadoJogo']);

		//Ve se jogo ja iniciou
		if ($estadoJogo == "Em Jogo") {
			header("location: phpScripts/manageGame.php?gameRoom=$name");
		}
	}

	//Info sobre players
	$playersQuery = "SELECT userName, vitorias, derrotas, photoUpload
	 								FROM Users
									WHERE username in (SELECT userName
																		FROM RoomPlayers
																		WHERE roomName = '$name');";

	$getPlayers = mysqli_query($conn, $playersQuery);

	if(!$getPlayers)
		die("Error, select query failed:" . $playersQuery);

	if(mysqli_num_rows($getPlayers)>0) {
		while ($row = mysqli_fetch_array($getPlayers)) {
			array_push($players, array($row['userName'], $row['vitorias'], $row['derrotas'], $row['photoUpload']));
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sala de jogo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/roomUpdate.js"></script>
		<script type="text/javascript" src="js/chatRoom.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
    <link href="css/theRooms.css" rel="stylesheet">
	</head>
	<body>
		<div id="navbarGame">
      <div id="navEsq">
        <a href="index.php"><img id="logoGame" src="images/logo.jpg"></a>
      </div>
      <div id="navCt">
      </div>
      <div id="navDir" class="dropdown">
				<?php
					if ($currentUser == $admin) {
						if ($atualjog > 1){
							echo "<div class='btn btn-primary' id='startGame' ><h2>Iniciar Jogo</h2></div>";
							echo "<script>
								$('#startGame').click(function() {
									window.location.href = 'phpScripts/manageGame.php?gameRoom=$name&adminStart=sim';
								});
							</script>";
						}
					}
				?>

				<div id='time'>
					<h5>Tempo restante:</h5>
					<h2 class="timeRes" id='timer'>
					</h2>
					<h5>segundos</h5>
				</div>

			</div>
    </div>
		<div id="corpo">
      <div id="roomName">

				<?php
					//nome da sala
					echo "<h2>Sala do $name </h2>";
					echo "<a class='btn btn-primary' href='phpScripts/manageRoom.php?exit=$name'><h5>Sair</h5></a>";
				?>
      </div>
      <div id="thePlayers">

        <div id="player1">
          <div id="player1Photo">
						<?php
							if (isset($players[0])) {
								if ($players[0][3] == "sim")
									echo "<img src='userImages/" . $players[0][0] . ".jpg'>;";
								else
									echo "<img src='images/interrogacao.jpg'>;";
							}
						?>
          </div>

          <div class="playerNames">
						<?php echo "<h2>" . $players[0][0]  . "</h2>";?>
          </div>

          <div class="playerStatistics">
            <?php
							echo "<p>V: "." ". $players[0][1] ." <br> D: "." ". $players[0][1] ."</p>;";
						?>
					</div>

						<?php
							if ($players[0][0] == $admin) {
								echo "<div id='host'><img src='images/star.png'></div>";
							}
						?>

        </div>

				<div id="player2">
          <div id="player2Photo">
						<?php
							if (isset($players[1])) {
								if ($players[1][3] == "sim")
									echo "<img src='userImages/" . $players[1][0] . ".jpg'>;";
								else
									echo "<img src='images/interrogacao.jpg'>;";
							}
							else {
								echo "<img src='images/userP.png'>;";
							}
						?>
          </div>

          <div class="playerNames">
						<?php
							if (isset($players[1])) {
								echo "<h2>" . $players[1][0]  . "</h2>";
							}
							else {
								echo"<h2> - - </h2>";
							}
						?>
          </div>

          <div class="playerStatistics">
						<?php
							if (isset($players[1])) {
								echo "<p>V: "." ". $players[1][1] ." <br> D: "." ". $players[1][1] ."</p>;";
							}
						?>
          </div>

					<?php
						if (isset($players[1])) {
							if ($players[1][0] == $admin) {
								echo "<div id='host'><img src='images/star.png'></div>";
							}
						}
					?>

        </div>

				<div id="player3">
          <div id="player3Photo">
              <?php
								if (isset($players[2])) {
									if ($players[2][3] == "sim")
										echo "<img src='userImages/" . $players[2][0] . ".jpg'>;";
									else
										echo "<img src='images/interrogacao.jpg'>;";
								}
								else {
									echo "<img src='images/userP.png'>;";
								}
							?>

          </div>
          <div class="playerNames">
            <?php
							if (isset($players[2])) {
								echo "<h2>" . $players[2][0]  . "</h2>";
							}
							else {
								echo"<h2> - - </h2>";
							}
						?>
          </div>

          <div class="playerStatistics">
						<?php
							if (isset($players[2])) {
								echo "<p>V: "." ". $players[2][1] ." <br> D: "." ". $players[2][1] ."</p>;";
							}
						?>
          </div>

					<?php
					if (isset($players[2])) {
						if ($players[2][0] == $admin) {
							echo "<div id='host'><img src='images/star.png'></div>";
						}
					}
					?>

        </div>

				<div id="player4">
          <div id="player4Photo">
            <?php
							if (isset($players[3])) {
								if ($players[3][3] == "sim")
									echo "<img src='userImages/" . $players[3][0] . ".jpg'>;";
								else
									echo "<img src='images/interrogacao.jpg'>;";
							}
							else {
								echo "<img src='images/userP.png'>;";
							}
						?>
          </div>
          <div class="playerNames">
						<?php
							if (isset($players[3])) {
								echo "<h2>" . $players[3][0]  . "</h2>";
							}
							else {
								echo"<h2> - - </h2>";
							}
						?>
          </div>
          <div class="playerStatistics">
						<?php
							if (isset($players[3])) {
								echo "<p>V: "." ". $players[3][1] ." <br> D: "." ". $players[3][1] ."</p>;";
							}
						?>
          </div>
					<?php
					if (isset($players[3])) {
						if ($players[3][0] == $admin) {
							echo "<div id='host'><img src='images/star.png'></div>";
						}
					}
					?>
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
		</div>
  </body>
</html>
