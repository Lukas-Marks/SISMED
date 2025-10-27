<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

include 'Conectar.php';

$usuario_id = $_SESSION['usuario_id'];

// Buscar nome e função do usuário logado
$stmt = $conn->prepare("SELECT nome, funcao FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result_usuario = $stmt->get_result();

if ($result_usuario->num_rows > 0) {
    $row_usuario = $result_usuario->fetch_assoc();
    $usuario = $row_usuario['nome'];
    $funcao = $row_usuario['funcao'];
    $_SESSION['funcao'] = $funcao;
} else {
    $usuario = "Usuário";
    $funcao = "Desconhecido";
}

$dataSelecionada = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

$horarios = ["07:00", "08:00", "09:00", "10:00", "11:00", "14:00", "15:00", "16:00", "17:00", "18:00"];

// Consulta para contar pendências (agendamentos com status Cancelado)
$stmtPendencias = $conn->prepare("SELECT COUNT(*) AS total_pendencias FROM agendamentos WHERE status = ?");
$statusCancelado = 'Cancelado';
$stmtPendencias->bind_param("s", $statusCancelado);
$stmtPendencias->execute();
$resultPendencias = $stmtPendencias->get_result();
$rowPendencias = $resultPendencias->fetch_assoc();
$totalPendencias = $rowPendencias['total_pendencias'];
$stmtPendencias->close();

// Consulta para contar pacientes ativos (exemplo, se tiver algum campo para isso, aqui só exemplo fixo)
$totalPacientesAtivos = 245; // Altere conforme sua tabela

// Consulta para contar consultas do dia (exemplo, também precisa ajustar conforme sua tabela)
$stmtConsultasHoje = $conn->prepare("SELECT COUNT(*) AS total_consultas FROM consultas WHERE DATE(data_consulta) = ?");
$stmtConsultasHoje->bind_param("s", $dataSelecionada);
$stmtConsultasHoje->execute();
$resultConsultasHoje = $stmtConsultasHoje->get_result();
$rowConsultasHoje = $resultConsultasHoje->fetch_assoc();
$totalConsultasHoje = $rowConsultasHoje['total_consultas'];
$stmtConsultasHoje->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SISMED - Dashboard</title>
  <link rel="stylesheet" href="../CSS/mediaquerie.css" />
  <link rel="stylesheet" href="../CSS/rodape.css" />
  <link rel="stylesheet" href="../CSS/cabecalho.css" />
  <link rel="stylesheet" href="../CSS/reset.css" />
  <link rel="stylesheet" href="../CSS/Pagina-Principal.css" />
</head>
<body>

<?php include 'cabecalho.php'; ?>

<div class="container">

  <div class="welcome">
    <h2>Bem-vindo(a), <?php echo htmlspecialchars($usuario); ?> 👩‍⚕️</h2>
    <p>Aqui está um resumo do consultório para hoje.</p>
  </div>

  <div class="cards">
    <div class="card blue">
      <h3>Pacientes Ativos</h3>
      <p><?php echo $totalPacientesAtivos; ?></p>
    </div>
    <div class="card green">
      <h3>Consultas Hoje</h3>
      <p><?php echo $totalConsultasHoje; ?></p>
    </div>
    <div class="card orange">
      <h3>Pendências</h3>
      <p><?php echo $totalPendencias; ?></p>
    </div>
  </div>

  <h2>Pacientes Agendados</h2>

  <form method="GET" id="form-data" style="margin-bottom: 40px;">
    <label for="data">📅 Selecione a data: </label>
    <input
      type="date"
      id="data"
      name="data"
      value="<?php echo htmlspecialchars($dataSelecionada); ?>"
      style="height: 40px; font-size: 16px; padding: 5px;"
    />
  </form>

  <script>
    document.getElementById('data').addEventListener('change', function () {
      document.getElementById('form-data').submit();
    });
  </script>

  <table class="agendamentos-table">
    <thead>
      <tr>
        <th style="width: 80px;">Horário</th>
        <th>Nome</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($horarios as $horario): ?>
        <tr>
          <td><?php echo $horario; ?></td>
          <?php
          // Monta a data e hora completa para comparar com data_consulta (DATETIME)
          $dataHoraConsulta = $dataSelecionada . ' ' . $horario . ':00';

          $stmt = $conn->prepare("
            SELECT nome_completo, status
            FROM agendamentos
            WHERE data_consulta = ? AND medico_id = ?
          ");
          $stmt->bind_param("si", $dataHoraConsulta, $usuario_id);
          $stmt->execute();
          $resultado = $stmt->get_result();

          if ($resultado->num_rows > 0): ?>
            <td class="status-agendado">
              <?php
              $total = $resultado->num_rows;
              $count = 0;

              while ($linha = $resultado->fetch_assoc()):
                $nome = htmlspecialchars($linha['nome_completo']);
                $status = $linha['status'];

                $cor = match($status) {
                    'Confirmado' => '#28a745',
                    'Cancelado'  => '#ffc107',
                    default      => '#6c757d',
                };
              ?>
                <div style="color: <?php echo $cor; ?>; font-weight: bold;">
                  <?php echo $nome; ?>
                </div>
                <?php if (++$count < $total): ?>
                  <div style="border-top: 1px dashed #ccc; margin: 6px 0;"></div>
                <?php endif; ?>
              <?php endwhile; ?>
            </td>
          <?php else: ?>
            <td class="status-livre">-- Livre --</td>
          <?php endif; ?>
          <?php $stmt->close(); ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="consultas.php?data=<?php echo urlencode($dataSelecionada); ?>">
    <button style="
      padding: 12px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    ">
      Ver Consultas
    </button>
  </a>

</div>

<?php include 'rodape.php'; ?>

<script src="../JS/jquery.js"></script>
<script>
  $(".imagem-ham").click(function() {
    $(".nav-mobile").slideToggle();
  });
</script>

</body>
</html>
