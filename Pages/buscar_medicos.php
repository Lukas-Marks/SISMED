<?php
include 'Conectar.php';

$especialidade = $_GET['especialidade'] ?? '';

if (!$especialidade) {
    echo json_encode([]);
    exit;
}

// Buscar médicos com função 'Médico' e especialidade informada
$sql = "SELECT id, nome FROM usuarios WHERE funcao = 'Médico' AND especialidade = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $especialidade);
$stmt->execute();
$result = $stmt->get_result();

$medicos = [];
while ($row = $result->fetch_assoc()) {
    $medicos[] = [
        'id' => $row['id'],
        'nome' => $row['nome']
    ];
}

header('Content-Type: application/json');
echo json_encode($medicos);
?>
