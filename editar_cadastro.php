<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Editar Paciente</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
    }
    .header {
      background: #1976d2;
      color: white;
      padding: 15px 20px;
      font-weight: bold;
      font-size: 20px;
      position: relative;
    }
    .nav {
      position: absolute;
      right: 20px;
      top: 15px;
    }
    .nav a {
      color: white;
      text-decoration: none;
      margin-left: 15px;
      font-weight: 500;
    }
    .nav a:hover {
      text-decoration: underline;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      background: white;
      border-radius: 8px;
      padding: 20px 25px;
      width: 360px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    h2 {
      margin-top: 0;
      font-size: 22px;
    }
    label {
      font-size: 14px;
      font-weight: bold;
      display: block;
      text-align: left;
      margin-top: 10px;
    }
    input {
      width: 95%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .btn {
      background: #1976d2;
      color: white;
      border: none;
      padding: 10px;
      margin-top: 20px;
      width: 100%;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn:hover {
      background: #125a9e;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 10px;
      color: #1976d2;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
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
      <h2>Editar Paciente</h2>

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
