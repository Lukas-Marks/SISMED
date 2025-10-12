<?php
include '../ConexaoBD/conectar.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conexao->close();
        header("Location: usuarios.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir usuário: " . $stmt->error;
    }
} else {
    echo "ID do usuário não informado.";
}
?>
