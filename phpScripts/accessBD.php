<?php
  $dbhost = "appserver-01.alunos.di.fc.ul.pt";
  $dbuser = "asw002";
  $dbpass = "asw002";
  $dbname = "asw002";
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

  if (mysqli_connect_error()) {
    die("Database connection failed:".mysqli_connect_error());
  }
?>
