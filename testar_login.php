<?php
$conn = new mysqli("localhost", "root", "", "sismed");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$email = 'admin@sismed.com';
$senha = 'admin123';

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario['senha'])) {
        echo "✅ Login funcionando!";
    } else {
        echo "❌ Senha incorreta.";
    }
} else {
    echo "❌ Usuário não encontrado.";
}
?>
