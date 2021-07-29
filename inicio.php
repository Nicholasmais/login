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


  $link = mysqli_connect("localhost","root","","login");
    
    
   if ($link === false){
       die(" <br>ERRO".mysqli_connect_error());
   }

   $user = mysqli_real_escape_string($link,$_POST['usuario']);
   $_SESSION['user'] = $user;
   
   $pass = (mysqli_real_escape_string($link,$_POST['pass']));
   $_SESSION['pass'] = $pass;
   $query = $link->prepare("select * from cadastro where usuario = ?");
   $query -> bind_param("s",$user);
   $query ->execute();
   $result=  $query->get_result();
   $row1 = mysqli_fetch_array($result);

   if (mysqli_num_rows($result)>0 && password_verify($pass,$row1["senha"])){
    header("Location:conta.php"); 
    exit;
    }
   
   else{
     echo "Usuário ou senha inválidos! ";
   }


    mysqli_close($link);
  ?>
  
  
</body>
</html>