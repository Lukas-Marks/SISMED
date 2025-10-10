<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Agendamento de Consulta</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6fb;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      background-color: #0d2356;
      color: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .radio-group {
      margin-top: 10px;
    }
    .buttons {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
      font-weight: bold;
    }
    .confirmar { background-color: #28a745; }
    .limpar { background-color: #6c757d; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Agendamento de Consulta</h2>
    <form action="salvar_agendamento.php" method="POST">
      <label>Nome completo:</label>
      <input type="text" name="nome_completo" required>

      <label>CPF:</label>
      <input type="text" name="cpf">

      <label>Data de nascimento:</label>
      <input type="date" name="data_nascimento">

      <label>Telefone:</label>
      <input type="text" name="telefone">

      <label>Especialidade médica:</label>
      <select name="especialidade">
        <option>Cardiologia</option>
        <option>Pediatria</option>
        <option>Clínico Geral</option>
      </select>

      <label>Médico desejado (opcional):</label>
      <input type="text" name="medico">

      <label>Data da consulta:</label>
      <input type="date" name="data_consulta" required>

      <label>Horário disponível:</label>
      <input type="time" name="horario" required>

      <label>Tipo de consulta:</label>
      <div class="radio-group">
        <input type="radio" name="tipo_consulta" value="Presencial" checked> Presencial
        <input type="radio" name="tipo_consulta" value="Teleconsulta"> Teleconsulta
      </div>

      <label>Observações adicionais:</label>
      <textarea name="observacoes" rows="3"></textarea>

      <div class="buttons">
        <button type="submit" class="confirmar">Confirmar Agendamento</button>
        <button type="reset" class="limpar">Limpar Campos</button>
      </div>
      <button type="button" style="
  background-color: #007bff;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  width: 100%;
  margin-top: 10px;
" onclick="window.location.href='calendario.php'">
  Voltar ao Calendário
</button>
    </form>
  </div>
</body>
</html>