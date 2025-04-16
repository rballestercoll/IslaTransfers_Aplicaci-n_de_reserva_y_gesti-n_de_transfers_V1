
<?php require_once __DIR__ . '/../templates/header.php'; ?>
<main class="page-content">
  <div class="admin-dashboard">
    <h2>Panel de Administración</h2>
    <p>Bienvenido, administrador. Aquí puedes gestionar las reservas.</p>
    <div class="admin-options">
      <a class="btn-primary" href="?controller=Reserva&action=crear">Crear nueva reserva</a>
      <a class="btn-primary" href="?controller=Admin&action=listarTodas">Ver todas las reservas</a>
      <a class="btn-primary" href="?controller=Admin&action=verCalendario">Ver Calendario</a>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
