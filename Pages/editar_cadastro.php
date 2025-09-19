<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Editar Paciente</title>
  <link rel="stylesheet" href="../CSS/editar_cadastro.css" />
</head>
<body>
  <div class="header">
    SISMED
    <div class="nav">
      <a href="index.html">Início</a>
      <a href="#">Pacientes</a>
      <a href="#">Consultas</a>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <h2>Editar Cadastro</h2>

      <label for="matricula">ID ou matrícula:</label>
      <input type="text" id="matricula">
      <button class="btn" onclick="buscarPaciente()">Buscar</button>
     </div>
  </div>

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
