<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SISMED - Cadastro de Paciente</title>
  <link rel="stylesheet" href="../CSS/Cabecalho.css">
  <link rel="stylesheet" href="StyleCadastroDePaciente.css">
  <link rel="stylesheet" href="../CSS/rodape.css">
</head>
<body>

<?php include 'cabecalho.php'; ?>

<div class="container">
  <h2>Cadastro de Paciente</h2>

  <form method="POST" action="incluir_paciente.php">
    <div class="section-title">Dados do paciente</div>
    <div class="form-group">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="date" name="data_nascimento" placeholder="Data de nascimento" required>
    </div>
    <div class="form-group">
      <input type="text" name="cpf" placeholder="CPF" required>
    </div>
    <div class="form-group">
      <div class="input-with-unit">
        <input type="number" name="altura" placeholder="Altura" step="0.01" required>
        <span class="unit">cm</span>
      </div>
      <div class="input-with-unit">
        <input type="number" name="peso" placeholder="Peso" step="0.01" required>
        <span class="unit">kg</span>
      </div>
    </div>
    <div class="form-group">
      <input type="tel" name="telefone" placeholder="Telefone" required>
      <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="section-title">Endereço</div>
    <div class="form-group">
      <input type="text" name="rua" placeholder="Rua" required>
      <input type="text" name="numero" placeholder="Número" required>
    </div>
    <div class="form-group">
      <input type="text" name="bairro" placeholder="Bairro" required>
      <input type="text" name="cidade" placeholder="Cidade" required>
    </div>
    <div class="form-group">
      <input type="text" name="estado" placeholder="Estado" required>
      <input type="text" name="cep" placeholder="CEP" required>
    </div>

    <div class="section-title">Histórico médico</div>
    <div class="form-group">
      <textarea name="historico" placeholder="Digite o histórico do paciente"></textarea>
    </div>

    <div class="btn-group">
      <button type="reset" class="btn-secondary">Cancelar</button>
      <button type="submit" class="btn-primary">Salvar</button>
    </div>
  </form>
</div>

<?php include 'rodape.php'; ?>
</body>
</html>
