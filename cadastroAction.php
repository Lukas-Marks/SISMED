<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

$nome   = $_POST['txtNome'] ?? '';
$email  = $_POST['txtEmail'] ?? '';
$senha  = $_POST['txtSenha'] ?? '';
$perfil = $_POST['txtPerfil'] ?? '';

if (!empty($nome) && !empty($email) && !empty($perfil)) {

    // Verifica se o email já existe
    $stmtCheck = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        // Atualizar usuário

        if (!empty($senha)) {
            // Atualiza nome, senha e perfil
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, senha = ?, perfil = ? WHERE email = ?");
            $stmtUpdate->bind_param("ssss", $nome, $senhaCriptografada, $perfil, $email);
        } else {
            // Atualiza nome e perfil, mantém senha
            $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, perfil = ? WHERE email = ?");
            $stmtUpdate->bind_param("sss", $nome, $perfil, $email);
        }

        if (!$stmtUpdate->execute()) {
    echo "Erro ao atualizar usuário: " . $stmtUpdate->error;
} else {
    echo "Usuário atualizado com sucesso!";
}

        if ($stmtUpdate->execute()) {
            echo '
            <a href="index.php">
                <h1 class="w3-button w3-teal">Usuário atualizado com sucesso!</h1>
            </a>';
        } else {
            echo '
            <a href="index.php">
                <h1 class="w3-button w3-red">Erro ao atualizar usuário!</h1>
            </a>';
        }
        $stmtUpdate->close();

    } else {
        // Inserir novo usuário
        if (empty($senha)) {
            echo '
            <a href="cadastro.php">
                <h1 class="w3-button w3-red">Senha é obrigatória para novo usuário!</h1>
            </a>';
            exit;
        }
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        $stmtInsert = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
        $stmtInsert->bind_param("ssss", $nome, $email, $senhaCriptografada, $perfil);

        if ($stmtInsert->execute()) {
            echo '
            <a href="index.php">
                <h1 class="w3-button w3-teal">Usuário salvo com sucesso!</h1>
            </a>';
        } else {
            echo '
            <a href="index.php">
                <h1 class="w3-button w3-red">Erro ao salvar usuário!</h1>
            </a>';
        }
        $stmtInsert->close();
    }

    $stmtCheck->close();

} else {
    echo '
    <a href="index.php">
        <h1 class="w3-button w3-red">Todos os campos são obrigatórios (exceto senha ao editar)!</h1>
    </a>';
}

$conexao->close();
?>
