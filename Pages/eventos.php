<?php
session_start();
include 'Conectar.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(['erro' => 'Usuário não autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Pega a função do usuário
$stmt = $conn->prepare("SELECT funcao FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['erro' => 'Usuário não encontrado']);
    exit;
}
$usuario = $result->fetch_assoc();
$funcao = $usuario['funcao'];

// Buscar agendamentos conforme função
if ($funcao === 'Médico') {
    $sql = "SELECT id, nome_completo, data_consulta, horario, status FROM agendamentos WHERE medico_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, nome_completo, data_consulta, horario, status FROM agendamentos";
    $result = $conn->query($sql);
}

$eventos = [];

while ($row = $result->fetch_assoc()) {
    $status = $row['status'] ?? '';
    $cor = '#6c757d'; // default

    if ($status === 'Confirmado') $cor = '#28a745';
    elseif ($status === 'Cancelado') $cor = '#ffc107';
    elseif ($status === 'Faltou') $cor = '#dc3545';

    $horarioFormatado = date('H:i:s', strtotime($row['horario']));

  //  $eventos[] = [
 //       'id'    => $row['id'],
 //       'title' => htmlspecialchars($horarioFormatado . ' - ' . $row['nome_completo']),
 //       'start' => $row['data_consulta'] . 'T' . $horarioFormatado,
 //       'color' => $cor
 //   ];

$eventos[] = [
    'id'    => $row['id'],
    'title' => htmlspecialchars(date('H:i', strtotime($row['data_consulta'])) . ' - ' . $row['nome_completo']),
    'start' => $row['data_consulta'],
    'color' => $cor
];


}

header('Content-Type: application/json');
echo json_encode($eventos);
exit;
