<?php

include 'Conectar.php';


$nome = $_GET['nome'] ?? '';
$telefone = $_GET['telefone'] ?? '';
$data_nascimento = $_GET['data_nascimento'] ?? '';
$email = $_GET['email'] ?? '';
$id = $_GET['id'] ?? '';

if ($nome !== '' || $telefone !== '' || $data_nascimento !== '' || $email !== '' || $id !== '') {
    // Todos os campos estão preenchidos
    // Você pode seguir com a consulta ou atribuir a uma variável
    $filtrosValidos = true;
  } else {
    // Algum campo está vazio
    $filtrosValidos = false;
  }
  


$sql = "SELECT id, nome, data_nascimento, telefone, email FROM pacientes WHERE 1=1";

if ($nome) {
  $sql .= " AND nome LIKE '%" . $conn->real_escape_string($nome) . "%'";
}
if ($telefone) {
  $sql .= " AND telefone LIKE '%" . $conn->real_escape_string($telefone) . "%'";
}
if ($data_nascimento) {
  $sql .= " AND data_nascimento = '" . $conn->real_escape_string($data_nascimento) . "'";
}
if ($email) {
  $sql .= " AND email LIKE '%" . $conn->real_escape_string($email) . "%'";
}

if ($id) {
  $sql .= " AND id = '" . $conn->real_escape_string($id) . "'";
} 


$result = $conn->query($sql);

$pacientes = [];
while ($row = $result->fetch_assoc()) {
  $pacientes[] = $row;

}



  
// header('Content-Type: application/json');
// print_r(count($pacientes));
// echo ($pacientes)[0]['nome'];
// echo ($pacientes)[0]['data_nascimento'];
// echo ($pacientes)[0]['telefone'];
// echo ($pacientes)[0]['email'];


?>
