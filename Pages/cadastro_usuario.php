<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>SISMED - Cadastrar Usuário</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="../CSS/cadastro_usuario.css" />
  <style>
    
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

