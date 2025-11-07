<?php
include 'Conectar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('ID do agendamento não fornecido.');
}

// Buscar dados do agendamento
$sql = "SELECT * FROM agendamentos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$agendamento = $result->fetch_assoc();

if (!$agendamento) {
    die('Agendamento não encontrado.');
}

// Extrair data e hora da consulta para os inputs
$data_hora = $agendamento['data_consulta'] ?? '';

$data_consulta = '';
$horario = '';

if ($data_hora) {
    $dt = new DateTime($data_hora);
    $data_consulta = $dt->format('Y-m-d');  // formato para input date
    $horario = $dt->format('H:i');          // formato para input time
}

// Buscar médicos da especialidade atual para preencher o select inicialmente
$especialidadeAtual = $agendamento['especialidade'] ?? '';
$medicoAtual = $agendamento['medico_desejado'] ?? '';

$sqlMedicos = "SELECT nome FROM usuarios WHERE funcao = 'Médico' AND especialidade = ?";
$stmtMed = $conn->prepare($sqlMedicos);
$stmtMed->bind_param("s", $especialidadeAtual);
$stmtMed->execute();
$resultMedicos = $stmtMed->get_result();

$medicos = [];
while ($row = $resultMedicos->fetch_assoc()) {
    $medicos[] = $row['nome'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Editar Agendamento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
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
      box-sizing: border-box;
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
      font-size: 15px;
      box-sizing: border-box;
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
    /* Ajuste para flex container dos botões */
    .botoes-container {
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<body>
  <form action="atualizar_agendamento.php" method="POST">
    <h2>Editar Agendamento</h2>
    <input type="hidden" name="id" value="<?= htmlspecialchars($agendamento['id']) ?>">

    <label>Nome completo</label>
    <input type="text" name="nome_completo" value="<?= htmlspecialchars($agendamento['nome_completo']) ?>" required>

    <label>Especialidade</label>
    <select name="especialidade" id="especialidade" onchange="carregarMedicosPorEspecialidade()" required>
      <option value="Cardiologia" <?= ($agendamento['especialidade'] == 'Cardiologia') ? 'selected' : '' ?>>Cardiologia</option>
      <option value="Pediatria" <?= ($agendamento['especialidade'] == 'Pediatria') ? 'selected' : '' ?>>Pediatria</option>
      <option value="Clínico Geral" <?= ($agendamento['especialidade'] == 'Clínico Geral') ? 'selected' : '' ?>>Clínico Geral</option>
    </select>

    <label>Médico desejado</label>
    <select name="medico_desejado" id="medico_desejado">
      <option value="">-- Selecione um médico --</option>
      <?php foreach ($medicos as $medico): ?>
        <option value="<?= htmlspecialchars($medico) ?>" <?= ($medico == $medicoAtual) ? 'selected' : '' ?>>
          <?= htmlspecialchars($medico) ?>
        </option>
      <?php endforeach; ?>
    </select>





    <label>Data da consulta</label>
    <input type="date" name="data_consulta" value="<?= htmlspecialchars($data_consulta) ?>" required>

    <label>Horário</label>
    <input type="time" name="horario" value="<?= htmlspecialchars($horario) ?>" required>

    <label>Status</label>
    <select name="status">
      <option value="Confirmado" <?= ($agendamento['status'] == 'Confirmado') ? 'selected' : '' ?>>Confirmado</option>
      <option value="Cancelado" <?= ($agendamento['status'] == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
      <option value="Faltou" <?= ($agendamento['status'] == 'Faltou') ? 'selected' : '' ?>>Faltou</option>
    </select>

    

    <label>Observações</label>
    <textarea name="observacoes" rows="3"><?= htmlspecialchars($agendamento['observacoes'] ?? '') ?></textarea>

    <div class="botoes-container">
      <button type="submit" class="salvar">Salvar</button>
      <button type="button" class="voltar" onclick="window.location.href='calendario.php'">Voltar</button>
    </div>

    <button type="button" class="excluir" onclick="excluirAgendamento(<?= htmlspecialchars($agendamento['id']) ?>)">Excluir Agendamento</button>
  </form>

  <script>
    function excluirAgendamento(id) {
      if (confirm("Tem certeza que deseja excluir este agendamento?")) {
        window.location.href = "excluir_agendamento.php?id=" + id;
      }
    }

    function carregarMedicosPorEspecialidade() {
      const especialidade = document.getElementById('especialidade').value;
      const medicoSelect = document.getElementById('medico_desejado');

      if (!especialidade) {
        medicoSelect.innerHTML = '<option value="">-- Selecione a especialidade primeiro --</option>';
        return;
      }

      fetch('buscar_medicos.php?especialidade=' + encodeURIComponent(especialidade))
        .then(response => response.json())
        .then(data => {
          medicoSelect.innerHTML = '<option value="">-- Selecione um médico --</option>';

          data.forEach(medico => {
            const option = document.createElement('option');
            option.value = medico.nome;
            option.textContent = medico.nome;
            medicoSelect.appendChild(option);
          });
        })
        .catch(() => {
          medicoSelect.innerHTML = '<option value="">Erro ao carregar médicos</option>';
        });
    }
  </script>
</body>
</html>
