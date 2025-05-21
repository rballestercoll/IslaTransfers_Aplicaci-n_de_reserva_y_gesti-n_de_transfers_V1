<?php
// views/admin/calendario.php
require_once __DIR__ . '/../templates/header.php';
?>

<main class="page-content">
  <h2>Calendario de Reservas</h2>
  <div id="calendar"></div>
</main>

<!-- Incluir las librerías de FullCalendar via CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',

    // Llamamos a un endpoint de tu app que devuelva JSON con las reservas
    events: {
      url: '?controller=Admin&action=calendarEvents', // Ejemplo
      method: 'GET',
      failure: function() {
        alert('Error al cargar eventos!');
      }
    },
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      meridiem: false
    },
  });
  calendar.render();
});
</script>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>
