<?php
  include "accessBD.php";
  $roomStatus = $_GET["roomStatus"];
  $roomTime = $_GET["roomTime"];

  //muda tempo
  if (isset($roomTime)) {
    if ($roomTime == "allRooms")
      $gameTimeQuery = "SELECT creationTime, timeToStart FROM Rooms";

    else
      $gameTimeQuery = "SELECT creationTime, timeToStart FROM Rooms WHERE nome = '$roomTime'";

    $getGameTime = mysqli_query($conn, $gameTimeQuery);

  	if(!$getGameTime)
  		die("Error, select query failed:" . $gameTimeQuery);

  	if(mysqli_num_rows($getGameTime)>0) {
  		$allTimes = array();

      while ($row = mysqli_fetch_array($getGameTime)) {
  			array_push($allTimes, $row['timeToStart'] - (time() - $row['creationTime']));
  		}
  	}
    echo json_encode($allTimes);

  }



?>
