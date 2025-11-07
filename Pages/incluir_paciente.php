<?php
// Conexão com o banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sismed";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$cpf = $_POST['cpf'];
$altura = $_POST['altura'];
$peso = $_POST['peso'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$historico = $_POST['historico'];

// Monta o endereço completo (opcional)
$endereco = "$rua, $numero - $bairro, $cidade - $estado, $cep";

// Função para verificar duplicidade
function existeDuplicado($conn, $campo, $valor) {
    $sql = "SELECT id FROM pacientes WHERE $campo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $stmt->store_result();
    $existe = $stmt->num_rows > 0;
    $stmt->close();
    return $existe;
}

// Verifica se email já existe
if (existeDuplicado($conn, 'email', $email)) {
    echo "Erro: Este email já está cadastrado.";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'pagina-principal.php';
        }, 3000);
    </script>";
    $conn->close();
    exit;
}

// Verifica se CPF já existe
if (existeDuplicado($conn, 'cpf', $cpf)) {
    echo "Erro: Este CPF já está cadastrado.";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'pagina-principal.php';
        }, 3000);
    </script>";
    $conn->close();
    exit;
}

// Prepara e executa a inserção
$sql = "INSERT INTO pacientes (
    nome, data_nascimento, cpf, altura, peso, telefone, endereco, email,
    rua, numero, bairro, cidade, estado, cep, historico
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssddssssssssss",
    $nome, $data_nascimento, $cpf, $altura, $peso, $telefone, $endereco, $email,
    $rua, $numero, $bairro, $cidade, $estado, $cep, $historico
);

if ($stmt->execute()) {
    echo "Paciente cadastrado com sucesso!";
    echo "<script>
      setTimeout(function() {
        window.location.href = 'pagina-principal.php';
      }, 2000);
    </script>";

} else {
    echo "Erro ao cadastrar: " . $stmt->error;
    echo "<script>
      setTimeout(function() {
        window.location.href = 'pagina-principal.php';
      }, 2000);
    </script>";
}

$stmt->close();
$conn->close();
?>
