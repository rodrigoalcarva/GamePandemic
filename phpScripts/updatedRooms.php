<?php
  include "accessBD.php";
  $roomName = $_GET["roomName"];
  $salas = array();
  $jogsSala = array();

  $getNameQuery = "SELECT * FROM Rooms";
  $getNameStatus = mysqli_query($conn, $getNameQuery);

  if(!$getNameStatus)
    die("Error, select query failed:" . $getNameStatus);

  if(mysqli_num_rows($getNameStatus)>0) {
    while ($row = mysqli_fetch_array($getNameStatus)) {
      $nome = $row['nome'];
      $descricao = $row['descricao'];
      $numMaxJog = $row['numMaxJog'];
      $numAtuaisJog = $row['numAtuaisJog'];
      $estadoJogo = $row['estadoJogo'];
      $players = "";

      $playersQuery = "SELECT userName FROM RoomPlayers WHERE roomName = '$nome'";
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

      array_push($salas, array("nome" => $nome,
                              "descricao" => $descricao,
                              "numMaxJog" => $numMaxJog,
                              "numAtuaisJog" => $numAtuaisJog,
                              "estadoJogo" => $estadoJogo,
                              "jogadores" => $players)
      );
    }
  }

  echo json_encode($salas);

?>
