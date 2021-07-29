<!DOCTYPE  html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
.mensagem{
  height: 100px;
width: 250px;
background-color: #6ecaa9;
top: 2.5%;
left: 50%;
margin-left: -125px;;
position: absolute;
border-radius: 4px;
text-align: center;

}
        
    </style>
</head>
<body>
  
    <?php
   
    include 'index.html';
    

  $link = mysqli_connect("localhost","root","","login");
    
    
    if ($link === false){
        die(" <br>ERRO".mysqli_connect_error());
    }
    session_start();

    $user = mysqli_real_escape_string($link,$_POST["Usuario"]);
    $pass = (mysqli_real_escape_string($link,$_POST["pass"]));
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    $confpass = (mysqli_real_escape_string($link,$_POST["confpass"]));
    $pais = mysqli_real_escape_string($link,$_POST["Pais"]);
    $text = mysqli_real_escape_string($link,$_POST["texto"]);
     
    
    $_SESSION['hashpass'] = $hashpass;

    $stmt = $link->query("SELECT usuario FROM cadastro WHERE usuario='$user'");

    if (empty($user) || empty($pass) || empty($confpass) || empty($pais)){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Preencha todas as colunas!</label>
        </div>";

            }

    elseif ($stmt->num_rows != 0){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Usuário $user já cadastrado!</label>
        </div>"; 
        }

    elseif ($pass != $confpass){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>As senhas não batem!</label>
        </div>";
    }

    elseif (strlen($pass) < 8){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Sua senha deve ter no mínimo 8 digitos.</label>
        </div>";
    }

    elseif (strlen($user) < 5){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Seu usuario deve ter mais de 4 digitos.</label>
        </div>";
    }

    if (! move_uploaded_file($_POST['file'],"C:/Users/nicoe/Desktop/Estudo/codigos/PHP/login/dir")){
        echo "<div class='row'>
        <div class='col-25'>
        <label for='pais'>Envie uma foto!.</label>
        </div>";
    }

    else {

$stmt = $link->prepare("INSERT INTO cadastro (usuario, senha,pais ,texto) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $user,$hashpass,$pais,$text);

if($stmt->execute()){
    echo "<div class='mensagem'>
    Dados salvos com sucesso!
    </div>";
    $stmt->close();

} else{
    echo "<div class='mensagem'>
    ERROR: Falha ao salvar os dados $sql. 
    </div>" . mysqli_error($link);
}

    mysqli_close($link);
}
    ?>
</body>



</html>