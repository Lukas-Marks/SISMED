<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="estilo.css">
    
    
    <title>TESTE BACK- ESQUECI SENHA</title>
</head>

<body>
      <div class="w3-container w3-display-middle w3-card w3-padding w3-round w3-third">
        <h3 class="w3-center">ATÉ AQUI TUDO CERTO!!</h3> </div>

    <?php

    // criar variaveis para conexao com Banco de dadoos phpmyadmin, usando usbserver    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sismed";

    // Fazer a conexão com o banco de dados MySQLi
    $conexao = new mysqli($servername, $username, $password, $dbname);


    // Verificar se a conexão foi bem-sucedida
    if ($conexao->connect_error) {
        die("Connection failed: " . $conexao->connect_error);
    }


    // Fechar a conexão com o banco de dados    
    $conexao->close();
    ?>

</body>

</html>