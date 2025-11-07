<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sismed";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$anamnese = $_POST['anamnese'] ?? '';
$exames_fisicos = $_POST['exames_fisicos'] ?? '';
$solicitacoes = $_POST['solicitacoes'] ?? '';
$prescricoes = $_POST['prescricao'] ?? '';
$paciente_id = $_POST['paciente_id'] ?? null;

// Validação básica
if (!$paciente_id) {
  echo "ID do paciente não foi informado.<br>";
  exit;
}

// Verifica se já existe registro para esse paciente
$check = $conn->prepare("SELECT id FROM prontuario WHERE paciente_id = ?");
$check->bind_param("i", $paciente_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  // Atualiza registro existente
  $sql = "UPDATE prontuario 
          SET anamnese = ?, exames_fisicos = ?, solicitacoes = ?, prescricao = ?, ultima_atualizacao = NOW() 
          WHERE paciente_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $anamnese, $exames_fisicos, $solicitacoes, $prescricoes, $paciente_id);
} else {
  // Insere novo registro
  $sql = "INSERT INTO prontuario (paciente_id, anamnese, exames_fisicos, solicitacoes, prescricao, ultima_atualizacao) 
          VALUES (?, ?, ?, ?, ?, NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issss", $paciente_id, $anamnese, $exames_fisicos, $solicitacoes, $prescricoes);
}

// Executa e redireciona
if ($stmt->execute()) {
  echo "<script>
    alert('Alterações salvas com sucesso!');
    window.location.href = 'prontuario.php?id=$paciente_id';
  </script>";
} else {
  echo "Erro ao salvar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
