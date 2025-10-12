<?php
include '../ConexaoBD/conectar.php';

$sql = "SELECT id, nome_completo, data_consulta, horario, status FROM agendamentos";
$result = $conn->query($sql);

$eventos = [];

while ($row = $result->fetch_assoc()) {
    $cor = $row['status'] == 'Confirmado' ? '#28a745' : '#dc3545'; // verde ou vermelho

    $eventos[] = [
        'id' => $row['id'],
        'title' => $row['nome_completo'],
        'start' => $row['data_consulta'] . 'T' . $row['horario'],
        'color' => $cor
    ];
}

echo json_encode($eventos);
$conn->close();
?>