<?php
// views/reservas/form_editar_reserva_particular.php

require_once __DIR__ . '/../templates/header.php';
?>

<main class="page-content">
  <h2>Editar Reserva #<?= htmlspecialchars($reserva['id_reserva']) ?></h2>

  <form method="POST" action="?controller=Reserva&action=actualizarParticular">
    <!-- ID de la reserva, hidden para identificar -->
    <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">

    <!-- ID Hotel -->
    <label for="id_hotel">Hotel:</label>
    <select name="id_hotel" required>
      <option value="">--Selecciona un hotel--</option>
      <option value="HOTEL_BAHIA1"  <?= $reserva['id_hotel']   === 'HOTEL_BAHIA1' ? 'selected' : '' ?>>Hotel Bahía</option>
      <option value="HOTEL_SOL2"    <?= $reserva['id_hotel']   === 'HOTEL_SOL2'   ? 'selected' : '' ?>>Hotel Sol</option>
      <option value="HOTEL_MAR3"    <?= $reserva['id_hotel']   === 'HOTEL_MAR3'   ? 'selected' : '' ?>>Hotel Mar</option>
      <option value="HOTEL_MONT4"   <?= $reserva['id_hotel']   === 'HOTEL_MONT4'  ? 'selected' : '' ?>>Hotel Montaña</option>
      <option value="HOTEL_CIUD5"   <?= $reserva['id_hotel']   === 'HOTEL_CIUD5'  ? 'selected' : '' ?>>Hotel Ciudad</option>
    </select>
    <br><br>

    <!-- Tipo reserva -->
    <label for="id_tipo_reserva">Tipo de Trayecto:</label>
    <select name="id_tipo_reserva" id="tipo_reserva" required>
      <option value="1" <?= $reserva['id_tipo_reserva'] == 1 ? 'selected' : '' ?>>Aeropuerto → Hotel</option>
      <option value="2" <?= $reserva['id_tipo_reserva'] == 2 ? 'selected' : '' ?>>Hotel → Aeropuerto</option>
      <option value="3" <?= $reserva['id_tipo_reserva'] == 3 ? 'selected' : '' ?>>Ida y Vuelta</option>
    </select>
    <br><br>

    <!-- Id destino (varchar) -->
    <label for="id_destino">Hotel Destino:</label>
    <select name="id_destino" id="id_destino" required>
      <option value="">--Selecciona un hotel destino--</option>
      <option value="HOTEL_BAHIA1"  <?= $reserva['id_destino'] === 'HOTEL_BAHIA1' ? 'selected' : '' ?>>Hotel Bahía</option>
      <option value="HOTEL_SOL2"    <?= $reserva['id_destino'] === 'HOTEL_SOL2'   ? 'selected' : '' ?>>Hotel Sol</option>
      <option value="HOTEL_MAR3"    <?= $reserva['id_destino'] === 'HOTEL_MAR3'   ? 'selected' : '' ?>>Hotel Mar</option>
      <option value="HOTEL_MONT4"   <?= $reserva['id_destino'] === 'HOTEL_MONT4'  ? 'selected' : '' ?>>Hotel Montaña</option>
      <option value="HOTEL_CIUD5"   <?= $reserva['id_destino'] === 'HOTEL_CIUD5'  ? 'selected' : '' ?>>Hotel Ciudad</option>
    </select>
    <br><br>

    <!-- AEROPUERTO -> HOTEL -->
    <div id="trayecto-ida" style="background: #eef; padding: 1rem; margin-bottom: 1rem;">
      <h4>Aeropuerto → Hotel</h4>
      <label>Fecha Entrada:</label>
      <input type="date" name="fecha_entrada" 
        value="<?= htmlspecialchars($reserva['fecha_entrada']) ?>"><br><br>

      <label>Hora Entrada:</label>
      <input type="time" name="hora_entrada" 
        value="<?= htmlspecialchars($reserva['hora_entrada']) ?>"><br><br>

      <label>Número de vuelo (entrada):</label>
      <input type="text" name="numero_vuelo_entrada"
        value="<?= htmlspecialchars($reserva['numero_vuelo_entrada']) ?>"><br><br>

      <label>Origen vuelo (entrada):</label>
      <input type="text" name="origen_vuelo_entrada"
        value="<?= htmlspecialchars($reserva['origen_vuelo_entrada']) ?>"><br><br>
    </div>

    <!-- HOTEL -> AEROPUERTO -->
    <div id="trayecto-vuelta" style="background: #efe; padding: 1rem; margin-bottom: 1rem;">
      <h4>Hotel → Aeropuerto</h4>
      <label>Fecha vuelo salida:</label>
      <input type="date" name="fecha_vuelo_salida"
        value="<?= htmlspecialchars($reserva['fecha_vuelo_salida']) ?>"><br><br>

      <label>Hora vuelo salida:</label>
      <input type="time" name="hora_vuelo_salida"
        value="<?= htmlspecialchars($reserva['hora_vuelo_salida']) ?>"><br><br>

      <label>Número vuelo salida:</label>
      <input type="text" name="numero_vuelo_salida"
        value="<?= htmlspecialchars($reserva['numero_vuelo_salida']) ?>"><br><br>

      <label>Hora de recogida:</label>
      <input type="time" name="hora_recogida"
        value="<?= htmlspecialchars($reserva['hora_recogida']) ?>"><br><br>
    </div>

    <!-- Vehículo (varchar) -->
    <label for="id_vehiculo">Vehículo:</label>
    <select name="id_vehiculo" required>
      <option value="">--Selecciona--</option>
      <option value="VEH_VAN1"   <?= $reserva['id_vehiculo'] === 'VEH_VAN1' ? 'selected' : '' ?>>Van 8 plazas</option>
      <option value="VEH_MINI2"  <?= $reserva['id_vehiculo'] === 'VEH_MINI2' ? 'selected' : '' ?>>Minibus</option>
      <option value="VEH_SEDAN3" <?= $reserva['id_vehiculo'] === 'VEH_SEDAN3'? 'selected' : '' ?>>Sedán Confort</option>
      <option value="VEH_LUX4"   <?= $reserva['id_vehiculo'] === 'VEH_LUX4'  ? 'selected' : '' ?>>Luxury Car</option>
      <option value="VEH_BUS5"   <?= $reserva['id_vehiculo'] === 'VEH_BUS5'  ? 'selected' : '' ?>>Autobús 25 pax</option>
    </select>
    <br><br>

    <!-- Email Cliente -->
    <label for="email_cliente">Email del Cliente:</label>
    <input type="email" name="email_cliente" 
      value="<?= htmlspecialchars($reserva['email_cliente']) ?>" required><br><br>

    <!-- Número de Viajeros -->
    <label for="num_viajeros">Número de Viajeros:</label>
    <input type="number" name="num_viajeros" min="1"
      value="<?= htmlspecialchars($reserva['num_viajeros']) ?>" required><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>
</main>

<script>
  // Mismo toggle de tipo de reserva
  const selTipo = document.getElementById('tipo_reserva');
  const idaDiv  = document.getElementById('trayecto-ida');
  const vueltaDiv = document.getElementById('trayecto-vuelta');

  function toggleTrayectos() {
    const val = selTipo.value;
    idaDiv.style.display    = (val === '1' || val === '3') ? 'block' : 'none';
    vueltaDiv.style.display = (val === '2' || val === '3') ? 'block' : 'none';
  }

  selTipo.addEventListener('change', toggleTrayectos);
  // Al cargar la página, ejecutamos
  toggleTrayectos();
</script>

<?php
require_once __DIR__ . '/../templates/footer.php';
