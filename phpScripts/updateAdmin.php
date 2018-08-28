<?php
  include "accessBD.php";
  session_start();
  $response = array();
  $username = $_GET["username"];
  $country = $_GET["country"];
  $district = $_GET["district"];
  $concelho = $_GET["concelho"];
  $faixaEtaria = $_GET["faixaEtaria"];

  $jogosEmEspera = $_GET["jogosEmEspera"];
  $jogosEmJogo = $_GET["jogosEmJogo"];
  $jogosFinalizados = $_GET["jogosFinalizados"];

  $nameGame = $_GET["nameGame"];
  $descriptionGame = $_GET["descriptionGame"];
  $chefGame = $_GET["chefGame"];

  if (isset($username)){
    $getUserQuery = "SELECT *
                    FROM Users
                    WHERE username = '$username'";

    $getUser = mysqli_query($conn, $getUserQuery);

    if(!$getUser)
      die("Error, select query failed:" . $getUserQuery);

    if(mysqli_num_rows($getUser)>0) {
        while ($row = mysqli_fetch_array($getUser)) {
          array_push($response,$row);
        }
    }
  }

  if (isset($country)){
    $getCountryQuery = "SELECT *
                    FROM Users
                    WHERE country = '$country'";

    $getCountry = mysqli_query($conn, $getCountryQuery);

    if(!$getCountry)
      die("Error, select query failed:" . $getCountryQuery);

    if(mysqli_num_rows($getCountry)>0) {
        while ($row = mysqli_fetch_array($getCountry)) {
          array_push($response,$row);
        }
    }
  }

  if (isset($district)){
    $getDistrictQuery = "SELECT *
                        FROM Users
                        WHERE district = '$district'";

    $getDistrict = mysqli_query($conn, $getDistrictQuery);

    if(!$getDistrict)
      die("Error, select query failed:" . $getDistrictQuery);

    if(mysqli_num_rows($getDistrict)>0) {
        while ($row = mysqli_fetch_array($getDistrict)) {
          array_push($response,$row);
        }
    }
  }

  if (isset($concelho)){
    $getConcelhoQuery = "SELECT *
                        FROM Users
                        WHERE concelho = '$concelho'";

    $getConcelho = mysqli_query($conn, $getConcelhoQuery);

    if(!$getConcelho)
      die("Error, select query failed:" . $getConcelhoQuery);

    if(mysqli_num_rows($getConcelho)>0) {
        while ($row = mysqli_fetch_array($getConcelho)) {
          array_push($response,$row);
        }
    }
  }

  if (isset($jogosEmEspera)){
    $getGamesWaitQuery = "SELECT *
                    FROM Rooms
                    WHERE estadoJogo = 'Em_Espera'";

    $getGamesWait = mysqli_query($conn, $getGamesWaitQuery);

    if(!$getGamesWait)
       die("Error, select query failed:" . $getGamesWaitQuery);

    if(mysqli_num_rows($getGamesWait)>0) {
      while ($row = mysqli_fetch_array($getGamesWait)) {
        array_push($response,$row);
      }
    }
  }

  if (isset($jogosEmJogo)){
    $getGamesStartedQuery =  "SELECT *
                          FROM GameState
                          WHERE roomName in (select nome
                                            FROM Rooms
                                            WHERE estadoJogo = 'Em_Jogo')";

    $getGamesStarted = mysqli_query($conn, $getGamesStartedQuery);

    if(!$getGamesStarted)
       die("Error, select query failed:" . $getGamesStartedQuery);

    if(mysqli_num_rows($getGamesStarted)>0) {
      while ($row = mysqli_fetch_array($getGamesStarted)) {
        array_push($response,$row);
      }
    }
  }

  if (isset($jogosFinalizados)){
    $getGamesFinishedQuery =  "SELECT *
                              FROM FinishedGames";

    $getGamesFinished = mysqli_query($conn, $getGamesFinishedQuery);

    if(!$getGamesFinished)
       die("Error, select query failed:" . $getGamesFinishedQuery);

    if(mysqli_num_rows($getGamesFinished)>0) {
      while ($row = mysqli_fetch_array($getGamesFinished)) {
        array_push($response,$row);
      }
    }
  }

  if (isset($nameGame)){
    $getGameNameQuery = "SELECT *
                    FROM GameState
                    WHERE roomName = '$gameName'";

    $getGamesName = mysqli_query($conn, $getGameNameQuery);

    if(!$getGamesName)
       die("Error, select query failed:" . $getGameNameQuery);

    if(mysqli_num_rows($getGamesName)>0) {
      while ($row = mysqli_fetch_array($getGamesName)) {
        array_push($response,$row);
      }
    }
  }

  if (isset($descriptionGame)){
    $getGameDescriptionQuery = "SELECT *
                                FROM GameState
                                WHERE roomName in (SELECT nome
                                                  FROM Rooms
                                                  WHERE descricao = '$description')";

    $getGamesDescription = mysqli_query($conn, $getGameDescriptionQuery);

    if(!$getGamesDescription)
       die("Error, select query failed:" . $getGameDescriptionQuery);

    if(mysqli_num_rows($getGamesDescription)>0) {
      while ($row = mysqli_fetch_array($getGamesDescription)) {
        array_push($response,$row);
      }
    }
  }

  if (isset($chefGame)){
    $getGameChefQuery = "SELECT *
                                FROM GameState
                                WHERE roomName in (SELECT nome
                                                  FROM Rooms
                                                  WHERE admin = '$chef')";

    $getGamesChef = mysqli_query($conn, $getGameChefQuery);

    if(!$getGamesChef)
       die("Error, select query failed:" . $getGameChefQuery);

    if(mysqli_num_rows($getGamesChef)>0) {
      while ($row = mysqli_fetch_array($getGamesChef)) {
        array_push($response,$row);
      }
    }
  }

  echo json_encode($response);

 ?>
