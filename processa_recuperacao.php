<?php
// Dados de conexão
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sismed"; 

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Captura o e-mail do formulário
$email = $_POST['email'] ?? '';

// Verifica se o e-mail existe no banco
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Gera uma nova senha simples
    $nova_senha = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    // Atualiza a senha no banco
    $update_sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $senha_hash, $email);
    $update_stmt->execute();

    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2>Senha redefinida com sucesso!</h2>";
    echo "<p><strong>Nova senha:</strong> <span style='color:blue;'>$nova_senha</span></p>";
    echo "<p><a href='index.php'>Voltar ao login</a></p>";
    echo "</div>";
} else {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2 style='color:red;'>E-mail não encontrado!</h2>";
    echo "<p><a href='esqueci_senha.php'>Tentar novamente</a></p>";
    echo "</div>";
}

$conn->close();
?>
