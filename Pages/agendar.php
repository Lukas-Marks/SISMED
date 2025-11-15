<?php 
require_once 'verifica_acesso.php';
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
  <link rel="stylesheet" href="../CSS/agendar.css">
  <link rel="stylesheet" href="../CSS/reset.css">
</head>
<body>
<div class="container">
  <h2>Agendamento de Consulta</h2>
  <form action="salvar_agendamento.php" method="POST" autocomplete="off">
    
    <label>Nome completo:</label>
    <input type="text" name="nome_completo" id="nome_completo" required>
    <div id="lista-pacientes"></div>

    <label>CPF:</label>
    <input type="text" name="cpf" id="cpf">

    <label>Data de nascimento:</label>
    <input type="date" name="data_nascimento" id="data_nascimento">

    <label>Telefone:</label>
    <input type="text" name="telefone" id="telefone">

    <label>Especialidade médica:</label>
    <select name="especialidade" id="especialidade" onchange="carregarMedicosPorEspecialidade()" required>
      <option value="">-- Selecione a Especialidade --</option>
      <option value="Cardiologia">Cardiologia</option>
      <option value="Pediatria">Pediatria</option>
      <option value="Clínico Geral">Clínico Geral</option>
      <option value="Dermatologia">Dermatologia</option>
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

    <div class="buttons">
      <button type="button" style="background-color: #007bff; color: white;" onclick="window.location.href='calendario.php'">Calendário</button>
      <button type="button" style="background-color: #007bff; color: white;" onclick="window.location.href='../Pages/pagina-principal.php'">Voltar</button>
    </div>

  </form>
</div>

<!-- SCRIPT PARA CARREGAR MÉDICOS DINAMICAMENTE -->
<script>
function carregarMedicosPorEspecialidade() {
    const especialidade = document.getElementById('especialidade').value;
    const selectMedico = document.getElementById('medico');

    if (!especialidade) {
        selectMedico.innerHTML = '<option value="">-- Selecione a especialidade primeiro --</option>';
        return;
    }

    fetch(`buscar_medicos.php?especialidade=${encodeURIComponent(especialidade)}`)
        .then(response => response.json())
        .then(data => {
            selectMedico.innerHTML = '<option value="">-- Selecione o Médico --</option>';

            if (data.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Nenhum médico disponível';
                selectMedico.appendChild(option);
            } else {
                data.forEach(medico => {
                    const option = document.createElement('option');
                    option.value = medico.id;
                    option.textContent = medico.nome;
                    selectMedico.appendChild(option);
                });
            }
        })
        .catch(err => console.error('Erro ao buscar médicos:', err));
}
</script>

<?php include 'rodape.php'; ?>
</body>
</html>
