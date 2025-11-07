<?php
// Conexão com banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Receber dados do formulário
$nome           = $_POST['nome'] ?? '';
$data_nasc      = $_POST['data_nascimento'] ?? '';
$altura         = $_POST['altura'] ?? '';
$peso           = $_POST['peso'] ?? '';
$telefone       = $_POST['telefone'] ?? '';
$email          = $_POST['email'] ?? '';
$rua            = $_POST['rua'] ?? '';
$numero         = $_POST['numero'] ?? '';
$bairro         = $_POST['bairro'] ?? '';
$cidade         = $_POST['cidade'] ?? '';
$estado         = $_POST['estado'] ?? '';
$cep            = $_POST['cep'] ?? '';
$historico      = $_POST['historico'] ?? '';

// Validação básica
if (empty($nome) || empty($data_nasc) || empty($email)) {
    echo "<p style='color:red;'>Campos obrigatórios não preenchidos!</p>";
    echo "<a href='cadastrodepaciente.php'>Voltar</a>";
    exit;
}

// Inserir no banco
$stmt = $conexao->prepare("INSERT INTO pacientes 
    (nome, data_nascimento, altura, peso, telefone, email, rua, numero, bairro, cidade, estado, cep, historico) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssddsssssssss",
    $nome,
    $data_nasc,
    $altura,
    $peso,
    $telefone,
    $email,
    $rua,
    $numero,
    $bairro,
    $cidade,
    $estado,
    $cep,
    $historico
);

if ($stmt->execute()) {
    echo "<p style='color:green;'>Paciente cadastrado com sucesso!</p>";
    echo "<a href='paginaprincipal.php'>Voltar para a Página Principal</a>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar paciente: " . $stmt->error . "</p>";
    echo "<a href='cadastrodepaciente.php'>Tentar novamente</a>";
}

$stmt->close();
$conexao->close();
?>
