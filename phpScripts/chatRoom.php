<?php
  session_start();
  include "accessBD.php";

  $user = $_SESSION["username"];
  $message = $_GET["message"];
  $messages = array();

  if (isset($message)) {
    $addMessageQuery = "INSERT INTO chat (user, message)
                      VALUES ('$user', '$message')";

    $addMessage = mysqli_query($conn, $addMessageQuery) or die("Error, insert query failed:" . $addMessageQuery);
  }

  $showAllMessagesQuery = "SELECT * FROM chat";

  $getAllMessages = mysqli_query($conn, $showAllMessagesQuery) or die("Error, get query failed:" . $showAllMessagesQuery);

  while ($row = mysqli_fetch_array($getAllMessages)) {
    array_push($messages, array("user" => $row["user"], "message" => $row['message']));
  }

  echo json_encode($messages);
?>
