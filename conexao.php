<?php
$servidor = "localhost";
$usuario = "root";
$senha = ""; 
$banco = "sismed";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die(json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]));
}

mysqli_set_charset($conn, "utf8");
?>
