<!-- esq ueci_senha.php -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Esqueci Minha Senha</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    <div class="w3-container w3-display-middle w3-card w3-padding w3-round w3-third">
        <h3 class="w3-center">Recuperar Senha</h3>
        <form action="processa_recuperacao.php" method="post">
            <label>E-mail cadastrado:</label>
            <input class="w3-input w3-border" type="email" name="email" required>
            <button class="w3-button w3-teal w3-margin-top w3-block" type="submit">Enviar nova senha</button>
        </form>
    </div>
</body>

</html>
