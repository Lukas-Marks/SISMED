<?php
include 'Conectar.php';
header('Content-Type: application/json');

$termo = $_GET['termo'] ?? '';
$sql = $conn->prepare("SELECT nome, cpf, data_nascimento, telefone FROM pacientes WHERE nome LIKE ? LIMIT 10");
$like = "%$termo%";
$sql->bind_param("s", $like);
$sql->execute();
$result = $sql->get_result();

$pacientes = [];
while ($row = $result->fetch_assoc()) {
    $pacientes[] = $row;
}

echo json_encode($pacientes);
?>
