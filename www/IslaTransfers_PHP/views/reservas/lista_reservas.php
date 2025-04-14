<h2>Mis Reservas</h2>

<?php if (empty($reservas)): ?>
  <p>No tienes reservas registradas.</p>
<?php else: ?>
  <ul>
    <?php foreach ($reservas as $reserva): ?>
      <li>Reserva #<?= $reserva['id_reserva'] ?> - Localizador: <?= $reserva['localizador'] ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
