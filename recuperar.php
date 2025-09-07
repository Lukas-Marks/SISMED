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

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Senha</title>
  <link rel="stylesheet" href="/sismed/css/style.css?v=2">

</head>
<body>
  <div class="recuperar-container">
    <h1>Recuperar Senha</h1>
    <p class="descricao">Digite seu e-mail cadastrado para receber o link de redefinição.</p>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Seu e-mail" required>
      <button type="submit">Enviar link</button>
    </form>

    <a href="index.php">← Voltar para o login</a>

    <?php if (!empty($mensagem)) { echo "<p class='msg'>$mensagem</p>"; } ?>
  </div>
</body>
</html>
