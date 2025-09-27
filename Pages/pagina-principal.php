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
      <h2>Bem-vindo(a), {  Dr(a). Silva } 👩‍⚕️</h2>
      <p>Aqui esta um resumo do consultório para hoje.</p>
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
    <table>
      <thead>
        <tr>
          <th>Paciente</th>
          <th>Horário</th>
          <th>Médico</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>João Pereira</td>
          <td>09:30</td>
          <td>Dr. Silva</td>
          <td><span class="status confirmado">Confirmado</span></td>
        </tr>
        <tr>
          <td>Maria Oliveira</td>
          <td>10:15</td>
          <td>Dra. Souza</td>
          <td><span class="status aguardando">Aguardando</span></td>
        </tr>
        <tr>
          <td>Carlos Lima</td>
          <td>11:00</td>
          <td>Dr. Silva</td>
          <td><span class="status cancelado">Cancelado</span></td>
        </tr>
      </tbody>
    </table>

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
