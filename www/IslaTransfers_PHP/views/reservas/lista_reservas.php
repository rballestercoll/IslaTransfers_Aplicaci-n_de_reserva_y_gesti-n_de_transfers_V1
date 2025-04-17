<?php require_once __DIR__.'/../templates/header.php'; ?>

<main class="page-content">
  <h1>Mis reservas</h1><br>

  <?php if (empty($reservas)): ?>
    <p>Aún no tienes reservas. <a href="?controller=Reserva&action=crearParticular">Haz una ahora</a></p>
  <?php else: ?>
    <table class="tabla-reservas">
      <thead>
        <tr>
          <th>Localizador</th>
          <th>Entrada</th>
          <th>Salida</th>
          <th>Viajeros</th>
          <th>Origen</th> 
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservas as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['localizador']) ?></td>
            <td><?= $r['fecha_entrada'].' '.$r['hora_entrada'] ?></td>
            <td><?= $r['fecha_vuelo_salida'].' '.$r['hora_vuelo_salida'] ?></td>
            <td><?= $r['num_viajeros'] ?></td>
            <td>
              <?php if ($r['creado_por'] === 'admin'): ?>
                <span class="chip chip-admin">Admin</span>
              <?php else: ?>
                <span class="chip chip-user">Usuario</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="?controller=Reserva&action=detalle&id=<?= $r['id_reserva'] ?>">Ver</a>
              <?php
                $trayectoDT = new DateTime($r['fecha_entrada'].' '.$r['hora_entrada']);
                $puedeModificar = $trayectoDT > (new DateTime())->add(new DateInterval('P2D'));
                if ($puedeModificar):
              ?>
                | <a href="?controller=Reserva&action=editarParticular&id=<?= $r['id_reserva'] ?>">Editar</a>
                | <a onclick="return confirm('¿Cancelar la reserva?')" 
                     href="?controller=Reserva&action=eliminarParticular&id=<?= $r['id_reserva'] ?>">Cancelar</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      
    </table>
  <?php endif; ?>
</main>

<?php require_once __DIR__.'/../templates/footer.php'; ?>
