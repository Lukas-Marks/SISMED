<?php
include 'conexao.php';

$nome = $_POST['nome_completo'];
$cpf = $_POST['cpf'];
$data_nasc = $_POST['data_nascimento'];
$telefone = $_POST['telefone'];
$especialidade = $_POST['especialidade'];
$medico = $_POST['medico'];
$data_consulta = $_POST['data_consulta'];
$horario = $_POST['horario'];
$tipo = $_POST['tipo_consulta'];
$observacoes = $_POST['observacoes'];

$sql = "INSERT INTO agendamentos 
(nome_completo, cpf, data_nascimento, telefone, especialidade, medico, data_consulta, horario, tipo_consulta, observacoes, status)
VALUES 
('$nome', '$cpf', '$data_nasc', '$telefone', '$especialidade', '$medico', '$data_consulta', '$horario', '$tipo', '$observacoes', 'Confirmado')";

if ($conn->query($sql) === TRUE) {
  echo "<script>alert('Agendamento salvo com sucesso!'); window.location='agendar.php';</script>";
} else {
  echo "Erro: " . $conn->error;
}

$conn->close();
?>