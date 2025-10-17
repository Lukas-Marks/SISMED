<?php
include 'conexao.php';

if (isset($_GET['paciente_id'])) {
    $id = intval($_GET['paciente_id']);

    $sql = "SELECT e.id, e.anamnese, e.exames_fisicos, e.solicitacoes, e.data_registro
            FROM evolucoes e
            WHERE e.paciente_id = $id
            ORDER BY e.data_registro DESC";

    $result = $conn->query($sql);

    $historico = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $historico[] = $row;
        }
    }

    echo json_encode($historico);
}

$conn->close();
?>
