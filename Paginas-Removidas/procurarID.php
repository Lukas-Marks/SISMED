<?php 

// Conexão com o banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sismed";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = $_POST['id'] ?? '';


$sql = "SELECT * FROM pacientes WHERE id = ? OR cpf = ?";

?>