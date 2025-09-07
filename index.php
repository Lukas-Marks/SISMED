<?php
session_start();
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: home.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="login-container">
    <h1 class="logo">SISMED</h1>
    <form method="POST">
      <input type="text" name="email" placeholder="Usuário / Email" required><br>
      <input type="password" name="senha" placeholder="Senha" required><br>
      <label><input type="checkbox" name="lembrar"> Lembrar-me</label><br>
      <button type="submit">Entrar</button>
      <a href="recuperar.php" class="esqueci">Esqueci a senha</a>
    </form>
    <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
  </div>
</body>
</html>
