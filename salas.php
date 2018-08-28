<?php
	session_start();
	include "phpScripts/accessBD.php";

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Salas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/roomUpdate.js"></script>
		<script src="js/rests.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/salas.css" rel="stylesheet">
		<script type="text/javascript" src="js/chatRoom.js"></script>
	</head>
	<body>

		<?php
		if (isset($_SESSION["messageReceived"])) {
			echo "<script>alert('". $_SESSION["messageReceived"] ."');</script>";
			unset($_SESSION["messageReceived"]);
		}
		?>


		<div id="navbar">
      <div id="navEsq">
        <a href="index.php"><img id="logo" src="images/logo.jpg"></a>
      </div>
      <div id="navCt">
        <ul>
          <li><a href="salas.php">JOGAR<span></span><span></span></a></li>
          <li><a href="rules.php">REGRAS<span></span><span></span></a></li>
          <li><a href="contacts.php">CONTACTOS<span></span><span></span></a></li>
      </div>
      <div id="navDir" class="dropdown">

				<?php
				if (!isset($_SESSION["username"])) {
					header('Location: index.php');
					$_SESSION['messageReceived'] = "Necessário conta para jogar";
				}
				else {
					echo "<div id='logFeito'>
									<div id='cimaDiv'>
										<p>Olá " . $_SESSION['username'] . "</p>
									</div>
									<div id='baixoDiv'>
						      	<a href='userPage.php'><div id='userPage'> Minha conta </div></a>
						      	<a href='phpScripts/logout.php' id='logoutB'> Logout </a>
									</div>
								</div>";
				}
				?>

      </div>
    </div>
		<div id="corpo">
      <div id="entrarSala">
        <h1>Entrar em Salas:</h1>
				<div id="asSalas">

					<?php
						$roomQuery = "SELECT * FROM Rooms WHERE estadoJogo != 'Terminado'";
						$getRoom = mysqli_query($conn, $roomQuery);

						if(!$getRoom)
				      die("Error, select query failed:" . $roomQuery);

						$username = $_SESSION['username'];

						if(mysqli_num_rows($getRoom)>0) {
							while  ($row = mysqli_fetch_array($getRoom)) {
								$roomName = $row['nome'];
								$atualjog = $row['numAtuaisJog'];
								$maxjog = $row['numMaxJog'];
								$estadoJogo = str_replace("_"," ",$row['estadoJogo']);
								$timeToStart = $row['timeToStart'];
								$players = "";
								$desc = $row['descricao'];
								$entrarClass = "entrar_" . $row['nome'];

								$playersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$roomName'";
								$getPlayers = mysqli_query($conn, $playersQuery);

								if(!$getPlayers)
									die("Error, select query failed:" . $playersQuery);


								if(mysqli_num_rows($getPlayers)>0) {
									while ($row = mysqli_fetch_array($getPlayers)) {
										if (strlen($players) == 0) {
											$players .= $row['userName'];
										}
										else {
											$players .= ", " . $row['userName'];
										}
									}
								}

								if ($estadoJogo == "Em Jogo"){
									echo "<script>$(document).ready(function() {
																	$('.$entrarClass').css('background-color', 'rgba(242,176,38,0.5)');
	                								$('.$entrarClass').css('cursor','not-allowed');
	                								$('.$entrarClass').click(function(e) {
	                  								e.preventDefault();
	                								});
																});
									</script>";

								}

								echo "<div class='sala'>
												<div class='esqSala'>
													<div class='nomeSala'>
														<h3>$roomName ($atualjog/$maxjog)</h3>
													</div>
													<div class='descSala'>
														<h4>Descrição: $desc</h4>
													</div>
													<div class='jogSala'>
														<h4>Jogadores:</h4>
															<p>
																$players
															</p>
													</div>
													<div class='progSala'>
														<h4>$estadoJogo ...</h4>
													</div>
												</div>
												<div class='dirSala'>
													<div class='tempoSala'>
														<h5>Tempo restante:</h5>
														<h4 class='timeRes'></h4>
														<h5>segundos</h5>
													</div>
													<div class='entSala'>
														<a href='phpScripts/manageRoom.php?name=$roomName' class='btn btn-primary $entrarClass'>Entrar</a>
													</div>
												</div>
											</div>";
							}
						}
						?>

				</div>
      </div>
      <div id="criarSala">
        <h1>Criar sala:</h1>
        <form id="formCriar" action="<?=htmlspecialchars(stripslashes(trim("phpScripts/createRoom.php")));?>" method="post">

          <div class="form-group row">
            <div class="col-sm-10">
              <input type="text" class="form-control" name="name" placeholder="Nome" required>
            </div>
          </div>

					<div class="form-group row">
            <div class="col-sm-10">
            	<input type="text" class="form-control" id="inputDescricao" name="description" placeholder="Descrição ..." required>
          	</div>
					</div>

					<div class="form-group row">
            <div class="col-sm-10">
            	<input type="number" class="form-control" id="inputTimer" name="timer" placeholder="Segundos até inicio ..." required>
						</div>
					</div>

          <select id="numsPlayers" name="numMaxPlayers" required>
            <option value="" selected disabled>Nº de Jogadores Máximo</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
					<input id="buttomnRestr" type="button" onclick="toggle_visibility('lasRestricoes')" value="Restrições"></input>

					<div id="lasRestricoes">
						<div id="restrSelects">
							<div class="checkboxs">
								<input type="checkbox" name="inputRes" value="idade">Idade Minima
							</div>
							<div class="checkboxs">
								<input type="checkbox" name="inputRes" value="concelho">Concelho
							</div>
							<div class="checkboxs">
								<input type="checkbox" name="inputRes" value="distrito">Distrito
							</div>
							<div class="checkboxs">
								<input type="checkbox" name="inputRes" value="pais">Pais
							</div>
						</div>
						<div id="appearSelects">
							<input type="text" name="inputAge" value="Coloque idade minima">
							<input type="text" name="inputConcelho" value="Coloque concelho">
							<input type="text" name="inputDistrito" value="Coloque distrito">
							<input type="text" name="inputPais" value="Coloque pais">
						</div>
					</div>

          <button class="btn" id="criarForm" type="submit" name="createRoom">
            Criar Sala
            <span class="BorderTopBottom"></span>
            <span class="BorderLeftRight"></span>
          </button>

        </form>
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
