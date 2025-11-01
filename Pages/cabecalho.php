<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a função está definida na sessão
if (!isset($_SESSION['funcao'])) {
    // Se não estiver, redireciona ou define uma padrão
    $_SESSION['funcao'] = 'Desconhecido';
}

$funcao = $_SESSION['funcao'];


?>





<header>
    <img class="logo" src="../Imagem/Sismed-logo.png" />
    <nav class="desktop-nav">
    <a href="pagina-principal.php">Início</a>

 <?php if ($funcao === 'Administrador' || $funcao === 'Recepcionista'): ?>


    <a href="agendar.php">Agendar Consulta</a>
    <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
    <a href="CadastroDePaciente.php">Cadastro Paciente</a>
    <a href="cadastro_usuario.php">Cadastrar Usuario</a>  

<?php endif; ?>

    </nav>
    <!-- imagem hamburger -->
    <img class="imagem-ham" src="../Imagem/icon-hamburger.png" />
    
    <!-- Barra de navegação do mobile -->
    <nav class="nav-mobile">
    <a href="pagina-principal.php">Início</a>
<?php if ($funcao === 'Administrador' || $funcao === 'Recepcionista'): ?>

    <a href="agendar.php">Agendar Consulta</a>
    <a href="PesquisaDePaciente.php">Pesquisar Paciente</a>
    <a href="CadastroDePaciente.php">Cadastro Paciente</a>
    <a href="cadastro_usuario.php">Cadastrar Usuario</a>

    <?php endif; ?>
    </nav>

    <a href="../index.php" class="logout">Sair</a>
</header>
