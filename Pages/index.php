<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SISMED - Login</title>
    <link rel="stylesheet" href="css/login.css?v=1">

</head>
<body>
    <div class="login-container">
        <img src="../SISMED V3 - Copia (2)/Imagem/Sismed-logo.png" alt="Logo do Sistema" class="logo-image">
        <p class="subtitle">Sistema para Consultórios Médicos</p>

         <form method="POST" action="./Pages/login.php">
            <input type="text" name="email" placeholder="Usuário / Email" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <div class="options">
                <label><input type="checkbox" name="lembrar"> Lembrar-me</label>
                <a href="Pages/recuperar.php" class="link">Esqueci a senha</a>
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <footer>© 2025 SISMED - Todos os direitos reservados</footer>
    </div>
</body>
</html>
