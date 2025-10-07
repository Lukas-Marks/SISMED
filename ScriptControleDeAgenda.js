const monthYear = document.getElementById("monthYear");
const daysContainer = document.getElementById("days");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");

let currentDate = new Date();

const months = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();

  monthYear.textContent = `${months[month]} ${year}`;

  // Primeiro dia do mês
  const firstDay = new Date(year, month, 1).getDay();
  // Último dia do mês
  const lastDate = new Date(year, month + 1, 0).getDate();

  daysContainer.innerHTML = "";

  // Preenche dias vazios antes do primeiro dia
  for (let i = 0; i < firstDay; i++) {
    const empty = document.createElement("div");
    daysContainer.appendChild(empty);
  }

  // Preenche dias do mês
  for (let d = 1; d <= lastDate; d++) {
    const day = document.createElement("div");
    day.classList.add("day");
    day.innerHTML = `<span class="date">${d}</span>`;

    // Aqui depois você insere os agendamentos do banco de dados
    // Exemplo de placeholder:
    /*
    if (d === 10) {
      day.innerHTML += `
        <div class="event">
          <p class="paciente">Paciente X</p>
          <p class="medico">Dr. Y</p>
          <p class="especialidade">Cardiologia</p>
          <p class="hora">09:30</p>
          <button class="confirm">Confirmar</button>
          <button class="cancel">Cancelar</button>
        </div>
      `;
    }
    */

    daysContainer.appendChild(day);
  }
}

prevBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

// Inicializa com mês/ano atuais
renderCalendar(currentDate);