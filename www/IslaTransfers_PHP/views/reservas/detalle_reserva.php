<?php
// views/reservas/detalle_reserva.php

require_once __DIR__ . '/../templates/header.php';
?>
<main class="page-content">
  <h2>Detalle de la Reserva</h2>

  <?php if (empty($reserva)): ?>
    <p>No se encontró la reserva solicitada.</p>
  <?php else: ?>
    <ul>
      <li><strong>ID Reserva:</strong> <?= htmlspecialchars($reserva['id_reserva']) ?></li>
      <li><strong>Localizador:</strong> <?= htmlspecialchars($reserva['localizador']) ?></li>
      <li><strong>ID Hotel (creación):</strong> <?= htmlspecialchars($reserva['id_hotel']) ?></li>
      <li><strong>ID Destino:</strong> <?= htmlspecialchars($reserva['id_destino']) ?></li>
      <li><strong>Tipo de Reserva:</strong> <?= htmlspecialchars($reserva['id_tipo_reserva']) ?></li>
      <li><strong>Fecha/Hora Entrada:</strong> <?= htmlspecialchars($reserva['fecha_entrada']) . ' ' . htmlspecialchars($reserva['hora_entrada']) ?></li>
      <li><strong>Fecha/Hora Salida:</strong> <?= htmlspecialchars($reserva['fecha_vuelo_salida']) . ' ' . htmlspecialchars($reserva['hora_vuelo_salida']) ?></li>
      <li><strong>Nº Vuelo (Entrada):</strong> <?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?></li>
      <li><strong>Nº Vuelo (Salida):</strong> <?= htmlspecialchars($reserva['numero_vuelo_salida']) ?></li>
      <li><strong>Origen (Entrada):</strong> <?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?></li>
      <li><strong>Hora Recogida:</strong> <?= htmlspecialchars($reserva['hora_recogida']) ?></li>
      <li><strong>Nº Viajeros:</strong> <?= htmlspecialchars($reserva['num_viajeros']) ?></li>
      <li><strong>ID Vehículo:</strong> <?= htmlspecialchars($reserva['id_vehiculo']) ?></li>
      <li><strong>Email Cliente:</strong> <?= htmlspecialchars($reserva['email_cliente']) ?></li>
      <li><strong>Fecha Reserva:</strong> <?= htmlspecialchars($reserva['fecha_reserva']) ?></li>
      <li><strong>Última Modif.:</strong> <?= htmlspecialchars($reserva['fecha_modificacion']) ?></li>
    </ul>
  <?php endif; ?>
</main>

<?php
require_once __DIR__ . '/../templates/footer.php';
