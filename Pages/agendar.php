<?php 
require_once 'verifica_acesso.php';

// Bloqueia o acesso para médicos
bloquear_acesso_para(['Medico']);

include 'Conectar.php';
include 'cabecalho.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Agendamento de Consulta</title>
  <link rel="stylesheet" href="../CSS/Cabecalho.css">
  <link rel="stylesheet" href="../CSS/rodape.css">
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
      <select name="especialidade" id="especialidade" onchange="carregarMedicosPorEspecialidade()" required>
        <option value="">--  Selecione a Especialidade  --</option>
        <option value="Cardiologia">Cardiologia</option>
        <option value="Pediatria">Pediatria</option>
        <option value="Clínico Geral">Clínico Geral</option>        
      </select>

      <label>Médico desejado (opcional):</label>
      <select name="medico_id" id="medico" required>
        <option value="">-- Selecione a Especialidade Primeiro --</option>
      </select>

      <label>Data da consulta:</label>
      <input type="date" name="data_consulta" required>

      <label>Horário disponível:</label>
      <input type="time" name="horario" required>

      <label>Tipo de consulta:</label>
      <div class="radio-group">
        <input type="radio" name="tipo_consulta" value="Presencial" checked> Presencial
        <input type="radio" name="tipo_consulta" value="Teleconsulta"> Teleconsulta
      </div>

      <label>Observações:</label>
      <textarea name="observacoes" rows="3"></textarea>

      <div class="buttons">
        <button type="submit" class="confirmar">Confirmar Agendamento</button>
        <button type="reset" class="limpar">Limpar Campos</button>
      </div>

      <div class="buttons" >
      <button type="button" 
      
      style="
        background-color: #007bff;
        color: white;     
      " onclick="window.location.href='calendario.php'">
      Calendário
      </button>

      
      <button type="button" 
      
      style="
        background-color: #007bff;
        color: white;        
      " onclick="window.location.href='../Pages/pagina-principal.php'">
        Voltar 
      </button>
    </div>

    </form>
  </div>

  <script>
    function carregarMedicosPorEspecialidade() {
      const especialidade = document.getElementById('especialidade').value;
      const medicoSelect = document.getElementById('medico');

      if (!especialidade) {
        medicoSelect.innerHTML = '<option value="">-- Selecione a especialidade primeiro --</option>';
        return;
      }

      fetch('buscar_medicos.php?especialidade=' + encodeURIComponent(especialidade))
        .then(response => response.json())
        .then(data => {
          medicoSelect.innerHTML = '';

          if (data.length > 0) {
            medicoSelect.innerHTML = '<option value="">-- Selecione o médico --</option>';
            data.forEach(medico => {
              const option = document.createElement('option');
              option.value = medico.id;
              option.textContent = medico.nome;
              medicoSelect.appendChild(option);
            });
          } else {
            medicoSelect.innerHTML = '<option value="">Nenhum médico disponível</option>';
          }
        })
        .catch(error => {
          console.error('Erro ao buscar médicos:', error);
          medicoSelect.innerHTML = '<option value="">Erro ao carregar médicos</option>';
        });
    }
  </script>

  <?php include 'rodape.php'; ?>
</body>
</html>
