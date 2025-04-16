<?php
// views/admin/form_editar_reserva.php
require_once __DIR__ . '/../templates/header.php';
?>

<main class="page-content">
  <h2>Editar Reserva #<?= $reserva['id_reserva'] ?></h2>

  <form action="?controller=Admin&action=actualizar" method="post">
    <!-- Campo hidden con el ID de la reserva -->
    <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

    <label>Email del cliente:</label>
    <input type="email" name="email_cliente" value="<?= htmlspecialchars($reserva['email_cliente']) ?>" required><br><br>

    <label>Tipo de trayecto (id_tipo_reserva):</label>
    <select name="id_tipo_reserva" required>
      <option value="1" <?= $reserva['id_tipo_reserva'] == 1 ? 'selected' : '' ?>>Aeropuerto → Hotel</option>
      <option value="2" <?= $reserva['id_tipo_reserva'] == 2 ? 'selected' : '' ?>>Hotel → Aeropuerto</option>
      <option value="3" <?= $reserva['id_tipo_reserva'] == 3 ? 'selected' : '' ?>>Ida y Vuelta</option>
    </select><br><br>

    <!-- Rellenar los mismos campos que en crearReserva -->
    <label>ID Hotel:</label>
    <input type="number" name="id_hotel" value="<?= $reserva['id_hotel'] ?? '' ?>" required><br><br>

    <label>ID Destino:</label>
    <input type="number" name="id_destino" value="<?= $reserva['id_destino'] ?? '' ?>" required><br><br>

    <label>Fecha Entrada:</label>
    <input type="date" name="fecha_entrada" value="<?= $reserva['fecha_entrada'] ?? '' ?>"><br><br>

    <label>Hora Entrada:</label>
    <input type="time" name="hora_entrada" value="<?= $reserva['hora_entrada'] ?? '' ?>"><br><br>

    <label>Número vuelo entrada:</label>
    <input type="text" name="numero_vuelo_entrada" value="<?= $reserva['numero_vuelo_entrada'] ?? '' ?>"><br><br>

    <label>Origen vuelo entrada:</label>
    <input type="text" name="origen_vuelo_entrada" value="<?= $reserva['origen_vuelo_entrada'] ?? '' ?>"><br><br>

    <label>Fecha Vuelo Salida:</label>
    <input type="date" name="fecha_vuelo_salida" value="<?= $reserva['fecha_vuelo_salida'] ?? '' ?>"><br><br>

    <label>Hora Vuelo Salida:</label>
    <input type="time" name="hora_vuelo_salida" value="<?= $reserva['hora_vuelo_salida'] ?? '' ?>"><br><br>

    <label>Número vuelo salida:</label>
    <input type="text" name="numero_vuelo_salida" value="<?= $reserva['numero_vuelo_salida'] ?? '' ?>"><br><br>

    <label>Hora recogida:</label>
    <input type="time" name="hora_recogida" value="<?= $reserva['hora_recogida'] ?? '' ?>"><br><br>

    <label>Número de viajeros:</label>
    <input type="number" name="num_viajeros" value="<?= $reserva['num_viajeros'] ?>" required><br><br>

    <label>ID vehículo:</label>
    <input type="number" name="id_vehiculo" value="<?= $reserva['id_vehiculo'] ?>" required><br><br>

    <button type="submit">Guardar cambios</button>
  </form>
</main>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>
