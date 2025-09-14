<?php
// Recebe os dados do formulário (com trim para remover espaços)
$nome  = trim($_POST['txtNome'] ?? '');
$senha = $_POST['txtSenha'] ?? '';

// Conexão com o banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Consulta segura para buscar pelo nome
$sql = "SELECT * FROM usuarios WHERE nome = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $nome);
$stmt->execute();
$resultado = $stmt->get_result();

if ($linha = $resultado->fetch_assoc()) {
    // Debug (remova isso)
   // echo "Nome digitado: [" . $nome . "]<br>";
   // echo "Senha digitada: " . $senha . "<br>";
   // echo "Senha no Banco de Dados: " . $linha['senha'] . "<br>";

    // Verifica a senha com password_verify
    if (password_verify($senha, $linha['senha'])) {
        // Login bem-sucedido
        echo '


    
        <a href="principal.php">
            <h1 class="w3-button w3-teal">' . htmlspecialchars($linha['nome']) . ',Você é o Usuário correto!</h1>
        </a>';
    } else {
        // Senha incorreta
        echo '
        <a href="index.php">
            <h1 class="w3-button w3-red">Login Inválido! Senha incorreta.</h1>
        </a>';
    }

} else {
    // Nome não encontrado no banco
    echo '
    <a href="index.php">
        <h1 class="w3-button w3-red">Login Inválido! Nome não cadastrado.</h1>
    </a>';
}

$conexao->close();
?>
