<?php
require_once 'conectar.php';
session_start();

$especialidadeFiltro = $_GET['especialidade'] ?? '';

// ==========================
// CONSULTA DE ATENDIMENTOS
// ==========================
$where = "";
$params = [];
$tipos = '';
if ($especialidadeFiltro !== '') {
    $where = "WHERE a.especialidade = ?";
    $params[] = $especialidadeFiltro;
    $tipos .= 's';
}

$sqlAtendimentos = "
SELECT 
    a.nome_completo AS Paciente,
    a.cpf,
    a.especialidade,
    u.nome AS Medico,
    a.data_consulta,
    a.tipo_consulta,
    a.status
FROM agendamentos a
LEFT JOIN usuarios u ON a.medico_id = u.id
$where
ORDER BY a.data_consulta DESC
";

$stmt = $conn->prepare($sqlAtendimentos);
if (!$stmt) die('Erro na query: ' . $conn->error);
if (!empty($params)) $stmt->bind_param($tipos, ...$params);
$stmt->execute();
$resultAtendimentos = $stmt->get_result();

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
// CONFIGURAÇÃO DO EXCEL
// ==========================
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=relatorio_sismed.xls");
header("Cache-Control: max-age=0");

// ==========================
// FUNÇÃO PARA TABELAS COM ESTILO
// ==========================
function criarTabelaExcel($titulo, $cabecalho, $dados) {
    echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse;'>";
    echo "<tr style='background-color:#007bff;color:white;font-weight:bold;'><th colspan='".count($cabecalho)."'>$titulo</th></tr>";
    echo "<tr style='background-color:#007bff;color:white;font-weight:bold;'>";
    foreach ($cabecalho as $col) {
        echo "<th>$col</th>";
    }
    echo "</tr>";

    $fill = false;
    foreach ($dados as $linha) {
        $bgcolor = $fill ? "#f2f2f2" : "#ffffff";
        echo "<tr style='background-color:$bgcolor;'>";
        foreach ($linha as $coluna) {
            echo "<td>$coluna</td>";
        }
        echo "</tr>";
        $fill = !$fill;
    }
    echo "</table><br>";
}

// ==========================
// GERAR RELATÓRIO
// ==========================

// Indicadores Gerais
$indicadores = [
    ['Total de Pacientes Ativos', $totalPacientesAtivos],
    ['Total de Consultas', $totalConsultas],
    ['Consultas Agendadas', $consultasAgendadas],
    ['Consultas Realizadas', $consultasRealizadas],
    ['Consultas Canceladas', $consultasCanceladas]
];
criarTabelaExcel("Indicadores Gerais", ['Indicador', 'Quantidade'], $indicadores);

// Médicos com maior volume
$dadosMedicos = [];
while ($row = $maioresMedicos->fetch_assoc()) {
    $dadosMedicos[] = [$row['Medico'] ?? 'Não informado', $row['Total']];
}
criarTabelaExcel("Médicos com Maior Volume de Atendimentos", ['Médico', 'Total de Atendimentos'], $dadosMedicos);

// Atendimentos
$dadosAtendimentos = [];
while ($row = $resultAtendimentos->fetch_assoc()) {
    $dadosAtendimentos[] = [
        $row['Paciente'],
        $row['cpf'],
        $row['especialidade'],
        $row['Medico'] ?? 'Não informado',
        date('d/m/Y H:i', strtotime($row['data_consulta'])),
        $row['tipo_consulta'],
        $row['status']
    ];
}
criarTabelaExcel("Atendimentos", ['Paciente','CPF','Especialidade','Médico','Data','Tipo','Status'], $dadosAtendimentos);

$conn->close();
?>
