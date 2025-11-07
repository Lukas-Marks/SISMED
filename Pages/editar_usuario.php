<?php
include 'Conectar.php';

if (!isset($_GET['id'])) {
    die("ID do usuário não informado.");
}

$id = intval($_GET['id']);

// Buscar dados do usuário, incluindo funcao e especialidade
$stmt = $conn->prepare("SELECT id, nome, usuario, telefone, email, historico, funcao, especialidade FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['txtnome'] ?? '';
    $usuario = $_POST['txtusuario'] ?? '';
    $telefone = $_POST['txttelefone'] ?? '';
    $email = $_POST['txtEmail'] ?? '';
    $historico = $_POST['txthistorico'] ?? '';
    $funcao = $_POST['funcao'] ?? '';
    $especialidade = $_POST['especialidade'] ?? '';

    // Validação simples - adaptar conforme necessidade
    if (!in_array($funcao, ['Administrador', 'Recepcionista', 'Médico'])) {
        echo "Função inválida!";
        exit;
    }

    if ($funcao === 'Médico') {
        $especialidades_validas = ['Cardiologia', 'Pediatria', 'Clínico Geral'];
        if (!in_array($especialidade, $especialidades_validas)) {
            echo "Especialidade inválida!";
            exit;
        }
    } else {
        $especialidade = null; // Limpa especialidade se não for médico
    }

    $novaSenha = $_POST['novaSenha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    if (!empty($novaSenha)) {
        if ($novaSenha !== $confirmaSenha) {
            echo "As senhas não coincidem!";
            exit;
        }
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmtUpdate = $conn->prepare("UPDATE usuarios SET nome=?, usuario=?, telefone=?, email=?, historico=?, funcao=?, especialidade=?, senha=? WHERE id=?");
        $stmtUpdate->bind_param("ssssssssi", $nome, $usuario, $telefone, $email, $historico, $funcao, $especialidade, $senhaHash, $id);
    } else {
        $stmtUpdate = $conn->prepare("UPDATE usuarios SET nome=?, usuario=?, telefone=?, email=?, historico=?, funcao=?, especialidade=? WHERE id=?");
        $stmtUpdate->bind_param("sssssssi", $nome, $usuario, $telefone, $email, $historico, $funcao, $especialidade, $id);
    }

    if ($stmtUpdate->execute()) {
        header("Location: usuarios.php?msg=atualizado");
        exit;
    } else {
        echo "Erro ao atualizar usuário: " . $stmtUpdate->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuário</title>  
  <link rel="stylesheet" href="../CSS/editar_usuarios.css">  
  <script>
    // Mostrar/ocultar especialidade dependendo da função selecionada
    function toggleEspecialidade() {
      const funcaoSelect = document.getElementById('funcao');
      const especialidadeDiv = document.getElementById('divEspecialidade');
      if (funcaoSelect.value === 'Médico') {
        especialidadeDiv.style.display = 'block';
        document.getElementById('especialidade').required = true;
      } else {
        especialidadeDiv.style.display = 'none';
        document.getElementById('especialidade').required = false;
      }
    }
    window.onload = function() {
      toggleEspecialidade();
      document.getElementById('funcao').addEventListener('change', toggleEspecialidade);
    };
  </script>
</head>
<body class="body">
  <div class="container">
    <h2>Editar Usuário</h2>
    <form class="form" method="POST">

      <label class="label" for="nome">Nome</label>
      <input id="nome" name="txtnome" type="text" value="<?= htmlspecialchars($user['nome']) ?>" required />

      <label class="label" for="usuario">Usuário</label>
      <input id="usuario" name="txtusuario" type="text" value="<?= htmlspecialchars($user['usuario']) ?>" required />

      <label class="label" for="telefone">Telefone</label>
      <input id="telefone" name="txttelefone" type="tel" value="<?= htmlspecialchars($user['telefone']) ?>" />

      <label class="label" for="email">Email</label>
      <input id="email" name="txtEmail" type="email" value="<?= htmlspecialchars($user['email']) ?>" required />

      <label class="label" for="funcao">Função</label>
      <select id="funcao" name="funcao" required>
        <option value="">Selecione uma função</option>
        <option value="Administrador" <?= $user['funcao'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
        <option value="Recepcionista" <?= $user['funcao'] === 'Recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
        <option value="Médico" <?= $user['funcao'] === 'Médico' ? 'selected' : '' ?>>Médico</option>
      </select>

      <div id="divEspecialidade" style="margin-top:10px;">
        <label class="label" for="especialidade">Especialidade</label>
        <select id="especialidade" name="especialidade">
          <option value="">Selecione a especialidade</option>
          <option value="Cardiologia" <?= $user['especialidade'] === 'Cardiologia' ? 'selected' : '' ?>>Cardiologia</option>
          <option value="Pediatria" <?= $user['especialidade'] === 'Pediatria' ? 'selected' : '' ?>>Pediatria</option>
          <option value="Clínico Geral" <?= $user['especialidade'] === 'Clínico Geral' ? 'selected' : '' ?>>Clínico Geral</option>
        </select>
      </div>

      <label class="label" for="historico">Histórico</label>
      <textarea id="historico" name="txthistorico"><?= htmlspecialchars($user['historico']) ?></textarea>

      <label class="label" for="novaSenha">Nova Senha (opcional)</label>
      <input id="novaSenha" name="novaSenha" type="password" />

      <label class="label" for="confirmaSenha">Confirmar Nova Senha</label>
      <input id="confirmaSenha" name="confirmaSenha" type="password" />

      <button class="btn" type="submit">Salvar Alterações</button><br>
      <a class="btn" href="usuarios.php">Voltar</a>
    </form>
  </div>
</body>
</html>
