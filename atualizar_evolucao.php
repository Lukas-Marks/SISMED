<?php
include 'conexao.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = intval($_POST['paciente_id']);
    $anamnese = $conn->real_escape_string($_POST['anamnese']);
    $exames_fisicos = $conn->real_escape_string($_POST['exames_fisicos']);
    $solicitacoes = $conn->real_escape_string($_POST['solicitacoes']);

    $sql = "UPDATE evolucoes 
            SET anamnese = '$anamnese',
                exames_fisicos = '$exames_fisicos',
                solicitacoes = '$solicitacoes',
                data_registro = NOW()
            WHERE paciente_id = $paciente_id
            ORDER BY id DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["sucesso" => true]);
    } else {
        echo json_encode(["sucesso" => false, "erro" => $conn->error]);
    }
}

$conn->close();
?>

