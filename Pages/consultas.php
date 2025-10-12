<?php
include '../ConexaoBD/conectar.php';

// Data de hoje no formato 'Y-m-d'
//$hoje = date('Y-m-d');

// Verifica se uma data foi passada via GET, senão usa a data atual
$dataConsulta = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Prepara a consulta para buscar apenas as consultas de hoje
$sql = "
SELECT 
    consultas.*,
    pacientes.nome AS nome_paciente,
    medicos.nome AS nome_medico
FROM 
    consultas
JOIN 
    pacientes ON consultas.paciente_id = pacientes.id
JOIN 
    medicos ON consultas.medico_id = medicos.id
WHERE 
    DATE(data_consulta) = ?
ORDER BY 
    data_consulta ASC
";

$stmt = $conexao->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conexao->error);
}
$stmt->bind_param("s", $dataConsulta);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Consultas Agendadas</title>
  <link rel="stylesheet" href="../CSS/cadastro_pacientes.css">
</head>
<body>
  <div class="container">
    <h2>Consultas Agendadas para <?php echo date('d/m/Y', strtotime($dataConsulta)); ?></h2>
    <ul>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($consulta = $result->fetch_assoc()): ?>
          <li>
            <strong><?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></strong> - 
            Paciente: <?php echo htmlspecialchars($consulta['nome_paciente']); ?> / 
            Médico: <?php echo htmlspecialchars($consulta['nome_medico']); ?><br>
            <small><?php echo nl2br(htmlspecialchars($consulta['descricao'])); ?></small>
          </li>
        <?php endwhile; ?>
      <?php else: ?>
        <li>Nenhuma consulta agendada para hoje.</li>
      <?php endif; ?>
    </ul>
    <br>
    <a href="agendar.php">Voltar para Agendamento</a>
    <br><br>

    <a href="../Pages/pagina-principal.php" class="botao-voltar">Voltar ao Início</a>
  </div>
</body>
</html>

<?php
$stmt->close();
$conexao->close();
?>
