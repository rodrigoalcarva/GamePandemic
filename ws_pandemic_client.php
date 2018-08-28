<?php
  require_once "lib/nusoap.php";

  $client = new nusoap_client('http://appserver-01.alunos.di.fc.ul.pt/~asw002/Pandemic/ws_make_play.php');

  $error = $client->getError();
  $result = $client->call('fazJogada', array('ID' => 0, 'username' => "tester", 'password' => "tester", 'jogada' => "move", 'cidade' => 'Madrid'));

  echo "$result \n";
?>
