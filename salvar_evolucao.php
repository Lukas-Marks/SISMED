<?php
include 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    if (
        isset($_POST['paciente_id']) &&
        isset($_POST['anamnese']) &&
        isset($_POST['exames_fisicos']) &&
        isset($_POST['solicitacoes'])
    ) {
        $paciente_id = intval($_POST['paciente_id']);
        $anamnese = $conn->real_escape_string($_POST['anamnese']);
        $exames_fisicos = $conn->real_escape_string($_POST['exames_fisicos']);
        $solicitacoes = $conn->real_escape_string($_POST['solicitacoes']);

        $sql = "INSERT INTO evolucoes (paciente_id, anamnese, exames_fisicos, solicitacoes, data_registro)
                VALUES ($paciente_id, '$anamnese', '$exames_fisicos', '$solicitacoes', NOW())";

        if (
