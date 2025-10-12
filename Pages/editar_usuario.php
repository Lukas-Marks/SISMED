<?php
include '../ConexaoBD/conectar.php';



if (!isset($_GET['id'])) {
    die("ID do usuário não informado.");
}

$id = intval($_GET['id']);

// Buscar dados do usuário
$stmt = $conexao->prepare("SELECT id, nome, usuario, telefone, email, historico FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar atualização (valide e atualize os dados)
    $nome = $_POST['txtnome'] ?? '';
    $usuario = $_POST['txtusuario'] ?? '';
    $telefone = $_POST['txttelefone'] ?? '';
    $email = $_POST['txtEmail'] ?? '';
    $historico = $_POST['txthistorico'] ?? '';

    if (!empty($nome) && !empty($usuario) && !empty($email)) {
        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, usuario = ?, telefone = ?, email = ?, historico = ? WHERE id = ?");
        $stmtUpdate->bind_param("sssssi", $nome, $usuario, $telefone, $email, $historico, $id);
    
        

if (!empty($nome) && !empty($usuario) && !empty($email)) {
    $novaSenha = $_POST['novaSenha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    if (!empty($novaSenha)) {
        // Verifica se as senhas coincidem
        if ($novaSenha !== $confirmaSenha) {
            echo "As senhas não coincidem!";
            echo "<button onclick=\"window.location.href='usuarios.php';\">Voltar</button>";
            exit;
        }

        // Criptografa a nova senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        // Atualiza com nova senha
        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, usuario = ?, telefone = ?, email = ?, historico = ?, senha = ? WHERE id = ?");
        $stmtUpdate->bind_param("ssssssi", $nome, $usuario, $telefone, $email, $historico, $senhaHash, $id);
    } else {
        // Atualiza sem alterar senha
        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, usuario = ?, telefone = ?, email = ?, historico = ? WHERE id = ?");
        $stmtUpdate->bind_param("sssssi", $nome, $usuario, $telefone, $email, $historico, $id);
    }

    if ($stmtUpdate->execute()) {
        header("Location: usuarios.php?msg=atualizado");
        exit;
    } else {
        echo "Erro ao atualizar usuário: " . $stmtUpdate->error;
    }
}

       // if ($stmtUpdate->execute()) {
       //     header("Location: usuarios.php?msg=atualizado");
       //     exit;
        } else {
            echo "Erro ao atualizar usuário: " . $stmtUpdate->error;
        }
    } else {
        echo "";
    }


$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuário</title>  
  <link rel="stylesheet" href="../CSS/editar_usuarios.css?">  

  <style>
  </style>

</head>
<body class="body">
  <div class="container">
    <h2>Editar Usuário</h2>
    <form class="form" method="POST">
      <label class="label"   for="nome">Nome</label>
      <input id="nome" name="txtnome" type="text" value="<?= htmlspecialchars($user['nome']) ?>" required />

      <label class="label" for="usuario">Usuário</label>
      <input id="usuario" name="txtusuario" type="text" value="<?= htmlspecialchars($user['usuario']) ?>" required />

      <label class="label" for="telefone">Telefone</label>
      <input id="telefone" name="txttelefone" type="tel" value="<?= htmlspecialchars($user['telefone']) ?>" />

      <label class="label" for="email">Email</label>
      <input id="email" name="txtEmail" type="email" value="<?= htmlspecialchars($user['email']) ?>" required />

      <label class="label" for="historico">Histórico</label>
      <textarea id="historico" name="txthistorico"><?= htmlspecialchars($user['historico']) ?></textarea>


      <label class="label" for="senha">Nova Senha (opcional)</label>
      <input id="senha" name="novaSenha" type="password" />

      <label class="label" for="confirmaSenha">Confirmar Nova Senha</label>
      <input id="confirmaSenha" name="confirmaSenha" type="password" />



      <button class="btn"  type="submit">Salvar Alterações</button><br>
      <button class="btn" href="usuarios.php" >Voltar</button>
    </form>
    <br>
    
  </div>
</body>
</html>
