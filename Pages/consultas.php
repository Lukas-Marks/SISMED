<?php
session_start();
include 'verifica_acesso.php';
include 'Conectar.php';

// Pega dados da sessão
$funcao = $_SESSION['funcao'];
$usuario_id = $_SESSION['usuario_id'];

// Se for médico, pega o id do médico associado ao usuário logado
$medico_id = null;

if ($funcao === 'Medico') {
    $stmtMedico = $conn->prepare("SELECT id FROM medicos WHERE usuario_id = ?");
    $stmtMedico->bind_param("i", $usuario_id);
    $stmtMedico->execute();
    $resultMedico = $stmtMedico->get_result();

    if ($resultMedico->num_rows > 0) {
        $rowMedico = $resultMedico->fetch_assoc();
        $medico_id = $rowMedico['id'];
    } else {
        // Médico não encontrado, bloqueia acesso
        die("Médico não encontrado no sistema.");
    }
    $stmtMedico->close();
}

// Data selecionada (hoje ou passada via GET)
$dataConsulta = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Monta SQL e parâmetros conforme função
if ($funcao === 'Medico') {
    // Somente consultas do médico logado
    $sqlConsultas = "
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
        DATE(data_consulta) = ? AND medico_id = ?
    ORDER BY 
        data_consulta ASC
    ";

    $stmtConsultas = $conn->prepare($sqlConsultas);
    if (!$stmtConsultas) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmtConsultas->bind_param("si", $dataConsulta, $medico_id);
    $stmtConsultas->execute();
    $resultConsultas = $stmtConsultas->get_result();

    $sqlAgendamentos = "
    SELECT nome_completo, status, data_consulta
    FROM agendamentos
    WHERE DATE(data_consulta) = ? AND medico_id = ?
    ORDER BY data_consulta ASC
    ";

    $stmtAgendamentos = $conn->prepare($sqlAgendamentos);
    if (!$stmtAgendamentos) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmtAgendamentos->bind_param("si", $dataConsulta, $medico_id);
    $stmtAgendamentos->execute();
    $resultAgendamentos = $stmtAgendamentos->get_result();

} else {
    // Para outros perfis (Admin, Recepcionista), mostra tudo
    $sqlConsultas = "
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

    $stmtConsultas = $conn->prepare($sqlConsultas);
    if (!$stmtConsultas) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmtConsultas->bind_param("s", $dataConsulta);
    $stmtConsultas->execute();
    $resultConsultas = $stmtConsultas->get_result();

    $sqlAgendamentos = "
    SELECT nome_completo, status, data_consulta
    FROM agendamentos
    WHERE DATE(data_consulta) = ?
    ORDER BY data_consulta ASC
    ";

    $stmtAgendamentos = $conn->prepare($sqlAgendamentos);
    if (!$stmtAgendamentos) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmtAgendamentos->bind_param("s", $dataConsulta);
    $stmtAgendamentos->execute();
    $resultAgendamentos = $stmtAgendamentos->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Consultas e Agendamentos</title>
  <link rel="stylesheet" href="../CSS/cadastro_pacientes.css" />
  <link rel="stylesheet" href="../CSS/Pagina-Principal.css" />
  <style>
    .status-confirmado { color: #28a745; font-weight: bold; }
    .status-cancelado { color: #ffc107; font-weight: bold; }
    .status-faltou { color: #dc3545; font-weight: bold; }
    .status-default { color: #6c757d; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Agenda do dia <?php echo date('d/m/Y', strtotime($dataConsulta)); ?></h2> <br>

    <?php 
    $temConsultas = ($resultConsultas->num_rows > 0);
    $temAgendamentos = ($resultAgendamentos->num_rows > 0);
    ?>

    <?php if ($temConsultas): ?>
      <h3>Consultas </h3>
      <ul>
        <?php while ($consulta = $resultConsultas->fetch_assoc()): ?>
          <li>
            <strong><?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></strong> - 
            Paciente: <?php echo htmlspecialchars($consulta['nome_paciente']); ?> / 
            Médico: <?php echo htmlspecialchars($consulta['nome_medico']); ?><br />
            <small><?php echo nl2br(htmlspecialchars($consulta['descricao'] ?? '')); ?></small>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>

    <?php if ($temAgendamentos): ?>
      <h3>Agendamentos </h3>
      <ul>
        <?php 
          while ($agendamento = $resultAgendamentos->fetch_assoc()):
            $status = $agendamento['status'];
            $classeStatus = match($status) {
                'Confirmado' => 'status-confirmado',
                'Cancelado'  => 'status-cancelado',
                'Faltou'     => 'status-faltou',
                default      => 'status-default'
            };
        ?>
          <li>
            <strong><?php echo date('H:i', strtotime($agendamento['data_consulta'])); ?></strong> - 
            Paciente: <span class="<?php echo $classeStatus; ?>">
              <?php echo htmlspecialchars($agendamento['nome_completo']); ?> (<?php echo htmlspecialchars($status); ?>)
            </span>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>

    <?php if (!$temConsultas && !$temAgendamentos): ?>
      <p><em>Nenhuma consulta ou agendamento encontrado para esta data.</em></p>
    <?php endif; ?>

    <br/>

    <!-- Botões -->
    <div style="margin-top: 20px;">
      <?php if ($funcao === 'Administrador' || $funcao === 'Recepcionista'): ?>
      <a href="agendar.php">
        <button style="
          padding: 12px 20px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 6px;
          font-size: 16px;
          cursor: pointer;
          transition: background 0.3s;
        ">Ir para Agendamento</button>
      </a>
      <?php endif; ?>

      <br><br>
      <a href="../Pages/pagina-principal.php">
        <button style="
          padding: 12px 20px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 6px;
          font-size: 16px;
          cursor: pointer;
          transition: background 0.3s;
        ">Voltar ao início</button>
      </a>
    </div>

  </div>
</body>
</html>

<?php
$stmtConsultas->close();
$stmtAgendamentos->close();
$conn->close();
?>
