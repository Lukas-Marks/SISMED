<?php
// Conexão com o banco
include 'Conectar.php';

// Recebe a especialidade via GET
$especialidade = $_GET['especialidade'] ?? '';

// Se não houver especialidade, retorna array vazio
if (empty($especialidade)) {
    echo json_encode([]);
    exit;
}

// Prepara a query segura
$stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE funcao = 'Médico' AND especialidade = ?");
$stmt->bind_param("s", $especialidade);
$stmt->execute();

// Obtém os resultados
$result = $stmt->get_result();
$medicos = [];

while ($row = $result->fetch_assoc()) {
    $medicos[] = [
        'id' => $row['id'],
        'nome' => $row['nome']
    ];
}

// Define o tipo de retorno e envia o JSON
header('Content-Type: application/json');
echo json_encode($medicos);

// Fecha conexão e statement
$stmt->close();
$conn->close();
?>
