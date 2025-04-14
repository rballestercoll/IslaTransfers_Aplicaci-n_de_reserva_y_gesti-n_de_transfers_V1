<?php
// views/admin/dashboard.php
require_once __DIR__ . '/../templates/header.php';
?>

<h2>Panel de Administración</h2>

<p>Bienvenido, administrador. Aquí puedes gestionar las reservas.</p>

<ul>
  <li><a href="?controller=Reserva&action=crear">Crear nueva reserva</a></li>
  <li><a href="?controller=Reserva&action=listarTodas">Ver todas las reservas</a></li>
</ul>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>
