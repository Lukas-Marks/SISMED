<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>SISMED - Cadastrar Usuário</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="../CSS/cadastro_usuario.css?v=1.2">
  <link rel="stylesheet" href="../CSS/Cabecalho.css">
</head>
<body>

<?php include 'cabecalho.php'; ?>

  <form action="cadastroAction.php" class="w3-container" method="POST">
  <div class="wrap">
    <div class="card">
      <div class="title">Cadastrar Usuário</div>

      <div class="panel">
        <!-- Dados pessoais -->
        <div class="section mb-14">
          <div class="section-title">Dados pessoais</div>

          <!-- Nome -->
          <label class="field-label" for="nome">Nome</label>
          <input id="nome" name="txtnome" type="text" />

          <!-- Função -->
          <label class="field-label" for="funcao">Função</label>
          <select id="funcao" name="funcao" required onchange="mostrarEspecialidade()">
            <option value="">Selecione uma função</option>
            <option value="Administrador">Administrador</option>
            <option value="Recepcionista">Recepcionista</option>
            <option value="Médico">Médico</option>
          </select>

          <!-- Especialidade (inicialmente escondida) -->
          <div id="campo-especialidade" style="display: none; margin-top: 10px;">
            <label class="field-label" for="especialidade">Especialidade</label>
            <select id="especialidade" name="especialidade">
              <option value="">Selecione a especialidade</option>
              <option value="Cardiologia">Cardiologia</option>
              <option value="Pediatria">Pediatria</option>
              <option value="Clínico Geral">Clínico Geral</option>
              
            </select>
          </div>
        </div>

        <!-- Login -->
        <div class="section mb-14">
          <div class="section-title">Login</div>
          <label class="field-label" for="usuario">Usuário</label>
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

        <!-- Senha -->
        <div class="section mb-14">
          <div class="section-title">Senha</div>
          <label class="field-label" for="senha">Senha</label>
          <input id="senha" name="txtSenha" type="password" />
          <div style="height:8px"></div>
          <label class="field-label" for="confirmaSenha">Confirmar Senha</label>
          <input id="confirmaSenha" name="txtConfirmaSenha" type="password" />
        </div>

        <!-- Histórico -->
        <div class="section mb-8">
          <div class="section-title">Histórico</div>
          <textarea id="historico" name="txthistorico"></textarea>
        </div>

        <!-- Botões -->
        <div class="button-group">
          <button class="btn" type="submit">SALVAR</button> <p></p>
          <a class="btn" href="usuarios.php">Ver Usuários</a>
          <p></p>
          <a class="btn" href="../Pages/pagina-principal.php">Voltar</a>
        </div>

      </div>
    </div>
  </div>
  </form>

  <!-- SCRIPT PARA MOSTRAR/ESCONDER ESPECIALIDADE -->
  <script>
    function mostrarEspecialidade() {
      const funcao = document.getElementById('funcao').value;
      const campoEspecialidade = document.getElementById('campo-especialidade');

      if (funcao === "Médico") {
        campoEspecialidade.style.display = "block";
      } else {
        campoEspecialidade.style.display = "none";
        document.getElementById('especialidade').value = ""; // limpa especialidade
      }
    }

    // Executa ao carregar a página (caso o navegador mantenha os dados)
    window.onload = mostrarEspecialidade;
  </script>
</body>
</html>
