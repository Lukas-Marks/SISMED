<?php
include 'cabecalho.php';
include 'verifica_acesso.php';
permitir_acesso_somente(['Médico', 'Administrador']);

// Conexão com o banco
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sismed";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Captura os parâmetros de busca
$paciente_id = $_GET['id'] ?? null;
$paciente_nome_busca = $_GET['nome'] ?? null;

$paciente_nome = "";
$anamnese = $exames_fisicos = $solicitacoes = $prescricao = $ultima_atualizacao = "";

// Se informou ID ou nome, busca o paciente
if ($paciente_id || $paciente_nome_busca) {
    if ($paciente_id) {
        $sql = "SELECT id, nome FROM pacientes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $paciente_id);
    } else {
        $sql = "SELECT id, nome FROM pacientes WHERE nome LIKE ?";
        $busca = "%$paciente_nome_busca%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $busca);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($row = $resultado->fetch_assoc()) {
        $paciente_id = $row['id'];
        $paciente_nome = $row['nome'];
    }
    $stmt->close();

    // Busca prontuário
    $sql = "SELECT anamnese, exames_fisicos, solicitacoes, prescricao, ultima_atualizacao 
            FROM prontuario WHERE paciente_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $anamnese = $row['anamnese'];
        $exames_fisicos = $row['exames_fisicos'];
        $solicitacoes = $row['solicitacoes'];
        $prescricao = $row['prescricao'];
        $ultima_atualizacao = date("d/m/Y H:i", strtotime($row['ultima_atualizacao']));
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sismed - Prontuário do Paciente</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/Cabecalho.css">
<link rel="stylesheet" href="../CSS/rodape.css">

<style>
body { background-color: #f3f6fa; font-family: "Segoe UI", sans-serif; }
.container-card {
    background-color: #fff; border-radius: 10px; padding: 25px; margin: 40px auto;
    width: 90%; max-width: 900px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.perfil { display: flex; flex-wrap: wrap; gap: 20px; align-items: center;
          border: 1px solid #e0e0e0; border-radius: 10px; padding: 15px; margin-top: 15px; }
.perfil img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; background-color: #cdd5df; }
.btn-adicionar { background-color: #1bb34a; color: white; border: none; font-weight: 600; border-radius: 6px; }
.btn-adicionar:hover { background-color: #16a340; }
</style>
</head>
<body>

<div class="container-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="fw-bold mb-1">Prontuário Médico</h4>
            <small class="text-muted">Pesquise um paciente para visualizar o prontuário.</small>
        </div>
    </div>
    
       

    <!-- Campo de busca por nome -->
    <form method="GET" class="mt-3 mb-4">
       
        <div class="input-group">
            <input type="text" name="nome" class="form-control" placeholder="Digite o nome do paciente.." value="<?php echo htmlspecialchars($paciente_nome_busca ?? ''); ?>">
            <button class="btn btn-secondary" type="submit"><i class="bi bi-search"></i> Buscar</button>
             
        </button>
        </div>
        


    </form>

    <?php if (!$paciente_id): ?>
        <div class="text-center text-muted mt-5 mb-5">
            <h5><i class="bi bi-person-exclamation"></i> Nenhum paciente selecionado</h5>
            <p>Pesquise um paciente acima para iniciar o atendimento.</p>
        </div>
    <?php else: ?>
    
    <!-- Perfil do paciente -->
    <div class="perfil mt-3">
        <img alt="Foto do paciente" src="../Imagem/Sismed-logo.png">
        <div>
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($paciente_nome ?: 'Paciente sem nome'); ?></h5>
            <p class="text-muted mb-2">Identificador: <?php echo $paciente_id; ?></p>
            <div class="dados">
                <div><i class="bi bi-file-earmark-medical"></i> Atestado: <b>0</b></div>
                <div><i class="bi bi-capsule"></i> Receituário: <b>0</b></div>
            </div>
        </div>
    </div>

    <!-- Formulário do prontuário -->
    <form method="POST" action="atualizar_evolucao.php" class="mt-4">
        <input type="hidden" name="paciente_id" value="<?php echo $paciente_id; ?>">

        <p>Última Atualização: <strong><?php echo $ultima_atualizacao ?: '—'; ?></strong></p>

        <h5>Anamnese 🩺</h5>
        <textarea name="anamnese" class="form-control mb-3" rows="3" placeholder="Digite a anamnese do paciente"><?php echo htmlspecialchars($anamnese); ?></textarea>

        <h5>Exames Físicos 🧪</h5>
        <textarea name="exames_fisicos" class="form-control mb-3" rows="3" placeholder="Descreva os exames físicos"><?php echo htmlspecialchars($exames_fisicos); ?></textarea>

        <h5>Solicitações 📃</h5>
        <textarea name="solicitacoes" class="form-control mb-3" rows="3" placeholder="Digite as solicitações médicas"><?php echo htmlspecialchars($solicitacoes); ?></textarea>

        <h5>Prescrição 💊</h5>
        <textarea name="prescricao" class="form-control mb-3" rows="3" placeholder="Digite a prescrição médica"><?php echo htmlspecialchars($prescricao); ?></textarea>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar Alterações</button>
            <button class="btn btn-adicionar" onclick="adicionarDocumento()">
            <i class="bi bi-plus-lg"></i> Adicionar Documento
        </div>
    </form>
    

    <?php endif; ?>
</div>

<?php include 'rodape.php'; ?>
</body>
</html>
