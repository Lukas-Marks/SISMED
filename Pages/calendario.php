<?php include 'conectar.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Agenda de Consultas</title>
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet'>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6fb;
      margin: 0;
      padding: 20px;
    }
    #calendar {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
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
  <div id="calendar"></div>

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