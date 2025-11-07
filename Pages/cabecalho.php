<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['funcao'])) {
    $_SESSION['funcao'] = 'Desconhecido';
}

$funcao = $_SESSION['funcao'];
?>

<header>
    <img class="logo" src="../Imagem/Sismed-logo.png" />
    <nav class="desktop-nav">
        <a href="pagina-principal.php">Início</a>

        <?php if ($funcao === 'Administrador'): ?>
            <!-- Acesso total -->
            <a href="agendar.php">Agendar Consulta</a>
            <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="CadastroDePaciente.php">Cadastro Paciente</a>
            <a href="cadastro_usuario.php">Cadastrar Usuário</a>  
            <a href="relatorios.php">Relatórios</a>  

        <?php elseif ($funcao === 'Recepcionista'): ?>
            <!-- Acesso restrito -->
            <a href="agendar.php">Agendar Consulta</a>
            <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="CadastroDePaciente.php">Cadastro Paciente</a>

        <?php elseif ($funcao === 'Médico'): ?>
            <!-- Médico: apenas agenda -->
             <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="prontuario.php">Prontuário</a>
        <?php endif; ?>
    </nav>



    <!-- Barra de navegação do mobile -->
    <nav class="nav-mobile">
        <a href="pagina-principal.php">Início</a>

        <?php if ($funcao === 'Administrador'): ?>
            <a href="agendar.php">Agendar Consulta</a>
            <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="CadastroDePaciente.php">Cadastro Paciente</a>
            <a href="cadastro_usuario.php">Cadastrar Usuário</a>  
            <a href="relatorios.php">Relatórios</a>  

        <?php elseif ($funcao === 'Recepcionista'): ?>
            <a href="agendar.php">Agendar Consulta</a>
            <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="CadastroDePaciente.php">Cadastro Paciente</a>

        <?php elseif ($funcao === 'Médico'): ?>
            <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
            <a href="prontuario.php">Prontuário</a>
        <?php endif; ?>
    </nav>



    <a href="../index.php" class="logout">Sair</a>

            <!-- imagem hamburger -->
            <img class="imagem-ham" src="../Imagem/icon-hamburger.png" />
</header>
