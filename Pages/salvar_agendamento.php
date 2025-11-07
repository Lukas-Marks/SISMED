<?php
session_start();
include 'Conectar.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não autenticado. Faça login para continuar.");
}

// Recebe dados do POST e remove espaços extras
$nome = isset($_POST['nome_completo']) ? trim($_POST['nome_completo']) : null;
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : null;
$data_nasc = isset($_POST['data_nascimento']) ? trim($_POST['data_nascimento']) : null;
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : null;
$especialidade = isset($_POST['especialidade']) ? trim($_POST['especialidade']) : null;
$medico_id = isset($_POST['medico_id']) ? intval($_POST['medico_id']) : 0;
$data_consulta = isset($_POST['data_consulta']) ? trim($_POST['data_consulta']) : null;
$horario = isset($_POST['horario']) ? trim($_POST['horario']) : null;
$tipo = isset($_POST['tipo_consulta']) ? trim($_POST['tipo_consulta']) : null;
$observacoes = isset($_POST['observacoes']) ? trim($_POST['observacoes']) : null;

// Verifica campos obrigatórios
if (!$nome || !$cpf || !$data_nasc || !$telefone || !$especialidade || !$medico_id || !$data_consulta || !$horario || !$tipo) {
    die("Erro: Todos os campos obrigatórios devem ser preenchidos.");
}

// Valida formato da data de nascimento e data da consulta (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_nasc)) {
    die("Formato da data de nascimento inválido.");
}
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_consulta)) {
    die("Formato da data da consulta inválido.");
}

// Valida horário (HH:MM)
if (!preg_match('/^\d{2}:\d{2}$/', $horario)) {
    die("Formato do horário inválido.");
}

// Verifica se as datas são válidas
if (!strtotime($data_nasc) || !strtotime($data_consulta)) {
    die("Data inválida fornecida.");
}

// Junta data e hora para salvar no campo DATETIME
//$data_hora = $data_consulta . ' ' . $horario . ':00';

$data_hora = date('Y-m-d H:i:s', strtotime("$data_consulta $horario"));



// Prepara o SQL para inserir no campo data_consulta (DATETIME)
$sql = "INSERT INTO agendamentos 
(nome_completo, cpf, data_nascimento, telefone, especialidade, medico_id, data_consulta, tipo_consulta, observacoes, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmado')";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar statement: " . $conn->error);
}

// Ajusta tipos para bind_param (9 parâmetros)
// s = string, i = integer
$stmt->bind_param(
    "sssssisss",
    $nome,
    $cpf,
    $data_nasc,
    $telefone,
    $especialidade,
    $medico_id,
    $data_hora,
    $tipo,
    $observacoes
);

// Executa e verifica sucesso
if ($stmt->execute()) {
    echo "<script>alert('Agendamento salvo com sucesso!'); window.location='agendar.php';</script>";
} else {
    error_log("Erro ao salvar agendamento: " . $stmt->error);
    echo "<script>alert('Erro ao salvar agendamento. Tente novamente mais tarde.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
