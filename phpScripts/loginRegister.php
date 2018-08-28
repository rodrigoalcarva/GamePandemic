<?php
  session_start();
  include "accessBD.php";


  //Register
  if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = sha1($password);
    $email = $_POST["email"];
    $question = $_POST["question"];
    $answer = $_POST["resposta"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $country = $_POST["country"];
    $district = $_POST["district"];
    $concelho = $_POST["concelho"];

    //Check user ja resgistado
    $usernameQuery="select * from Users WHERE username='$username'";
    $checkUsername = mysqli_query($conn, $usernameQuery);

    if(mysqli_num_rows($checkUsername)>0) {
      $_SESSION['messageReceived'] = "Nome de utilizador $username ja se encontra registado. Tente outro nome!";
    }

    else {
      //Check email ja resgistado
      $emailQuery="select * from Users WHERE email='$email'";
      $checkEmail = mysqli_query($conn, $emailQuery);

      if(mysqli_num_rows($checkEmail)>0) {
        $_SESSION['messageReceived'] = "Email $email ja se encontra registado. Tente outro email!";
      }

      else {
        $uploadOk = True;
        $userUpload = NULL;
        if ($_FILES['avatar']['size'] != 0) {
          //upload image
          $target_dir = "userImages/";
          $extension = explode(".", $_FILES["avatar"]["name"]);
          $target_file = $target_dir . $username . "." . end($extension);
          $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
          $userUpload = "sim";

          if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $uploadOk = False;
            $_SESSION['messageReceived'] = "Houve um erro a dar upload do ficheiro";
          }
        }
        //Check password iguais ja resgistado FALTA METER EM JS NO CLIENT
        if ($password == $_POST["passwordConfirm"] && $uploadOk) {
          $registerQuery = "INSERT INTO Users
                            VALUES ('$username', '$hashed_password', '$email', '$firstName', '$lastName', '$gender', '$birthday', '$country', '$district', '$concelho','$question','$answer', 0, 0, 0, '$userUpload')";

          $register = mysqli_query($conn, $registerQuery);

          if(!$register)
            die("Error, insert query failed:" . $registerQuery);
          }

        else {
          $_SESSION['messageReceived'] = "Passwords não compativeis";
        }
      }

    }
  }

  //Login
  if (isset($_POST["login"]) && !$logedInt) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usernameQuery="SELECT * FROM Users WHERE username='$username'";
    $checkUsername = mysqli_query($conn, $usernameQuery);

    if(mysqli_num_rows($checkUsername)==0) {
      $_SESSION['messageReceived'] = "Nome de utilizador $username nao se encontra registado";
    }

    else {
    	$passwordQuery = "SELECT *
    									From Users
    									Where username = '$username'";

    	$passwordLogin = mysqli_query($conn, $passwordQuery);

      $row = mysqli_fetch_array($passwordLogin);

      $hashed_password = sha1($password);

      if ($hashed_password == $row["password"]) {
    	   $_SESSION['username'] = $username;
      }

      else {
    		$_SESSION['messageReceived'] = 'Password nao corresponde';
    	}
    }
  }

  mysqli_close($conn);
  header('Location: ../index.php');
?>
