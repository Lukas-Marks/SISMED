
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sismed - Histórico do Paciente</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/Cabecalho.css">
<link rel="stylesheet" href="../CSS/rodape.css">

<style>
    body {
        background-color: #f3f6fa;
        font-family: "Segoe UI", sans-serif;
    }


    header .title {
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 20px;
    }

    header .title i {
        font-size: 24px;
        margin-right: 10px;
    }

    .container-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 25px;
        margin: 40px auto;
        width: 90%;
        max-width: 900px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .breadcrumb {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .btn-adicionar {
        background-color: #1bb34a;
        color: white;
        border: none;
        font-weight: 600;
        border-radius: 6px;
    }

    .btn-adicionar:hover {
        background-color: #1bb34a;
    }

    .perfil {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        margin-top: 15px;
    }

    .perfil img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #cdd5df;
    }

    .dados {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .dados div {
        background-color: #f1f3f5;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
    }

    .tabs {
        border-bottom: 2px solid #dee2e6;
        margin-top: 25px;
    }

    .tab {
        display: inline-block;
        padding: 10px 18px;
        cursor: pointer;
        font-weight: 600;
        color: #555;
        border-bottom: 3px solid transparent;
    }

    .tab.active {
        color: #007bff;
        border-bottom: 3px solid #007bff;
    }

    .conteudo {
        margin-top: 20px;
    }

    .campo {
        padding: 1%;
        border-radius: 5px;
        border: 1px solid black;
        margin: 10px 0;
        width: 95%;
    }
    .campo:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
</style>

</head>
<body>

<?php 
include 'cabecalho.php';
include 'consultarprontuario.php';

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sismed";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}

$paciente_id = $pacientes[0]['id'] ?? null;
if (!$paciente_id) {
  echo "Paciente não especificado.";
  exit;
}

$sql = "SELECT anamnese, exames_fisicos, solicitacoes,prescricao, ultima_atualizacao FROM prontuario WHERE paciente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $paciente_id);
$stmt->execute();
$result = $stmt->get_result();

$anamnese = "";
$exames_fisicos = "";
$solicitacoes = "";
$ultima_atualizacao = "";
$prescricao = "";

if ($row = $result->fetch_assoc()) {
  $anamnese = $row['anamnese'];
  $exames_fisicos = $row['exames_fisicos'];
  $solicitacoes = $row['solicitacoes'];
  $prescricao = $row['prescricao'];
  $ultima_atualizacao = date("d/m/Y H:i", strtotime($row['ultima_atualizacao']));
}

$stmt->close();
$conn->close();

;

?>

<div class="container-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="fw-bold mb-1">Histórico do paciente</h4>
            
            <!-- <div class="breadcrumb">Paciente • <?php echo ($pacientes)[0]['nome']; ?></div> -->
        </div>
        <button class="btn btn-adicionar" onclick="adicionarDocumento()">
            <i class="bi bi-plus-lg"></i> Adicionar Documento
        </button>
    </div>

    
    <div class="perfil mt-3">
        
        <img alt="Foto do paciente" id="fotoPaciente" src="../Imagem/Sismed-logo.png">
        <div>
            <h5 class="fw-bold mb-1" id="nomePaciente"> <?php echo ($pacientes)[0]['nome']; ?></h5>
            <p class="text-muted mb-2" id="codigoPaciente">Numero do Identificador · <?php  echo $paciente_id = ($pacientes)[0]['id'];?></p>
            <div class="dados">
                <div><i class="bi bi-file-earmark-medical"></i> Atestado:<b> 0</b></div>
                <div><i class="bi bi-capsule"></i> Receituário: <b>0</b></div>
            </div>
        </div>
    </div>

    
    <div class="tabs">
        <span class="tab active" onclick="mostrarTab('evolucao', event)">Evolução Médica</span>
        <span class="tab" onclick="mostrarTab('exames', event)">Exames</span>
        <span class="tab" onclick="mostrarTab('documentos', event)">Documentos</span>
    </div>

    
    <div class="conteudo" id="conteudo">
  <form method="POST" action="atualizar_evolucao.php">
    <!-- ID do paciente -->
    <input type="hidden" name="paciente_id" value="<?php echo $paciente_id = ($pacientes)[0]['id'];?>">

    <p>Ultima Atualização: <strong><?php echo $ultima_atualizacao?> </strong></p>
    <h5>Anamnese 🩺</h5>
    <textarea name="anamnese" id="anamnese" class="form-control mb-3" rows="3" placeholder="Digite a anamnese do paciente"><?php echo $anamnese?></textarea>

    <h5>Exames Físicos 🧪</h5>
    <textarea name="exames_fisicos" id="exames_fisicos" class="form-control mb-3" rows="3" placeholder="Descreva os exames físicos"><?php echo $exames_fisicos ?></textarea>


    <h5>Solicitações 📃</h5>
    <textarea name="solicitacoes" id="solicitacoes" class="form-control mb-3" rows="3" placeholder="Digite as solicitações médicas"><?php echo $solicitacoes ?></textarea>

    <h5>Prescrição 💊</h5>
    <textarea name="prescricao" id="prescricao" class="form-control mb-3" rows="3" placeholder="Digite as solicitações médicas"><?php echo $prescricao ?></textarea>


    <!-- Botão de envio -->
    <div class="text-end mt-3">
                <button type="submit" class="btn btn-success" onclick="salvarAlteracoes()">
                    <i class="bi bi-save"></i> Salvar Alterações
                </button>
    </div>
  </form>
</div>




</div>

<script>
function mostrarTab(tab, event) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    const conteudo = document.getElementById('conteudo');

    if (tab === 'evolucao') {
        conteudo.innerHTML = `
    <p>Ultima Atualização: <strong><?php echo $ultima_atualizacao?> </strong></p>
    <h5>Anamnese</h5>
    <textarea name="anamnese" id="anamnese" class="form-control mb-3" rows="3" placeholder="Digite a anamnese do paciente"><?php echo $anamnese?></textarea>

    <h5>Exames Físicos</h5>
    <textarea name="exames_fisicos" id="exames_fisicos" class="form-control mb-3" rows="3" placeholder="Descreva os exames físicos"><?php echo $exames_fisicos ?></textarea>


    <h5>Solicitações</h5>
    <textarea name="solicitacoes" id="solicitacoes" class="form-control mb-3" rows="3" placeholder="Digite as solicitações médicas"><?php echo $solicitacoes ?></textarea>

        <h5>Prescrição</h5>
    <textarea name="prescricao" id="prescricao" class="form-control mb-3" rows="3" placeholder="Digite as solicitações médicas"><?php echo $prescricao ?></textarea>
            
                <!-- Botão de envio -->
    <div class="text-end mt-3">
                <button type="submit" class="btn btn-success" onclick="salvarAlteracoes()">
                    <i class="bi bi-save"></i> Salvar Alterações
                </button>
    </div>`;
    }else if (tab === 'exames') {
        conteudo.innerHTML = `<p><i class='bi bi-clipboard2-pulse'></i> Nenhum exame disponível.</p>`;
    } else {
        conteudo.innerHTML = `<p><i class='bi bi-folder2-open'></i> Nenhum documento adicionado.</p>`;
    }
}

// async function salvarAlteracoes() {
//     const paciente_id = 1; // Ajuste se usar ID dinâmico
//     const anamnese = document.getElementById('anamnese').value.trim();
//     const exames_fisicos = document.getElementById('exames_fisicos').value.trim();
//     const solicitacoes = document.getElementById('solicitacoes').value.trim();

//     if (!anamnese && !exames_fisicos && !solicitacoes) {
//         alert('Preencha ao menos um campo para salvar.');
//         return;
//     }

//     const dados = new FormData();
//     dados.append('paciente_id', paciente_id);
//     dados.append('anamnese', anamnese);
//     dados.append('exames_fisicos', exames_fisicos);
//     dados.append('solicitacoes', solicitacoes);

//     try {
//         const resposta = await fetch('atualizar_evolucao.php', {
//             method: 'POST',
//             body: dados
//         });

//         const resultado = await resposta.json();

//         if (resultado.sucesso) {
//             alert('Alterações salvas com sucesso!');
//         } else {
//             alert('Erro ao salvar as alterações: ' + (resultado.erro || 'Desconhecido.'));
//         }
//     } catch (e) {
//         alert('Erro de conexão ao salvar as alterações.');
//     }
// }
</script>

<?php 

include 'rodape.php';
?>

</body>