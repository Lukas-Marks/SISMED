<?php
session_start();
require_once '../ConexaoBD/conectar.php';

// Pega os dados do formulário
$emailOuUsuario = $_POST['email'] ?? '';
$senhaDigitada = $_POST['senha'] ?? '';

// Escapa o campo de usuário/email (a senha não precisa ser escapada)
$emailOuUsuario = $conexao->real_escape_string($emailOuUsuario);

// Consulta ao banco: tenta localizar por e-mail ou nome de usuário
$sql = "SELECT * FROM usuarios WHERE email = '$emailOuUsuario' OR usuario = '$emailOuUsuario'";
$result = $conexao->query($sql);

if ($result && $result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    // Verifica a senha usando password_verify
    if (password_verify($senhaDigitada, $usuario['senha'])) {
        // Login válido — salva informações na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_usuario'] = $usuario['usuario']; // se quiser usar

        // Redireciona para a página principal
        header("Location: ../Pages/pagina-principal.php");
        exit();
    } else {
        // Senha incorreta
        echo "<script>alert('Senha incorreta'); window.location.href='../index.php';</script>";
    }
} else {
    // Usuário não encontrado
    echo "<script>alert('Usuário ou e-mail não encontrado'); window.location.href='../index.php';</script>";
}
?>
