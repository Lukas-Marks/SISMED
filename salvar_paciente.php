<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];
    $matricula = $_POST['matricula'];
    $atestados = $_POST['atestados'];
    $receituarios = $_POST['receituarios'];

    $sql = "INSERT INTO pacientes (nome, codigo, matricula, atestados, receituarios)
            VALUES ('$nome', '$codigo', '$matricula', '$atestados', '$receituarios')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["sucesso" => "Paciente cadastrado com sucesso!"]);
    } else {
        echo json_encode(["erro" => "Erro ao salvar: " . $conn->error]);
    }

    $conn->close();
}
?>
