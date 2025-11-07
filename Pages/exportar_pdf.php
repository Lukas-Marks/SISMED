<?php
require_once 'conectar.php';
require_once 'fpdf.php';
session_start();

// Captura filtro de especialidade, se houver
$especialidadeFiltro = $_GET['especialidade'] ?? '';

// Construir query
$where = "";
$params = [];
$tipos = '';
if ($especialidadeFiltro !== '') {
    $where = "WHERE a.especialidade = ?";
    $params[] = $especialidadeFiltro;
    $tipos .= 's';
}

// Consulta de atendimentos
$sql = "
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

$stmt = $conn->prepare($sql);
if (!$stmt) die('Erro na query: ' . $conn->error);

if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Criar PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Relatório de Atendimentos', 0, 1, 'C');
$pdf->Ln(5);

// Cabeçalho da tabela
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(40, 10, 'Paciente', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'CPF', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Especialidade', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Médico', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Data', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Tipo', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Status', 1, 1, 'C', true);

// Conteúdo da tabela
$pdf->SetFont('Arial', '', 11);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 8, $row['Paciente'], 1);
    $pdf->Cell(30, 8, $row['cpf'], 1);
    $pdf->Cell(35, 8, $row['especialidade'], 1);
    $pdf->Cell(35, 8, $row['Medico'] ?? 'Não informado', 1);
    $pdf->Cell(25, 8, date('d/m/Y', strtotime($row['data_consulta'])), 1);
    $pdf->Cell(25, 8, $row['tipo_consulta'], 1);
    $pdf->Cell(25, 8, $row['status'], 1);
    $pdf->Ln();
}

// Mensagem no rodapé
$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Relatório gerado automaticamente pelo sistema SISMED.', 0, 1, 'C');

// Forçar download do PDF
$pdf->Output('D', 'relatorio_atendimentos.pdf');

$stmt->close();
$conn->close();
?>
