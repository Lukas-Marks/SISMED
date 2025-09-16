<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SISMED - Login</title>
    <link rel="stylesheet" href="css/style.css?v=1">
</head>
<body>
    <div class="login-container">
        <h1 class="logo">SISMED</h1>
        <p class="subtitle">Sistema para Consultórios</p>

        <form method="POST" action="autenticar.php">
            <input type="text" name="email" placeholder="Usuário / Email" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <div class="options">
                <label><input type="checkbox" name="lembrar"> Lembrar-me</label>
                <a href="recuperar.php" class="link">Esqueci a senha</a>
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <footer>© 2025 SISMED - Todos os direitos reservados</footer>
    </div>
</body>
</html>
