<?php
session_start();
require_once 'verifica_acesso.php';
permitir_acesso_somente(['Administrador']);

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conectar.php';

// ==========================
// DADOS DO USUÁRIO
// ==========================
$funcao = $_SESSION['usuario_funcao'] ?? '';
$especialidadeFiltro = $_SESSION['usuario_especialidade'] ?? '';

// ==========================
// FILTRO POR ESPECIALIDADE (para médicos)
// ==========================
$where = "WHERE 1=1";
$params = [];
$tipos = '';

if ($funcao === 'Médico' && $especialidadeFiltro !== '') {
    $where .= " AND a.especialidade = ?";
    $params[] = $especialidadeFiltro;
    $tipos .= 's';
}

// ==========================
// CONSULTA DE ATENDIMENTOS
// ==========================
$sql = "
SELECT 
    a.id,
    a.nome_completo AS Paciente,
    a.cpf,
    a.especialidade,
    u.nome AS Medico,
    a.data_consulta,
    a.tipo_consulta,
    a.status
FROM 
    agendamentos a
LEFT JOIN 
    usuarios u ON a.medico_id = u.id
$where
ORDER BY 
    a.especialidade ASC, a.data_consulta DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Erro na query: ' . $conn->error);
}
if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// ==========================
// INDICADORES GERAIS
// ==========================
$totalPacientesAtivos = $conn->query("SELECT COUNT(DISTINCT nome_completo) AS total FROM agendamentos")->fetch_assoc()['total'];
$totalConsultas = $conn->query("SELECT COUNT(*) AS total FROM agendamentos")->fetch_assoc()['total'];
$consultasAgendadas = $conn->query("SELECT COUNT(*) AS total FROM agendamentos WHERE LOWER(status) IN ('agendada', 'confirmado', 'confirmada')")->fetch_assoc()['total'];
$consultasRealizadas = $conn->query("SELECT COUNT(*) AS total FROM agendamentos WHERE LOWER(status) = 'realizada'")->fetch_assoc()['total'];
$consultasCanceladas = $conn->query("SELECT COUNT(*) AS total FROM agendamentos WHERE LOWER(status) = 'cancelada'")->fetch_assoc()['total'];


// ==========================
// MÉDICOS COM MAIOR VOLUME
// ==========================
$maioresMedicos = $conn->query("
    SELECT u.nome AS Medico, COUNT(a.id) AS Total
    FROM agendamentos a
    LEFT JOIN usuarios u ON a.medico_id = u.id
    GROUP BY u.nome
    ORDER BY Total DESC
    LIMIT 5
");

// ==========================
// ESPECIALIDADES MAIS PROCURADAS
// ==========================
$especialidades = $conn->query("
    SELECT especialidade AS Especialidade, COUNT(*) AS Total
    FROM agendamentos
    GROUP BY especialidade
    ORDER BY Total DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios SISMED</title>
    <link rel="stylesheet" href="../CSS/relatorio.css">
    <link rel="stylesheet" href="../CSS/rodape.css" />
  <link rel="stylesheet" href="../CSS/cabecalho.css" />
  <link rel="stylesheet" href="../CSS/reset.css" />
</head>
<body>
<?php include('cabecalho.php')?>
<div class="container">
    <h2>Relatórios SISMED</h2>

    <!-- INDICADORES GERAIS -->
    <div class="results">
        <div class="results-header"><h3>Indicadores Gerais</h3></div>
        <table>
            <tr><th>Indicador</th><th>Quantidade</th></tr>
            <tr><td>Total de Pacientes Ativos</td><td><?= $totalPacientesAtivos ?></td></tr>
            <tr><td>Total de Consultas</td><td><?= $totalConsultas ?></td></tr>
            <tr><td>Consultas Agendadas</td><td><?= $consultasAgendadas ?></td></tr>
            <tr><td>Consultas Realizadas</td><td><?= $consultasRealizadas ?></td></tr>
            <tr><td>Consultas Canceladas</td><td><?= $consultasCanceladas ?></td></tr>
        </table>
    </div>

    <!-- MÉDICOS COM MAIOR VOLUME -->
    <div class="results">
        <div class="results-header"><h3>Médicos com Maior Volume de Atendimentos</h3></div>
        <table>
            <tr><th>Médico</th><th>Total de Atendimentos</th></tr>
            <?php while($row = $maioresMedicos->fetch_assoc()): ?>
                <tr><td><?= htmlspecialchars($row['Medico'] ?? 'Não informado') ?></td><td><?= $row['Total'] ?></td></tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- ESPECIALIDADES MAIS PROCURADAS -->
    <div class="results">
        <div class="results-header"><h3>Especialidades Mais Procuradas</h3></div>
        <table>
            <tr><th>Especialidade</th><th>Total de Consultas</th></tr>
            <?php while($row = $especialidades->fetch_assoc()): ?>
                <tr><td><?= htmlspecialchars($row['Especialidade']) ?></td><td><?= $row['Total'] ?></td></tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- TABELA DE ATENDIMENTOS -->
    <div class="results">
        <div class="results-header"><h3>Atendimentos</h3></div>
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>CPF</th>
                    <th>Especialidade</th>
                    <th>Médico</th>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Paciente']) ?></td>
                    <td><?= htmlspecialchars($row['cpf']) ?></td>
                    <td><?= htmlspecialchars($row['especialidade']) ?></td>
                    <td><?= htmlspecialchars($row['Medico'] ?? 'Não informado') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_consulta'])) ?></td>
                    <td><?= htmlspecialchars($row['tipo_consulta']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- BOTÕES DE EXPORTAÇÃO -->
    <div class="botoes-export">
        <a href="exportar_excel.php?especialidade=<?= urlencode($especialidadeFiltro) ?>" class="btn-secondary">Exportar Excel</a>
       <a class="btn-secondary" href="../Pages/pagina-principal.php">Voltar ao Início</a>
    </div>

    <div class="btn-group">
        
    </div>
</div>

<?php include('rodape.php')?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
