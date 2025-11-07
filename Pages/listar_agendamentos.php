<?php
session_start();
include 'Conectar.php';

$funcao = $_SESSION['usuario_funcao'] ?? '';
$especialidade = $_SESSION['usuario_especialidade'] ?? '';

if ($funcao === 'Médico') {
    $sql = "SELECT * FROM agendamentos WHERE especialidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $especialidade);
} else {
    $sql = "SELECT * FROM agendamentos";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Agendamentos</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .btn {
      background-color: #007bff;
      color: white;
      padding: 10px;
      text-decoration: none;
      border-radius: 6px;
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<h2>Agendamentos</h2>

<table>
  <thead>
    <tr>
      <th>Nome</th>
      <th>CPF</th>
      <th>Especialidade</th>
      <th>Médico</th>
      <th>Data</th>
      <th>Horário</th>
      <th>Tipo</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['nome_completo']) ?></td>
      <td><?= htmlspecialchars($row['cpf']) ?></td>
      <td><?= htmlspecialchars($row['especialidade']) ?></td>
      <td><?= htmlspecialchars($row['medico']) ?></td>
      <td><?= htmlspecialchars($row['data_consulta']) ?></td>
      <td><?= htmlspecialchars($row['horario']) ?></td>
      <td><?= htmlspecialchars($row['tipo_consulta']) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<a class="btn" href="../Pages/pagina-principal.php">Voltar ao Início</a>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
