<?php
	session_start();
?>

<html>
<head>
</head>
<body>
  <form action="" method="post">
    <label> Nome de utilizador:
      <input type="text" name="username">
    </label>
    <input type="submit" name="recover">
  </form>
</body>
</html>

<?php
  include "accessBD.php";
  if (isset($_POST["recover"])) {
    $username = $_POST['username'];
    $_SESSION['recoverUsername'] = $username;

    $searchQuery = "SELECT *
                    FROM Users
                    WHERE username = '$username'";

    $search = mysqli_query($conn, $searchQuery);

    if(!$search)
       die("Error, select query failed:" . $searchQuery);

    $row = mysqli_fetch_array($search);

    $_SESSION['recoverAnswer'] = $row["answer"];

    if ($row['question'] == "1animal") {
      $question = "Qual é o nome do seu 1º animal de estimação ?";
    }

    else if ($row['question'] == "localNascimento") {
      $question = "Qual é o local de nascimento da sua mãe ?";
    }
    else if ($row['question'] == "escolaPrimaria") {
      $question = "Qual é o nome da sua escola primária ?";
    }
    else if ($row['question'] == "desportoFavorito") {
      $question = "Qual é o seu desporto favorito?";
    }

    echo "Pergunta de segurança: " . $question;
    echo "<form action='' method='post'>
            <label> Resposta:
              <input type='text' name='answer'>
            </label>
            <input type='submit' name='submitQuestion'>
          </form>";
  }

  if (isset($_POST["submitQuestion"])) {
    if ($_POST['answer'] == $_SESSION['recoverAnswer']) {
      echo "Correto!";
      echo "<form action='' method='post'>
              <label> Nova password:
                <input type='password' name='newPassword'>
              </label>
              <input type='submit' name='submitPassword'>
            </form>";
    }
		else{
			echo "Está errado! Tente novamente";
		}
  }

  if (isset($_POST["submitPassword"])) {
      $hashed_password = sha1($_POST['newPassword']);
      $username = $_SESSION['recoverUsername'];
      $updateQuery = "UPDATE Users
                      SET password = '$hashed_password'
                      WHERE username = '$username'";

      $update = mysqli_query($conn, $updateQuery);

      if(!$update)
         die("Error, select query failed:" . $updateQuery);


      $_SESSION['messageReceived'] = "Password alterada!";
			unset($_SESSION);
		  session_destroy();
      header('Location: index.php');
  }

  mysqli_close($conn);
?>
