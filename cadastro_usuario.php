<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>SISMED - Cadastrar Usuário</title>
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
      width: 350px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
      margin-top: 0;
      font-size: 22px;
      text-align: center;
    }
    .section-title {
      font-weight: bold;
      margin-top: 15px;
      font-size: 14px;
    }
    input, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .row {
      display: flex;
      gap: 10px;
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
  <div class="header">SISMED</div>
  <div class="container">
    <div class="card">
      <h2>Cadastrar Usuário</h2>

      <div class="section-title">Dados pessoais</div>
      <input type="text" id="nome" placeholder="Nome">

      <div class="section-title">Login</div>
      <input type="text" id="usuario" placeholder="Usuário">

      <div class="section-title">Contato</div>
      <div class="row">
        <input type="tel" id="telefone" placeholder="Telefone">
        <input type="email" id="email" placeholder="Email">
      </div>

      <div class="section-title">Histórico</div>
      <textarea id="historico" rows="3" placeholder="Digite aqui..."></textarea>

      <button class="btn" onclick="cadastrarUsuario()">Cadastrar</button>
    </div>
  </div>

  <script>
    function cadastrarUsuario() {
      const nome = document.getElementById('nome').value;
      const usuario = document.getElementById('usuario').value;
      const telefone = document.getElementById('telefone').value;
      const email = document.getElementById('email').value;
      const historico = document.getElementById('historico').value;

      alert(`Usuário cadastrado:\nNome: ${nome}\nUsuário: ${usuario}\nTelefone: ${telefone}\nEmail: ${email}\nHistórico: ${historico}`);
    }
  </script>
</body>
</html>
