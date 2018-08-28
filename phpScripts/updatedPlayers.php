<?php
  include "accessBD.php";
  session_start();
  $roomName = $_GET["roomName"];
  $players = array();

  $getRoomQuery = "SELECT admin FROM Rooms WHERE nome = '$roomName'";
  $getRoom= mysqli_query($conn, $getRoomQuery);

  if(!$getRoom)
    die("Error, select query failed:" . $getRoomQuery);

  if(mysqli_num_rows($getRoom)>0) {
    $row = mysqli_fetch_array($getRoom);
    $toReturn = array('currentUserAdmin' => ($row['admin'] == $_SESSION["username"]));
  }

  $getUsersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$roomName'";
  $getUsers = mysqli_query($conn, $getUsersQuery);

  if(!$getUsers)
    die("Error, select query failed:" . $getUsersQuery);

  if(mysqli_num_rows($getUsers)>0) {
    while ($row = mysqli_fetch_array($getUsers)) {
      $nome = $row['userName'];

      $userInfoQuery = "SELECT * FROM Users WHERE username = '$nome'";
      $getUserInfo = mysqli_query($conn, $userInfoQuery) or die("$userInfoQuery Failed");

      $userInfoRow = mysqli_fetch_array($getUserInfo);

      $user = array($nome, $userInfoRow["vitorias"], $userInfoRow["derrotas"], $userInfoRow["photoUpload"]);

      array_push($players, $user);
    }
  }

  $toReturn["players"] = $players;

  echo json_encode($toReturn);
?>
