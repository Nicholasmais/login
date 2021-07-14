<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
    input[type=submit], #entrar, button{
    background-color: #04AA6D;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }


  a{
      text-decoration: none;
      color: white;
    }

  input[type=submit]:hover, #entrar:hover, button:hover{
    background-color: #0a5237;
}
</style>
<body>
  <?php
  session_start();

  $link = mysqli_connect("localhost","root","","login");
  $user = $_SESSION['user'];
 
  $query = $link->prepare("select * from cadastro where usuario = ?");
  $query -> bind_param("s",$user);
  $query ->execute();
  $result=  $query->get_result();
  $row1 = mysqli_fetch_array($result);
 
  echo"
  <div>

    <fieldset>
    
    <h1>Ola ", print_r($_SESSION['user'],true); echo", tudo bem?</h1>
      <hr>
    <div class='text'>
    ",  $row1['texto']; echo"
      

    </div>
  
    <div id='row'>
      <button  style='margin-top: 6px;'><a href='inicio.html' style='float: left;'>Sair</a>
      </button></div>

    <div id='row'>
      <button  style='margin-top: 6px;'><a href='alterar_dados.html' style='float: right;'>Alterar dados</a>
      </button></div>
    </fieldset>


  </div>
  ";

  ?>
</body>
</html>