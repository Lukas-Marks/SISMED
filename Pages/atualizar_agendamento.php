<?php
session_start();
include 'Conectar.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: calendario.php');
    exit;
}

$id = $_POST['id'] ?? null;
$nome_completo = $_POST['nome_completo'] ?? '';
$especialidade = $_POST['especialidade'] ?? '';
$data_consulta = $_POST['data_consulta'] ?? '';
$horario = $_POST['horario'] ?? '';
$status = $_POST['status'] ?? '';
$medico_desejado = $_POST['medico_desejado'] ?? '';
$observacoes = $_POST['observacoes'] ?? '';

if (!$id) {
    die('ID do agendamento não informado.');
}

// Validações básicas (pode expandir se quiser)
if (!$data_consulta || !$horario) {
    die('Data e horário são obrigatórios.');
}

// Une data e horário no formato DATETIME
$data_hora = date('Y-m-d H:i:s', strtotime("$data_consulta $horario"));

// Atualizar o agendamento (sem campo horário separado)
$sql = "UPDATE agendamentos SET 
    nome_completo = ?, 
    especialidade = ?, 
    data_consulta = ?, 
    status = ?, 
    medico_desejado = ?, 
    observacoes = ? 
    WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param(
    "ssssssi",
    $nome_completo,
    $especialidade,
    $data_hora,
    $status,
    $medico_desejado,
    $observacoes,
    $id
);

if ($stmt->execute()) {
    header('Location: calendario.php?msg=Agendamento atualizado com sucesso');
} else {
    echo "Erro ao atualizar: " . $stmt->error;
}
?>
