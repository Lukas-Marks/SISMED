<?php
include 'conexao.php';

$id = $_GET['id'];
$sql = "SELECT * FROM agendamentos WHERE id = $id";
$result = $conn->query($sql);
$agendamento = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Agendamento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 420px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    h2 {
      text-align: center;
      color: #0d2356;
    }
    input, select, textarea {
      width: 100%;
      margin: 8px 0;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    textarea {
      resize: none;
      height: 60px;
    }
    button {
      width: 48%;
      padding: 10px;
      margin-top: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: white;
      font-weight: bold;
    }
    .salvar {
      background-color: #28a745;
    }
    .voltar {
      background-color: #007bff;
    }
    .excluir {
      background-color: #dc3545;
      width: 100%;
      margin-top: 10px;
    }
    .caixa-info {
      background-color: #f8f9fa;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .caixa-info strong {
      display: block;
      color: #0d2356;
      margin-bottom: 4px;
    }
  </style>
</head>
<body>
  <form action="atualizar_agendamento.php" method="POST">
    <h2>Editar Agendamento</h2>
    <input type="hidden" name="id" value="<?= $agendamento['id'] ?>">

    <label>Nome completo</label>
    <input type="text" name="nome_completo" value="<?= $agendamento['nome_completo'] ?>" required>

    <label>Especialidade</label>
    <input type="text" name="especialidade" value="<?= $agendamento['especialidade'] ?>">

    <label>Data da consulta</label>
    <input type="date" name="data_consulta" value="<?= $agendamento['data_consulta'] ?>" required>

    <label>Horário</label>
    <input type="time" name="horario" value="<?= $agendamento['horario'] ?>" required>

    <label>Status</label>
    <select name="status">
      <option value="Confirmado" <?= $agendamento['status'] == 'Confirmado' ? 'selected' : '' ?>>Confirmado</option>
      <option value="Cancelado" <?= $agendamento['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
    </select>

    <div class="caixa-info">
      <strong>Médico Desejado:</strong>
      <?= htmlspecialchars($agendamento['medico_desejado'] ?? 'Não informado') ?>
    </div>

    <div class="caixa-info">
      <strong>Observações:</strong>
      <?= nl2br(htmlspecialchars($agendamento['observacoes'] ?? 'Nenhuma observação')) ?>
    </div>

    <div style="display:flex; justify-content:space-between;">
      <button type="submit" class="salvar">Salvar</button>
      <button type="button" class="voltar" onclick="window.location.href='calendario.php'">Voltar</button>
    </div>

    <button type="button" class="excluir" onclick="excluirAgendamento(<?= $agendamento['id'] ?>)">Excluir Agendamento</button>
  </form>

  <script>
    function excluirAgendamento(id) {
      if (confirm("Tem certeza que deseja excluir este agendamento?")) {
        window.location.href = "excluir_agendamento.php?id=" + id;
      }
    }
  </script>
</body>
</html>
