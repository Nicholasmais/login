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
 
  $user = isset($_POST["UpUsuario"])?$_POST["UpUsuario"]:$_SESSION['user'];

  
  $pass = isset($_POST["Uppass"])?$_POST['Uppass']:$_SESSION['pass'];
  $confpass = isset($_POST["Upconfpass"])?$_POST['Upconfpass']:$_SESSION['pass'];

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

  elseif($stmt->num_rows != 0){
      echo "<div class='row'>
      <div class='col-25'>
      <label for='pais'>Usuário já cadastrado!</label>
      </div>";    }

  else{
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $link->prepare( "UPDATE cadastro SET usuario = ?, senha = ?, pais = ?, texto = ? WHERE userid = ?;");
    $stmt->bind_param("ssssi", $user,$hashpass,$pais,$text, $id);
    $_SESSION['user'] = $user;
    $_SESSION['hashpass'] = $hashpass;

    if($stmt->execute()){
      echo "<div class='mensagem'>
      Dados salvos com sucesso!
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