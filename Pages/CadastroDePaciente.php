<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SISMED - Cadastro de Paciente</title>
  
  <link rel="stylesheet" href="../CSS/StyleCadastroDePaciente.css">
  
      <!-- CSS Padrão das paginas -->
    <link rel="stylesheet" href="../CSS/mediaquerie.css"/>
  <link rel="stylesheet" href="../CSS/rodape.css"/>
  <link rel="stylesheet" href="../CSS/cabecalho.css"/>
  <link rel="stylesheet" href="../CSS/reset.css"/>
</head>
<body>

<?php include 'cabecalho.php'; ?> 

  <div class="container">
    <h2>Cadastro de Paciente</h2>

    
    <div class="section-title">Dados do paciente</div>
    <div class="form-group">
      <input type="text" placeholder="Nome completo">
      <input type="date" placeholder="Data de nascimento">
    </div>
    <div class="form-group">
      <div class="input-with-unit">
        <input type="number" placeholder="Altura">
        <span class="unit">cm</span>
      </div>
      <div class="input-with-unit">
        <input type="number" placeholder="Peso">
        <span class="unit">kg</span>
      </div>
    </div>
    <div class="form-group">
      <input type="tel" placeholder="Telefone">
      <input type="email" placeholder="Email">
    </div>

   
    <div class="section-title">Endereço</div>
    <div class="form-group">
      <input type="text" placeholder="Rua">
      <input type="text" placeholder="Número">
    </div>
    <div class="form-group">
      <input type="text" placeholder="Bairro">
      <input type="text" placeholder="Cidade">
    </div>
    <div class="form-group">
      <input type="text" placeholder="Estado">
      <input type="text" placeholder="CEP">
    </div>

    
    <div class="section-title">Histórico médico</div>
    <div class="form-group">
      <textarea placeholder="Digite o histórico do paciente"></textarea>
    </div>

    
    <div class="btn-group">
      <button class="btn-secondary">Cancelar</button>
      <button class="btn-primary">Salvar</button>
    </div>
  </div>

  <?php include 'rodape.php'; ?> 

</body>
</html>