<?php
// views/admin/lista_reservas_admin.php
require_once __DIR__ . '/../templates/header.php';
?>

<main class="page-content">
  <h2>Listado de Reservas (Administración)</h2>

  <?php if (empty($reservas)): ?>
    <p>No hay reservas registradas.</p>
  <?php else: ?>
    <table class="tabla-reservas">
      <thead>
        <tr>
          <th>ID</th>
          <th>Localizador</th>
          <th>Email Cliente</th>
          <th>Fecha Reserva</th>
          <th>Fecha Entrada</th>
          <th>Fecha Salida</th>
          <th>Nº Viajeros</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservas as $reserva): ?>
          <tr>
            <td><?= $reserva['id_reserva'] ?></td>
            <td><?= htmlspecialchars($reserva['localizador']) ?></td>
            <td><?= htmlspecialchars($reserva['email_cliente']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_entrada']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_vuelo_salida']) ?></td>
            <td><?= htmlspecialchars($reserva['num_viajeros']) ?></td>
            <td>
              <a href="?controller=Admin&action=editar&id=<?= $reserva['id_reserva'] ?>">Editar</a> |
              <a href="?controller=Admin&action=eliminar&id=<?= $reserva['id_reserva'] ?>"
                 onclick="return confirm('¿Estás seguro de eliminar esta reserva?');">
                 Eliminar
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>
