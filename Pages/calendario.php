<?php 

session_start();
include 'Conectar.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Agenda de Consultas</title>
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../CSS/cadastro_pacientes.css">
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6fb;
      margin: 0;
      padding: 20px;
    }
    .container {
    display: flex;
    justify-content:right;
    align-items: flex-start;
    gap: 10px;
    margin-top: 10px;
     flex-wrap: wrap; /* adiciona quebra em telas menores */
  
    }
   

  #calendar {
  width: 100%; /* ocupa toda a largura disponível */
  max-width: 1400px; /* limite máximo para telas grandes */
  background: white;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  margin: 0 auto; /* centraliza o calendário */
}








/* Força o texto do evento a aparecer completo */
.fc .fc-daygrid-event .fc-event-title {
  white-space: nowrap;
  overflow: visible;
  text-overflow: initial;
}

/* Remove truncamento geral */
.fc .fc-daygrid-event {
  overflow: visible !important;
}



    
  .legend {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    font-size: 14px;
    max-width: 100px;
  }

  .legend h5 {
    margin-top: 0;
    color: #0d2356;
  }

  .legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .color-box {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border-radius: 4px;
  }

  .verde { background-color: #28a745; }
  .amarelo { background-color: #ffc107; }
  .vermelho { background-color: #dc3545; }
  .cinza { background-color: #6c757d; }


    h2 {
      text-align: center;
      color: #0d2356;
    }
    .btn-add {
      display: block;
      width: fit-content;
      margin: 20px auto;
      background-color: #007bff;
      color: white;
      padding: 10px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-add:hover {
      background-color: #0056b3;
    }
  </style>
  



</head>
<body>

  <h2>Consultas Agendadas</h2>
  <a href="agendar.php" class="btn-add">+ Novo Agendamento</a>
  <div class="container">
  <div id="calendar"></div>
  <div class="legend">
    <h5>Legenda</h5>
    <div class="legend-item">
      <div class="color-box verde"></div> Confirmado
    </div>
    <div class="legend-item">
      <div class="color-box amarelo"></div> Cancelado
    </div>
    <div class="legend-item">
      <div class="color-box vermelho"></div> Faltou
    </div>
    <div class="legend-item">
      <div class="color-box cinza"></div> Outros
    </div> <br>
    <a href="../Pages/pagina-principal.php">
    <button style="
      padding: 10px 15px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.3s;
    ">Voltar ao início     
    </button>
  </div>
</div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        buttonText: {
  today: 'Hoje'
},
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        events: 'eventos.php',
        eventClick: function(info) {
           info.jsEvent.preventDefault(); // evita qualquer comportamento padrão do clique
          const id = info.event.id;
          if (confirm("Deseja editar este agendamento?")) {
            window.location.href = "editar_agendamento.php?id=" + id;
          }
        }
      });
      calendar.render();
    });

    
  </script>
  
</body>
</html>