<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  session_start();
  include 'alterar_dados.html';

  $link = mysqli_connect("localhost","root","","login");
    
    
  if ($link === false){
      die(" <br>ERRO".mysqli_connect_error());
  }
  $olduser = $_SESSION['user'];

  $resultado = mysqli_query($link,"SELECT userid FROM cadastro WHERE usuario = '$olduser'");
  $resultado2 = mysqli_fetch_array($resultado);

  $id=$resultado2['userid'];
 
  if (!empty($_POST["UpUsuario"])){
    $user = $_POST["UpUsuario"]; }
  else{
    $user = $_SESSION["user"];  }
  

  if (!empty($_POST["Uppass"])){
    $pass = $_POST["Uppass"];  }
  else{
    $pass = $_SESSION["pass"]; }


  if (!empty($_POST["Upconfpass"])){
    $confpass = $_POST["Upconfpass"];  }
  else{
    $confpass = $_SESSION['pass'];}


  $pais = isset($_POST["UpPais"])?$_POST['UpPais']:$_SESSION['Pais'];

  $text = isset($_POST["Uptexto"])?$_POST['Uptexto']:$_SESSION['texto'];
  $_SESSION["texto"] = $text;
  $stmt = $link->query("SELECT usuario FROM cadastro WHERE usuario='$user'");

  if ($pass != $confpass){
    echo "<div class='row'>
    <div class='col-25'>
    <label for='pais'>As senhas não batem!</label>
    </div>";
  }

  elseif($stmt->num_rows > 1){
      echo "<div class='row'>
      <div class='col-25'>
      <label for='pais'>Usuário já cadastrado!</label>
      </div>";    }

      elseif (strlen($pass) < 8){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Sua senha deve ter no mínimo 8 digitos. </label>
        </div>";
    }

    elseif (strlen($user) < 5){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Seu usuario deve ter mais de 4 digitos.</label>
        </div>";
    }
      
  else{
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $link->prepare( "UPDATE cadastro SET usuario = ?, senha = ?, pais = ?, texto = ? WHERE userid = ?;");
    $stmt->bind_param("ssssi", $user,$hashpass,$pais,$text, $id);
    $_SESSION['user'] = $user;
    $_SESSION['hashpass'] = $hashpass;

    if($stmt->execute()){
      echo "<div class='mensagem'>
      Dados salvos com sucesso! $user $pass
      </div>";
      $stmt->close();
    } else{

      echo "<div class='mensagem'>
      ERROR: Falha ao salvar os dados $sql. 
      </div>" . mysqli_error($link);
    }}


mysqli_close($link);
  ?>
</body>
</html>