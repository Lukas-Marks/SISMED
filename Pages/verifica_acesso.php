<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['funcao'])) {
    header("Location: ../index.php");
    exit();
}

// Variável global para função
$funcao = $_SESSION['funcao'];

// Função para bloquear acesso para determinados perfis
function bloquear_acesso_para(array $funcoes_bloqueadas) {
    global $funcao;
    if (in_array($funcao, $funcoes_bloqueadas)) {
        header("Location: ../Pages/pagina-principal.php"); // ou outra página segura
        exit();
    }
}

// Função para permitir acesso somente para determinados perfis
function permitir_acesso_somente(array $funcoes_permitidas) {
    global $funcao;
    if (!in_array($funcao, $funcoes_permitidas)) {
        echo '
        <div style="text-align:center; margin-top:50px; font-family:Arial,sans-serif;">
            <h2 style="color:red;">Acesso negado.</h2>
            <p>Você não tem permissão para acessar esta página.</p>
            <a href="../index.php" style="
                display:inline-block;
                padding:12px 24px;
                background-color:#007bff;
                color:#fff;
                text-decoration:none;
                border-radius:5px;
                font-size:16px;
            ">🔙 Voltar ao Início</a>
        </div>';
        exit();
    }
}
