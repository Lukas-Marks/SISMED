<?php
include 'conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM agendamentos WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Agendamento excluído com sucesso!'); window.location='calendario.php';</script>";
} else {
    echo "Erro ao excluir: " . $conn->error;
}

$conn->close();
?>