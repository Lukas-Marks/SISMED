<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

$nome   = $_POST['txtnome'] ?? '';
$usuario = $_POST['txtusuario'] ?? '';
$telefone  = $_POST['txttelefone'] ?? '';
$email  = $_POST['txtEmail'] ?? '';
$senha  = $_POST['txtSenha'] ?? '';
$confirmaSenha  = $_POST['txtConfirmaSenha'] ?? '';
$historico = $_POST['txthistorico'] ?? '';

// Verifica se a senha foi preenchida e se as senhas batem
if (empty($senha)) {
    echo '
    <a href="Cadastro_usuario/cadastro.php">
        <h1 class="w3-button w3-red">Senha é obrigatória para novo usuário!</h1>
    </a>';
    exit;
}

if ($senha !== $confirmaSenha) {
    echo '
    <a href="../Pages/cadastro_usuario.php">
        <h1 class="w3-button w3-red">Senha e confirmação de senha não conferem!</h1>
    </a>';
    
    exit;
    
    
}






if (!empty($nome) && !empty($email) && !empty($usuario)) {

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
            $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, senha = ?, usuario = ?, perfil = ?, telefone = ?, historico = ? WHERE email = ?");
            $stmtUpdate->bind_param("sssssss", $nome, $senhaCriptografada, $usuario, $perfil, $telefone, $historico, $email);
        } else {
            // Atualiza nome e perfil, mantém senha
            $stmtUpdate = $conexao->prepare("UPDATE usuarios SET nome = ?, usuario = ?, perfil = ?, telefone = ?, historico = ? WHERE email = ?");
            $stmtUpdate->bind_param("sssss", $nome, $usuario, $perfil, $telefone, $historico, $email);
        }

        if (!$stmtUpdate->execute()) {
    echo "Erro ao atualizar usuário: " . $stmtUpdate->error;
} else {
    echo "Usuário atualizado com sucesso!";
}

        if ($stmtUpdate->execute()) {
            echo '
            <a href="../index.php">
                <h1 class="w3-button w3-teal">Usuário atualizado com sucesso!</h1>
            </a>';
        } else {
            echo '
            <a href="../index.php">
                <h1 class="w3-button w3-red">Erro ao atualizar usuário!</h1>
            </a>';
        }
        $stmtUpdate->close();

    } else {
        // Inserir novo usuário
        if (empty($senha)) {


            echo '
            <a href="Cadastro_usuario/cadastro.php">
                <h1 class="w3-button w3-red">Senha é obrigatória para novo usuário!</h1>
            </a>';
            exit;
        }





        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        $stmtInsert = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, usuario, telefone, historico) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtInsert->bind_param("ssssss", $nome, $email, $senhaCriptografada, $usuario, $telefone, $historico);

        if ($stmtInsert->execute()) {
            echo '
            <a href="../index.php">


                 
                <h1 class="w3-button w3-teal">Usuário salvo com sucesso!</h1>
            </a>';
        } else {
            echo '
            <a href="../index.php">
                <h1 class="w3-button w3-red">Erro ao salvar usuário!</h1>
            </a>';
        }
        $stmtInsert->close();
    }

    $stmtCheck->close();

} else {
    echo '
    <a href="../pages/cadastro_usuario.php">
        <h2 class="w3-button w3-red">Preencha todos os campos!</h2>
    </a>';
}

$conexao->close();
?>
