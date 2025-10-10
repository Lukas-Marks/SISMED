<?php
include 'conexao.php';

$id = $_POST['id'];
$nome = $_POST['nome_completo'];
$especialidade = $_POST['especialidade'];
$data = $_POST['data_consulta'];
$horario = $_POST['horario'];
$status = $_POST['status'];

$sql = "UPDATE agendamentos 
        SET nome_completo='$nome', especialidade='$especialidade', data_consulta='$data', horario='$horario', status='$status'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Agendamento atualizado com sucesso!'); window.location='calendario.php';</script>";
} else {
    echo "Erro ao atualizar: " . $conn->error;
}
$conn->close();
?>