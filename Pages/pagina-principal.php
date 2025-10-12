
<?php


session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}



// Conexão com o banco
include '../ConexaoBD/conectar.php';

$sql = "SELECT * FROM agendamentos ORDER BY data_consulta DESC, horario ASC";
$result = $conexao->query($sql);


$usuario_id = $_SESSION['usuario_id'];

// Buscar nome do usuário logado
$stmt = $conexao->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result_usuario = $stmt->get_result();

if ($result_usuario->num_rows > 0) {
    $row_usuario = $result_usuario->fetch_assoc();
    $usuario = $row_usuario['nome']; // <-- Este será usado na tela
} else {
    $usuario = "Usuário";
}


$sql = "SELECT id, nome, usuario, telefone, email, historico FROM usuarios";

$result = $conexao->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conexao->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Padrão das paginas -->
  <link rel="stylesheet" href="../CSS/mediaquerie.css"/>
  <link rel="stylesheet" href="../CSS/rodape.css"/>
  <link rel="stylesheet" href="../CSS/cabecalho.css"/>
  <link rel="stylesheet" href="../CSS/reset.css"/>
  <link rel="stylesheet" href="../CSS/Pagina-Principal.css"/>


  <title>SISMED - Dashboard</title>
</head>
<body>

  <!-- Navbar e Cabeçalho -->
  <?php include 'cabecalho.php'; ?> 

  <!-- Conteúdo -->
  <div class="container">

    <!-- Boas-vindas -->
    <div class="welcome">
      <!--<span class="user-greeting">Olá, <?php echo htmlspecialchars($usuario); ?></span> -->
      <h2>Bem-vindo(a), <?php echo htmlspecialchars($usuario); ?> 👩‍⚕️</h2>

      <p>Aqui está um resumo do consultório para hoje.</p>
    </div>

    <!-- Cards -->
    <div class="cards">
      <div class="card blue">
        <h3>Pacientes Ativos</h3>
        <p>245</p>
      </div>
      <div class="card green">
        <h3>Consultas Hoje</h3>
        <p>12</p>
      </div>
      <div class="card orange">
        <h3>Pendências</h3>
        <p>4</p>
      </div>
    </div>

    <!-- Tabela -->
  <body>
  <div class="container">
    <h2>Pacientes Agendados</h2>
    
<!-- Botão e seletor de data 
<form method="GET" style="margin-bottom: 20px;">
  <label for="data">📅 Selecionar data: </label>
  <input type="date" id="data" name="data" value="<?php echo isset($_GET['data']) ? $_GET['data'] : date('Y-m-d'); ?>">
  <button type="submit">Buscar</button>
</form>
-->

<form method="GET" id="form-data" style="margin-bottom: 40px;">
  <label for="data">📅 Selecione a data: </label>
  <input type="date" id="data" name="data" value="<?php echo isset($_GET['data']) ? $_GET['data'] : date('Y-m-d'); ?>" style="height: 40px; font-size: 16px; padding: 5px;">
</form>

<script>
  // Quando a data for alterada, o formulário é enviado automaticamente
  document.getElementById('data').addEventListener('change', function () {
    document.getElementById('form-data').submit();
  });
</script>




<table class="agendamentos-table">
  <thead>
    <tr>
      <th style="width: 80px;">Horário</th>
      <th>Nome</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $horarios = ["07:00", "08:00", "09:00", "10:00", "11:00", "14:00", "15:00", "16:00", "17:00", "18:00"];

    // Pega a data selecionada ou usa a de hoje
    $dataSelecionada = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

    foreach ($horarios as $horario) {
        echo "<tr>";
        echo "<td>$horario</td>";

         // Consulta na tabela agendamentos
    $stmt = $conexao->prepare("
        SELECT nome_completo
        FROM agendamentos
        WHERE data_consulta = ? AND horario = ?
    ");
     $stmt->bind_param("ss", $dataSelecionada, $horario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        echo "<td class='status-agendado'>" . htmlspecialchars($linha['nome_completo']) . "</td>";
    } else {
        echo "<td class='status-livre'>-- Livre --</td>";
    }

    echo "</tr>";
}



        // Combinar data e hora no formato DATETIME
    //$dataHora = $dataSelecionada . ' ' . $horario . ':00';

    // Consulta para verificar se há consulta neste horário
    //$stmt = $conexao->prepare("
     //   SELECT p.nome AS paciente_nome
      //  FROM consultas c
       // JOIN pacientes p ON c.paciente_id = p.id
       // WHERE c.data_consulta = ?

       
        //");




       // $stmt->bind_param("s", $dataHora);
       // $stmt->execute();
       // $resultado = $stmt->get_result();



       // if ($resultado->num_rows > 0) {
       //     $linha = $resultado->fetch_assoc();
       //     echo "<td  class='status-agendado'  >" . htmlspecialchars($linha['paciente_nome']) . "</td>";
      //  } else {
      //      echo "<td  class='status-livre' >-- Livre --</td>";
      //  }

      //  echo "</tr>";
    //}
    ?>
  </tbody>
</table>


</table>









    
<!-- Botão para Visualizar Consultas -->
<div style="margin-top: 20px;">
  <a href="consultas.php?data=<?php echo urlencode($dataSelecionada); ?>">
    <button style="
      padding: 12px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    ">
      Ver Consultas de Hoje
    </button>
  </a>
</div>
<div class="container">
   
  </div>



  </div>

  <?php include 'rodape.php'; ?> 


<script src="../JS/jquery.js"></script>
<script> // Usado para garantir que o evento será registrado depois da pagina(DOM) ser carregado
  $(".imagem-ham").click(function() {
    
    $(".nav-mobile").slideToggle();
  });



</script>

</body>
</html>
