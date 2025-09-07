<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Home</title>
</head>
<body>
  <h1>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h1>
  <p><a href="logout.php">Sair</a></p>
</body>
</html>
