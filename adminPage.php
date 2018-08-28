<?php
	session_start();
?>

<html>
	<head>
		<title>AdminPage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/adminSearch.js"></script>
		<script src="js/adminUpdate.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
	</head>
	<body>
		<div id="navbarGame">
      <div id="navEsq">
        <a href="index.php"><img id="logoGame" src="images/logo.jpg"></a>
      </div>
      <div id="navCt">
      </div>
      <div id="navDir" class="dropdown">
        <h3>Informação Users e Jogos</h3>
      </div>
    </div>
		<div id="corpo">
      <div id="buttons">
        <button class="btn" id="criarForm" type="submit" name="createRoom" onclick="toggle_visibility()">
          Utilizadores
        </button>
        <button class="btn" id="criarForm" type="submit" name="createRoom" onclick="toggle_visibility1()">
          Jogos
        </button>
      </div>
      <div id="divUsers">
        <div id="inputsUsers">
					<form action="" id="formUser" method="post">
						<div class="theInputs">
							<label> Nome de utilizador/ Email:<br>
	              <input type="text" name="username" id="name_of_user">
	            </label>
						</div>
						<div class="theInputs">
							<label> País:<br>
	              <input type="text" name="country" id="country_of_user">
	            </label>
						</div>
						<div class="theInputs">
							<label> Distrito:<br>
	              <input type="text" name="district" id="district_of_user">
	            </label>
						</div>
						<div class="theInputs">
							<label> Concelho:<br>
	              <input type="text" name="concelho" id="concelho_of_user">
	            </label>
						</div>
						<div class="theInputs">
							<label> Faixa Etária:<br>
								<select id="faixaEtaria" id="age_of_user">
									<option value="0"> Faixa Etária: </option>
									<option value="<18"> <'18 </option>
									<option value="18-25"> 18-25 </option>
									<option value="26-35"> 26-35 </option>
									<option value="35-45"> 36-45 </option>
									<option value="45-65"> 46-65 </option>
									<option value=">65"> >65 </option>
								</select>
							</label>
						</div>
						<div class="theInputs">
							<input type="submit" id="submitUser" name="pesquisa" >
						</div>
					</form>
        </div>
				<div id="infUsers">

				</div>
      </div>
			<div id="divGames">
				<div id="inputsGames">
					<form action="" id="formGame1" method="post">
							<div class="theInputsG">
								<label> Jogos em Espera:<br>
									<input type="checkbox" name="notStart" value="notStart" id="jogos_em_espera">
								</label>
							</div>
							<div class="theInputsG">
								<label>Jogos em Jogo:<br>
									<input type="checkbox" name="start" value="start" id="jogos_em_jogo">
								</label>
							</div>
							<div class="theInputsG">
								<label>Jogos já Finalizados:<br>
									<input type="checkbox" name="end" value="end" id="jogos_finalizados">
								</label>
							</div>
							<div class="theInputsG" id="oneSubmit">
								<input type="submit" name="pesquisaGames1" id="pesquisaGames1">
							</div>
						</form>
						<form action="" id="formGame" method="post">
							<div class="theInputsG">
								<label> Nome:<br>
									<input type="text" name="gamename" id="gamename">
								</label>
							</div>
							<div class="theInputsG">
								<label> Descrição:<br>
									<input type="text" name="description" id="descriptionGame">
								</label>
							</div>
							<div class="theInputsG">
								<label> Dono:<br>
									<input type="text" name="dono" id="donoGame">
								</label>
							</div>
							<div class="theInputsG">
								<input type="submit" name="pesquisaGames" id="pesquisaGames1">
							</div>
						</form>
					</div>
				<div id="infGames">
					<?php
					
					if (isset($_POST["pesquisaGames"])) {
					  include "phpScripts/accessBD.php";

					  $gameName = $_POST["gamename"];
					  $description = $_POST["description"];
						$chef = $_POST["dono"];


						if (strlen($gameName) > 0) {
							$searchQuery1 = "SELECT *
					  									FROM GameState
					  									WHERE roomName = '$gameName'";
					  }

					  else if (strlen($description) > 0) {
					    $searchQuery1 = "SELECT *
															FROM GameState
															WHERE roomName in (SELECT nome
																								FROM Rooms
																								WHERE descricao = '$description')";
					  }

					  else if (strlen($chef) > 0) {
							$searchQuery1 = "SELECT *
														 FROM GameState
														 WHERE roomName in (SELECT nome
																							 FROM Rooms
																							 WHERE admin = '$chef')";
					  }

						$search1 = mysqli_query($conn, $searchQuery1);

						if(!$search1)
							 die("Error, select query failed:" . $searchQuery1);

					  if(mysqli_num_rows($search1)==0) {
					    if (strlen($gameName) > 0) {
					      echo "Nome de jogo $gameName nao se encontra registado";
					    }

					    else {
					      echo "Não existem jogos que correspodem a esses parametros";
					    }
						}

					  else {
							while ($row = mysqli_fetch_array($search1, MYSQLI_NUM)) {
								$html[] = "<tr><td>" . implode("</td> <td>", $row) . "</td></tr>";
							}

					    $headerRow = "<tr> <th> roomName </th> <th> player1City </th> <th> player2City </th> <th> player3City </th> <th> player4City </th> <th> player1Cards </th> <th> player2Cards </th> <th> player3Cards </th> <th> player4Cards </th> <th> currentPlayer </th><th> diseaseYellow </th> <th> diseaseBlue </th> <th> diseaseRed </th> <th> diseaseBlack </th> <th> curedYellow </th><th> curedBlue </th><th> curedRed </th><th> curedBlack </th><th> researchCenter </th><th> speedInfection </th><th> outbreaks </th><th> startTime </th><th> usedPlayerCards </th><th> usedInfectionCards </th><th> numPlays	 </th></tr>";

					    $html = "<table id='tablesGames'>" . $headerRow . implode("\n", $html) . "</table>";

							echo $html;
					  }
					}
					?>
				</div>
			</div>
    </div>
  </body>
</html>
