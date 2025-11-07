<?php
// Conexão com o banco
include 'Conectar.php';

$sql = "SELECT id, nome, usuario, funcao, especialidade, telefone, email, historico FROM usuarios";

$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
    <title>Usuários Cadastrados</title>
  <link rel="stylesheet" href="../CSS/cadastro_usuario.css"> <!-- Usa o mesmo CSS -->
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .container {
      width: 80%;
      margin: 40px auto;
    }

    .btn-voltar {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }

    .btn-voltar:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
    <div class="container">
    <h2>Usuários Cadastrados</h2>

    <?php if ($result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Usuário</th>
            <th>Função</th>>
            <th>Especialidade</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Histórico</th>
            
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>              
              <td><?= htmlspecialchars($row['nome']) ?></td>
              <td><?= htmlspecialchars($row['usuario']) ?></td> 
              <td><?= htmlspecialchars($row['funcao']) ?></td>
              <td><?= htmlspecialchars($row['especialidade']) ?></td>            
              <td><?= htmlspecialchars($row['telefone']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['historico'])) ?></td>            
             
              <td>
                <a href="editar_usuario.php?id=<?= $row['id'] ?>" style="margin-right: 10px;">Editar</a>
                <a href="excluir_usuario.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');" style="color: red;">Excluir</a>
              </td>


            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Nenhum usuário cadastrado ainda.</p>
    <?php endif; ?>

    <a class="btn-voltar" href="cadastro_usuario.php">Voltar ao Cadastro</a>
  </div>
</body>
</html>

<?php
$conn->close();
?>
