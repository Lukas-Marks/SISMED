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
      padding: 15px 25px;
      font-size: 22px;
      font-weight: bold;
    }
    .nav {
      position: absolute;
      right: 30px;
      top: 15px;
    }
    .nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
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
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 350px;
      text-align: center;
    }
    h2 {
      margin-top: 0;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .btn {
      background: #1976d2;
      color: white;
      border: none;
      padding: 10px;
      margin-top: 15px;
      width: 100%;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn:hover {
      background: #125a9e;
    }
  </style>
</head>
<body>
  <div class="header">
    SISMED
    <div class="nav">
      <a href="#">Início</a>
      <a href="#">Pacientes</a>
      <a href="#">Consultas</a>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <h2>Editar Paciente</h2>
      <label for="matricula">ID ou matrícula:</label>
      <input type="text" id="matricula" placeholder="Digite o ID ou matrícula">
      <button class="btn" onclick="buscarPaciente()">Buscar</button>
    </div>
  </div>

  <script>
    function buscarPaciente() {
      const id = document.getElementById('matricula').value;
      if(id.trim() === '') {
        alert('Digite um ID ou matrícula para buscar.');
      } else {
        alert('Buscando paciente com ID/matrícula: ' + id);
      }
    }
  </script>
</body>
</html>
