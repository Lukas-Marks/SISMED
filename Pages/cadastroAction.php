<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sismed";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$nome          = $_POST['txtnome'] ?? '';
$funcao        = $_POST['funcao'] ?? '';
$especialidade = $_POST['especialidade'] ?? '';
$usuario       = $_POST['txtusuario'] ?? '';
$telefone      = $_POST['txttelefone'] ?? '';
$email         = $_POST['txtEmail'] ?? '';
$senha         = $_POST['txtSenha'] ?? '';
$confirmaSenha = $_POST['txtConfirmaSenha'] ?? '';
$historico     = $_POST['txthistorico'] ?? '';

 //Validar especialidade - só aceita as opções válidas



 // Validar especialidade apenas se a função for Médico
if ($funcao === 'Médico') {
$especialidades_validas = ['Cardiologia', 'Pediatria', 'Clínico Geral', 'Dermatologia'];
if (!in_array($especialidade, $especialidades_validas)) {
    echo '
   <a href="../pages/cadastro_usuario.php">
       <h2 class="w3-button w3-red">Especialidade inválida!</h2>
    </a>';
    exit;
}

} else {
    // Para outras funções, podemos garantir que a especialidade fique vazia
    $especialidade = '';
}

// Verifica se a senha foi preenchida e se as senhas batem
if (empty($senha)) {
    echo '
    <a href="../pages/cadastro_usuario.php">
        <h1 class="w3-button w3-red">Senha é obrigatória para novo usuário!</h1>
    </a>';
    exit;
}

if ($senha !== $confirmaSenha) {
    echo '
    <a href="../pages/cadastro_usuario.php">
        <h1 class="w3-button w3-red">Senha e confirmação de senha não conferem!</h1>
    </a>';
    exit;
}

if (!empty($nome) && !empty($email) && !empty($usuario)) {

    // Verifica se o email já existe
    $stmtCheck = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    if ($stmtCheck->num_rows > 0) {
        // Atualizar usuário

        // Supondo que você tem uma variável $perfil. Caso não tenha, defina um valor padrão.
        $perfil = 'usuario'; // exemplo

        $stmtUpdate = $conn->prepare("
            UPDATE usuarios SET 
                nome = ?, 
                senha = ?, 
                usuario = ?, 
                funcao =?,
                perfil = ?, 
                telefone = ?, 
                historico = ?, 
                especialidade = ? 
            WHERE email = ?
        ");
        $stmtUpdate->bind_param("ssssssss", $nome, $senhaCriptografada, $usuario, $funcao, $perfil, $telefone, $historico, $especialidade, $email);

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
        $stmtInsert = $conn->prepare("
            INSERT INTO usuarios (nome, email, senha, usuario, funcao, telefone, historico, especialidade) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtInsert->bind_param("ssssssss", $nome, $email, $senhaCriptografada, $usuario, $funcao, $telefone, $historico, $especialidade);

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

$conn->close();
?>
