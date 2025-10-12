<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>SISMED - Cadastrar Usuário</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="../CSS/cadastro_usuario.css?v=1.2">
  <style>
    

  </style>
</head>
<body>
  <div class="header">SISMED</div>

  <form action="cadastroAction.php" class="w3-container" method="POST">
    
  <div class="wrap">
    <div class="card">
      <div class="title">Cadastrar Usuário</div>

      <div class="panel">
        <!-- Dados pessoais -->
        <div class="section mb-14">
          <div class="section-title">Dados pessoais</div>
          <label class="field-label" for="nome">Nome</label>
          <input id="nome" name="txtnome" type="text" />
        </div>

        <!-- Login -->
        <div class="section mb-14">
          <div class="section-title">Login</div>
          <label class="field-label" for="perfil">Usuário</label>
          <input id="usuario" name="txtusuario" type="text" />
        </div>

        <!-- Contato -->
        <div class="section mb-14">
          <div class="section-title">Contato</div>
          <div class="row">
            <div class="col">
              <label class="field-label" for="telefone">Telefone</label>
              <input id="telefone" name="txttelefone" type="tel" />
            </div>
            <div class="col">
              <label class="field-label" for="email">Email</label>
              <input id="email" name="txtEmail" type="email" />
            </div>
          </div>
        </div>

        
        <div class="section mb-14">
          <div class="section-title">Senha</div>

          <label class="field-label" for="senha">Senha</label>
          <input id="senha" name="txtSenha" type="password" />

          <div style="height:8px"></div>

          <label class="field-label" for="confirmaSenha">Confirmar Senha</label>
          <input id="confirmaSenha" name="txtConfirmaSenha"  type="password" />
        </div>

        
        <div class="section mb-8">
          <div class="section-title">Histórico</div>
          <textarea id="historico" name="txthistorico"></textarea>
        </div>
           
        <div class="button-group">
        <button class="btn" type="submit">SALVAR</button> <p> </p>
        <a class="btn" href="usuarios.php" >Ver Usuários </a>
        <p></p>
        <a class="btn" href="../Pages/pagina-principal.php">Voltar</a>
        </div>




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

