<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>SISMED - Cadastrar Usuário</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    :root{
      --blue: #1976d2;
      --blue-dark: #125a9e;
      --card-bg: #ffffff;
      --panel-bg: #fbfbfb;
      --muted: #6b6b6b;
      --border: #eef0f2;
      --shadow: 0 8px 18px rgba(20,30,40,0.08);
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: #f0f2f5;
      color:#222;
    }

    
    .header{
      background: var(--blue);
      color:white;
      padding: 18px 24px;
      font-weight:700;
      font-size:20px;
    }

    
    .wrap{
      min-height: calc(100vh - 64px);
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 36px 16px;
    }

    
    .card {
      width: 450px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 12px 30px rgba(10,20,30,0.12);
      padding: 16px;
    }

    .title {
      font-size: 24px;
      font-weight:700;
      margin: 6px 6px 18px 6px;
      color: #333;
    }

    
    .panel {
      background: var(--panel-bg);
      border-radius: 6px;
      padding: 20px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
    }

    .section-title {
      font-weight:700;
      font-size:14px;
      margin-bottom:10px;
      color:#222;
    }

    .field-label {
      display:block;
      font-size:12px;
      color:var(--muted);
    }

    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="password"],
    textarea {
      width:100%;
      border:1px solid #e0e6ea;
      border-radius:6px;
      padding:10px 12px;
      font-size:14px;
      outline:none;
      background:white;
    }
    input:focus, textarea:focus{ box-shadow:0 0 0 3px rgba(25,118,210,0.06); border-color:var(--blue); }

    textarea {
      min-height:82px;
      resize:vertical;
    }

    
    .row {
      display:flex;
      gap:12px;
    }
    .col {
      flex:1;
    }

    .btn {
      margin-top:16px;
      width:100%;
      padding:10px 12px;
      border-radius:6px;
      border: none;
      background: var(--blue);
      color: white;
      font-size:16px;
      cursor:pointer;
      font-weight:600;
    }
    .btn:hover{ background: var(--blue-dark); }

    
    .mb-14{ margin-bottom:14px; }
    .mb-8{ margin-bottom:8px; }
  </style>
</head>
<body>
  <div class="header">SISMED</div>

  <div class="wrap">
    <div class="card">
      <div class="title">Cadastrar Usuário</div>

      <div class="panel">
        <!-- Dados pessoais -->
        <div class="section mb-14">
          <div class="section-title">Dados pessoais</div>
          <label class="field-label" for="nome">Nome</label>
          <input id="nome" type="text" />
        </div>

        <!-- Login -->
        <div class="section mb-14">
          <div class="section-title">Login</div>
          <label class="field-label" for="usuario">Usuário</label>
          <input id="usuario" type="text" />
        </div>

        <!-- Contato -->
        <div class="section mb-14">
          <div class="section-title">Contato</div>
          <div class="row">
            <div class="col">
              <label class="field-label" for="telefone">Telefone</label>
              <input id="telefone" type="tel" />
            </div>
            <div class="col">
              <label class="field-label" for="email">Email</label>
              <input id="email" type="email" />
            </div>
          </div>
        </div>

        
        <div class="section mb-14">
          <div class="section-title">Senha</div>

          <label class="field-label" for="senha">Senha</label>
          <input id="senha" type="password" />

          <div style="height:8px"></div>

          <label class="field-label" for="confirmaSenha">Confirmar Senha</label>
          <input id="confirmaSenha" type="password" />
        </div>

        
        <div class="section mb-8">
          <div class="section-title">Histórico</div>
          <textarea id="historico"></textarea>
        </div>

        <button class="btn" onclick="cadastrarUsuario()">Cadastrar</button>
      </div>
    </div>
  </div>

  <script>
    function cadastrarUsuario(){
      const nome = document.getElementById('nome').value.trim();
      const usuario = document.getElementById('usuario').value.trim();
      const telefone = document.getElementById('telefone').value.trim();
      const email = document.getElementById('email').value.trim();
      const senha = document.getElementById('senha').value;
      const confirma = document.getElementById('confirmaSenha').value;
      const historico = document.getElementById('historico').value.trim();

      if (senha !== confirma) {
        alert("As senhas não conferem.");
        return;
      }

      
      alert(
        "Dados do formulário:\n" +
        "Nome: " + nome + "\n" +
        "Usuário: " + usuario + "\n" +
        "Telefone: " + telefone + "\n" +
        "Email: " + email + "\n" +
        "Histórico: " + (historico ? historico : "(vazio)")
      );
    }
  </script>
</body>
</html>

