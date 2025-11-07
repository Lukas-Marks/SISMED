const inputNome = document.getElementById('nome_completo');
const listaPacientes = document.getElementById('lista-pacientes');
let currentFocus = -1;

inputNome.addEventListener('input', function() {
  const termo = this.value;
  if (termo.length < 2) { 
    listaPacientes.innerHTML = '';
    listaPacientes.style.display = 'none';
    return;
  }

  fetch('buscar_paciente.php?termo=' + encodeURIComponent(termo))
    .then(res => res.json())
    .then(data => {
      listaPacientes.innerHTML = '';
      currentFocus = -1;

      if (data.length === 0) {
        listaPacientes.style.display = 'none';
        return;
      }

      listaPacientes.style.display = 'block';

      data.forEach(paciente => {
        const div = document.createElement('div');
        div.textContent = paciente.nome;
        div.dataset.cpf = paciente.cpf;
        div.dataset.nascimento = paciente.data_nascimento;
        div.dataset.telefone = paciente.telefone;

        div.addEventListener('click', function() {
          preencherCampos(this);
        });

        listaPacientes.appendChild(div);
      });
    })
    .catch(err => console.error('Erro:', err));
});

inputNome.addEventListener('keydown', function(e) {
  const items = listaPacientes.getElementsByTagName('div');
  if (!items) return;

  if (e.key === "ArrowDown") {
    currentFocus++;
    addActive(items);
  } else if (e.key === "ArrowUp") {
    currentFocus--;
    addActive(items);
  } else if (e.key === "Enter") {
    e.preventDefault();
    if (currentFocus > -1) {
      if (items[currentFocus]) preencherCampos(items[currentFocus]);
    }
  }
});

function addActive(items) {
  if (!items) return;
  removeActive(items);
  if (currentFocus >= items.length) currentFocus = 0;
  if (currentFocus < 0) currentFocus = items.length - 1;
  items[currentFocus].classList.add('autocomplete-active');
}

function removeActive(items) {
  for (let i = 0; i < items.length; i++) {
    items[i].classList.remove('autocomplete-active');
  }
}

function preencherCampos(item) {
  inputNome.value = item.textContent;
  document.getElementById('cpf').value = item.dataset.cpf;
  document.getElementById('data_nascimento').value = item.dataset.nascimento;
  document.getElementById('telefone').value = item.dataset.telefone;
  listaPacientes.innerHTML = '';
  listaPacientes.style.display = 'none';
}

// Carregar médicos por especialidade
function carregarMedicosPorEspecialidade() {
  const especialidade = document.getElementById('especialidade').value;
  const medicoSelect = document.getElementById('medico');

  if (!especialidade) {
    medicoSelect.innerHTML = '<option value="">-- Selecione a especialidade primeiro --</option>';
    return;
  }

  fetch('buscar_medicos.php?especialidade=' + encodeURIComponent(especialidade))
    .then(response => response.json())
    .then(data => {
      medicoSelect.innerHTML = '';
      if (data.length > 0) {
        medicoSelect.innerHTML = '<option value="">-- Selecione o médico --</option>';
        data.forEach(medico => {
          const option = document.createElement('option');
          option.value = medico.id;
          option.textContent = medico.nome;
          medicoSelect.appendChild(option);
        });
      } else {
        medicoSelect.innerHTML = '<option value="">Nenhum médico disponível</option>';
      }
    })
    .catch(error => {
      console.error('Erro ao buscar médicos:', error);
      medicoSelect.innerHTML = '<option value="">Erro ao carregar médicos</option>';
    });
}
