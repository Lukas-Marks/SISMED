// Buscar paciente por CPF ou código
async function buscarPaciente() {
    const cpf = document.getElementById("cpf").value.trim();

    if (!cpf) {
        alert("Digite o CPF ou código do paciente!");
        return;
    }

    const resposta = await fetch("listar_pacientes.php");
    const pacientes = await resposta.json();
    const paciente = pacientes.find(p => p.codigo === cpf);

    if (!paciente) {
        alert("Paciente não encontrado!");
        return;
    }

    // Mostra informações básicas
    document.getElementById("dadosPaciente").style.display = "block";
    document.getElementById("nomePaciente").innerText = paciente.nome;
    document.getElementById("codigoPaciente").innerText = "Código: " + paciente.codigo;

    // Busca histórico médico
    carregarHistorico(paciente.id);
}

// Carregar evoluções (histórico do paciente)
async function carregarHistorico(paciente_id) {
    const resposta = await fetch(`historico.php?paciente_id=${paciente_id}`);
    const historico = await resposta.json();

    if (historico.length > 0) {
        const ultima = historico[0];
        document.getElementById("anamnese").innerText = ultima.anamnese || "-";
        document.getElementById("exames").innerText = ultima.exames_fisicos || "-";
        document.getElementById("solicitacoes").innerText = ultima.solicitacoes || "-";
    } else {
        document.getElementById("anamnese").innerText = "-";
        document.getElementById("exames").innerText = "-";
        document.getElementById("solicitacoes").innerText = "-";
    }
}

// Adicionar nova evolução médica
async function adicionarDocumento() {
    const nome = document.getElementById("nomePaciente").innerText;
    const codigo = document.getElementById("codigoPaciente").innerText.replace("Código: ", "");

    if (!nome || nome === "Nome do Paciente") {
        alert("Busque um paciente antes de adicionar documento!");
        return;
    }

    const anamnese = prompt("Digite a Anamnese:");
    if (anamnese === null) return;

    const exames = prompt("Digite os Exames Físicos:");
    if (exames === null) return;

    const solicitacoes = prompt("Digite as Solicitações:");
    if (solicitacoes === null) return;

    const respostaPacientes = await fetch("listar_pacientes.php");
    const pacientes = await respostaPacientes.json();
    const paciente = pacientes.find(p => p.codigo === codigo);

    if (!paciente) {
        alert("Paciente não encontrado no banco.");
        return;
    }

    const dados = new FormData();
    dados.append("paciente_id", paciente.id);
    dados.append("anamnese", anamnese);
    dados.append("exames_fisicos", exames);
    dados.append("solicitacoes", solicitacoes);

    const resposta = await fetch("salvar_evolucao.php", {
        method: "POST",
        body: dados
    });

    const resultado = await resposta.json();
    alert(resultado.sucesso || resultado.erro);

    carregarHistorico(paciente.id);
}
