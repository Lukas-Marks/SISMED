<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Cadastro Usuário</title>
</head>
<body>

<!-- Botão de voltar -->
<a href="index.php" class="w3-display-topleft">
  <i class="fa fa-arrow-circle-left w3-xxlarge w3-button w3-teal"></i>
</a>

<!-- Formulário centralizado -->
<div class="w3-padding w3-content w3-text-grey w3-third w3-margin w3-display-middle">
  <h1 class="w3-center w3-teal w3-round-large w3-margin">Cadastro de Usuários</h1>

  <form action="cadastroAction.php" class="w3-container" method="POST">

    <!-- Código (desativado) -->
    <label class="w3-text-teal" style="font-weight: bold;">Código</label>
    <input name="txtID" class="w3-input w3-grey w3-border" disabled><br>

    <!-- Nome -->
    <label class="w3-text-teal" style="font-weight: bold;">Nome</label>
    <input name="txtNome" class="w3-input w3-light-grey w3-border" required><br>

    <!-- Email -->
    <label class="w3-text-teal" style="font-weight: bold;">Email</label>
    <input name="txtEmail" type="email" class="w3-input w3-light-grey w3-border" required><br>

    <!-- Senha -->
    <label class="w3-text-teal" style="font-weight: bold;">Senha</label>
    <input name="txtSenha" type="password" class="w3-input w3-light-grey w3-border" required><br>

    <!-- Perfil -->
    <label class="w3-text-teal" style="font-weight: bold;">Perfil</label>
    <select name="txtPerfil" class="w3-select w3-light-grey w3-border" required>
      <option value="" disabled selected>Selecione um perfil</option>
      <option value="admin">Administrador</option>
      <option value="usuario">Usuário</option>
    </select>
    <br><br>

    <!-- Botão de enviar -->
    <button name="btnAdicionar" type="submit" class="w3-button w3-teal w3-cell w3-round-large w3-right w3-margin-right">
      <i class="w3-xxlarge fa fa-user-plus"></i> Adicionar
    </button>
  </form>
</div>

</body>
</html>
