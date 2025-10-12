<?php
include '../ConexaoBD/conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $paciente_id = $_POST['paciente_id'];
  $novo_paciente = trim($_POST['novo_paciente']);
  $medico_id = $_POST['medico_id'];
  $data = $_POST['data'];
  $hora = $_POST['hora'];
  $descricao = $_POST['descricao'];

  // Combina data e hora em um campo datetime
  $data_consulta = $data . ' ' . $hora . ':00';

// Se o campo "novo_paciente" foi preenchido
  if (!empty($novo_paciente)) {
    // Inserir o novo paciente na tabela pacientes
    $stmt_paciente = $conexao->prepare("INSERT INTO pacientes (nome) VALUES (?)");
    $stmt_paciente->bind_param("s", $novo_paciente);
    
    if ($stmt_paciente->execute()) {
      $paciente_id = $stmt_paciente->insert_id; // Pega o ID do novo paciente
    } else {
      die("Erro ao cadastrar novo paciente: " . $stmt_paciente->error);
    }

    $stmt_paciente->close();
  }
// Verifica se temos um paciente_id válido agora
  if (empty($paciente_id)) {
    die("Nenhum paciente foi selecionado ou informado.");
  }



  // Prepara a consulta SQL
  $stmt = $conexao->prepare("
    INSERT INTO consultas (paciente_id, medico_id, data_consulta, descricao) 
    VALUES (?, ?, ?, ?)
  ");

  if (!$stmt) {
    die("Erro na preparação da consulta: " . $conexao->error);
  }

  $stmt->bind_param("iiss", $paciente_id, $medico_id, $data_consulta, $descricao);

  if ($stmt->execute()) {
    header("Location: consultas.php");
    exit();
  } else {
    echo "Erro ao salvar consulta: " . $stmt->error;
  }

  $stmt->close();
  $conexao->close();
}
?>
