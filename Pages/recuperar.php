<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - SISMED</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <div class="recuperar-container">
        <h1>Recuperar Senha</h1>
        <p class="descricao">Digite seu e-mail cadastrado para receber o link de redefinição.</p>

        <form method="POST" action="processa_recuperacao.php">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <button type="submit">Enviar link</button>
        </form>

        <a href="../index.php">← Voltar para o login</a>
    </div>
</body>
</html>
