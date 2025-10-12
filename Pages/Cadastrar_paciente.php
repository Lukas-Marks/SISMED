<?php
include '../Pages/Conectar.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Captura os dados
    $nome = $_POST['nome_completo'];
    $data_nasc = $_POST['data_de_nascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $historico = $_POST['historico'];

    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    $endereco = "$rua, $numero - $bairro, $cidade - $estado, CEP: $cep";
    $doc_anexados = '';

    // Inserir paciente
    $sql_paciente = "INSERT INTO Paciente (Nome, DataNascimento, Endereco, Telefone, Email, DocAnexados)
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_paciente = $conn->prepare($sql_paciente);
    $stmt_paciente->bind_param("ssssss", $nome, $data_nasc, $endereco, $telefone, $email, $doc_anexados);

    if ($stmt_paciente->execute()) {
        $paciente_id = $conn->insert_id;

        $sql_prontuario = "INSERT INTO Prontuario (Altura, Peso, Doencas, PacienteID)
                           VALUES (?, ?, ?, ?)";
        $stmt_prontuario = $conn->prepare($sql_prontuario);
        $stmt_prontuario->bind_param("sssi", $altura, $peso, $historico, $paciente_id);
        $stmt_prontuario->execute();

        echo "<script>alert('Paciente cadastrado com sucesso!'); window.location.href='CadastroDePaciente.php';</script>";
    } else {
        echo "<script>alert('Erro ao salvar paciente: {$stmt_paciente->error}'); history.back();</script>";
    }

    $conn->close();

} else {
    echo "Acesso inválido.";
}
