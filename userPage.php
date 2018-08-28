<?php
	session_start();
	include "phpScripts/accessBD.php";
	$username = $_SESSION['username'];

	$searchQuery = "SELECT *
									FROM Users
									WHERE username = '$username'";

	$search = mysqli_query($conn, $searchQuery);

	if(!$search)
		 die("Error, select query failed:" . $searchQuery);

	$row = mysqli_fetch_array($search);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User Page</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/userPage.css" rel="stylesheet">
		<script type="text/javascript" src="js/dist_cons.js"></script>
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
				else{
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
    <div class="container">
      <div id="cima">
        <div id="cimaEsq">
          <div id="foto">
						<?php echo "<img src='userImages/".$_SESSION['username'].".jpg'>" ?>
          </div>
        </div>
        <div id="cimaDir">
					<div class="info">
						<?php echo "<h3>Nome de Utilizador :</h3>"."  "."<h4>". $row["username"] . "</h4>"?>
					</div>
					<div class="info">
						<?php echo "<h3>Email :</h3>"."  "."<h4>". $row["email"] . "</h4>"?>
					</div>
					<div class="info">
						<?php echo "<h3>País :</h3>"."  "."<h4>". $row["country"] . "</h4>"?>
					</div>
					<div class="info">
						<?php echo "<h3>Nome Próprio :</h3>"."  "."<h4>". $row["firstName"] . "</h4>"?>
					</div>
					<div class="info">
						<?php echo "<h3>Apelido :</h3>"."  "."<h4>". $row["lastName"] . "</h4>"?>
					</div>
        </div>
      </div>
      <div id="baixo">
        <div id="baixoMeio">
					<div id="textoDiv">
						<div id="jogosJogados">
							<?php echo "<h1>Jogos Jogados:". " " .$row["jogosJogados"] . "</h1>" ?>
						</div>
						<div id="vitorias">
							<?php echo "<h1>Vitórias:". " " .$row["vitorias"] . "</h1>" ?>
						</div>
						<div id="derrotas">
							<?php echo "<h1>Derrotas:". " " .$row["derrotas"] . "</h1>" ?>
						</div>
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
    </div>
  </body>
</html>
