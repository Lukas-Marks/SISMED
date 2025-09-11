<?php
include('conexao.php');
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? "");

    if ($email !== "") {
        if ($stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $mensagem = "Um link de redefinição de senha foi enviado para o seu e-mail.";
                // Aqui você poderia enviar um e-mail real com PHPMailer, por exemplo.
            } else {
                $mensagem = "E-mail não encontrado no sistema!";
            }
            $stmt->close();
        }
    } else {
        $mensagem = "Informe um e-mail válido.";
    }
}
?>


