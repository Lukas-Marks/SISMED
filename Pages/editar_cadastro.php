<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Editar Paciente</title>

      <!-- CSS Padrão das paginas -->
  <link rel="stylesheet" href="../CSS/mediaquerie.css"/>
  <link rel="stylesheet" href="../CSS/rodape.css"/>
  <link rel="stylesheet" href="../CSS/cabecalho.css"/>
  <link rel="stylesheet" href="../CSS/reset.css"/>

  <link rel="stylesheet" href="../CSS/editar_cadastro.css" />
</head>
<body>

<?php include 'cabecalho.php'; ?> 

  <div class="container">
    <div class="card">
      <h2>Editar Cadastro</h2>

      <label for="matricula">ID ou matrícula:</label>
      <input type="text" id="matricula">
      <button class="btn" onclick="buscarPaciente()">Buscar</button>
     </div>
  </div>

  <?php include 'rodape.php'; ?> 

  <script>
    function buscarPaciente() {
      const id = document.getElementById('matricula').value.trim();
      if (!id) {
        alert("Digite um ID ou matrícula para buscar.");
        return;
      }
      alert("Buscando paciente com ID/matrícula: " + id);
    }
  </script>

  
</body>
</html>
