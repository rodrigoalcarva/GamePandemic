<?php
  session_start();
  include "accessBD.php";

  if (isset($_POST["createRoom"])) {
    $name = htmlspecialchars(stripslashes(trim($_POST["name"])));
    $description = $_POST["description"];
    $numMaxJog = (int) $_POST["numMaxPlayers"];
    $admin = $_SESSION["username"];
    $timeToStart = $_POST["timer"];

    if ($_POST["inputRes"]) {
      if ($_POST["inputRes"] == "idade") {
        $restriction = "idade/" . $_POST["inputAge"];
      }
      else if ($_POST["inputRes"] == "concelho") {
        $restriction = "concelho/" . $_POST["inputConcelho"];
      }
      else if ($_POST["inputRes"] == "distrito") {
        $restriction = "distrito/" . $_POST["inputDistrito"];
      }
      else if ($_POST["inputRes"] == "pais") {
        $restriction = "pais/" . $_POST["inputPais"];
      }
    }

    //Check nome sala ja resgistada
    $roomNameQuery = "select * from Rooms WHERE username='$name'";
    $checkroomName = mysqli_query($conn, $roomNameQuery);

    if(mysqli_num_rows($checkroomName)>0) {
      $_SESSION['messageReceived'] = "Sala com o nome $name ja existe. Tente outro nome!";
      header("Location: ../salas.php");
    }

    //Check admin ja com sala
    $adminQuery = "select * from Rooms WHERE admin='$admin'";
    $checkAdmin = mysqli_query($conn, $adminQuery);

    if(mysqli_num_rows($checkAdmin)>0) {
      $_SESSION['messageReceived'] = "Utilizador $admin ja tem uma sala criada";
      header("Location: ../salas.php");
    }

    // cria sala
    $currentTime = time();
    $createRoomQuery = "INSERT INTO Rooms (nome, descricao, numMaxJog, numAtuaisJog, admin, estadoJogo, creationTime,timeToStart, restriction)
                      VALUES ('$name', '$description', $numMaxJog, 0, '$admin', 'Em_Espera', $currentTime, $timeToStart, '$restriction')";

    $createRoom = mysqli_query($conn, $createRoomQuery);

    if(!$createRoom)
      die("Error, insert query failed:" . $createRoomQuery);

    header("Location: manageRoom.php?name=$name");
  }
?>
