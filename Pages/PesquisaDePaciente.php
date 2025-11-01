<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SISMED - Pesquisa de Pacientes</title>
  <link rel="stylesheet" href="StylePesquisaDePaciente.css">
  <link rel="stylesheet" href="../CSS/Cabecalho.css">
</head>
<body>

<?php 

include 'cabecalho.php';
include 'consultarPaciente.php';
?>

  <div class="container">
    <h2>Pesquisa de Pacientes</h2>


<form method="get">
    <div class="section-title">Filtros de busca</div>
    <div class="form-group">
    <input type="text" id="nome" name="nome" placeholder="Nome">
    <input type="text" id="data_nascimento" name="data_nascimento" placeholder="Data de nascimento" 
    onfocus="(this.type='date')" onblur="(this.type='text')">
    </div>
    <div class="form-group">
    <input type="tel" id="telefone" name="telefone" placeholder="Telefone">
    <input type="email" id="email" name="email" placeholder="Email">
    </div>
    <div class="form-group">
    <input type="text" id="id" name="id" placeholder="Pesquisar por ID">
    </div>

    <div class="btn-group">
      <button class="btn-secondary"  onclick="limpar()">Limpar filtros</button>
      <input type="submit" class="btn-primary"  onclick="buscar()"value="Buscar">
    </div>
</form> 

    <div class="results">
      <div class="results-header">
        <h2>Resultados da busca</h2>
        <a href="CadastroDePaciente.php">Novo Cadastro</a>
      </div>

      <table>
        <thead>
          <tr>
            <th>Nome do paciente</th>
            <th>Data de nascimento</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>
          </thead>

          <tbody id="resultados">

          <?php 

          if ($filtrosValidos == true) {
            for ($i = 0; $i < count($pacientes); $i++) {
              echo '<tr>';
              echo '<td>'.$pacientes[$i]['nome'].'</td>';
              echo '<td>'.$pacientes[$i]['data_nascimento'].'</td>';
              echo '<td>'.$pacientes[$i]['telefone'].'</td>';
              echo '<td>'.$pacientes[$i]['email'].'</td>';
              echo '<td>'.'Button'.'</td>';
              echo '</tr>';
              }   }

          ?>          
          


          </tbody>
        
      </table>
    </div>
  </div>
 <script>
    function limpar() {
      document.querySelectorAll("input").forEach(input => input.value = "");
      <?php $pacientes = []; ?>
    }


  document.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
      event.preventDefault(); // evita envio automático do formulário
      document.querySelector(".btn-primary").click(); // simula clique no botão "Salvar"
    }
  });

  </script>

</body>

</html>
