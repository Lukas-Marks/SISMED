<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/Pagina-Principal.css"/>
  <title>SISMED - Dashboard</title>

</head>
<body>

  <!-- Navbar -->
  <header>
    <img class="logo" src="../Imagem/Sismed-logo.png" />
    <nav class="desktop-nav">
      <a href="#">Início</a>
      <a href="#">Pacientes</a>
      <a href="#">Consultas</a>
      <a href="#">Relatórios</a>
      <a href="#">Configurações</a>
    </nav>
    <!-- imagem hamburger -->
    <img class="imagem-ham" src="../Imagem/icon-hamburger.png" />
    
    <!-- Barra de navegação do mobile -->
    <nav class="nav-mobile">
      <a href="https://google.com">Início</a>
      <a href="https://google.com">Pacientes</a>
      <a href="https://google.com">Consultas</a>
      <a href="https://google.com">Relatórios</a>
      <a href="https://google.com">Configurações</a>
    </nav>

    <a href="../index.php" class="logout">Sair</a>
  </header>

  <!-- Conteúdo -->
  <div class="container">

    <!-- Boas-vindas -->
    <div class="welcome">
      <h2>Bem-vindo(a), Dr(a). Silva 👩‍⚕️</h2>
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

  <script src="../JS/jquery.js"></script>
 <script>

// Usado para garantir que o evento será registrado depois da pagina(DOM) ser carregado


  $(".imagem-ham").click(function() {
    
    $(".nav-mobile").slideToggle();
  });



 </script>

</body>
</html>
