<?php
// views/reservas/form_nueva_reserva_particular.php

require_once __DIR__ . '/../templates/header.php';
?>
<main class="page-content">
  <h2>Nueva Reserva (Usuario Particular)</h2>

  <!-- Formulario que envía los datos a guardarParticular -->
  <form method="POST" action="?controller=Reserva&action=guardarParticular">

    <!-- ID del hotel (varchar) -->
    <!-- Podrías mostrar un select con valores fijos si no haces una consulta dinámica -->
    <label for="id_hotel">Hotel:</label>
    <select name="id_hotel" id="id_hotel" required>
      <option value="">--Selecciona un hotel--</option>
      <option value="HOTEL_BAHIA">Hotel Bahía</option>
      <option value="HOTEL_SOL">Hotel Sol</option>
      <option value="HOTEL_MAR">Hotel Mar</option>
      <option value="HOTEL_MONTAÑA">Hotel Montaña</option>
      <option value="HOTEL_CIUDAD">Hotel Ciudad</option>
    </select>
    <br><br>

    <!-- Tipo de reserva (1,2,3) en transfer_tipo_reserva -->
    <label for="id_tipo_reserva">Tipo de Trayecto:</label>
    <select name="id_tipo_reserva" id="tipo_reserva" required>
      <option value="1">Aeropuerto → Hotel</option>
      <option value="2">Hotel → Aeropuerto</option>
      <option value="3">Ida y Vuelta</option>
    </select>
    <br><br>

    <!-- ID del destino (varchar) (en la BD, 'id_destino' apunta también a un hotel) -->
    <label for="id_destino">Hotel Destino (en caso de Aerop.→Hotel, o ida y vuelta):</label>
    <select name="id_destino" id="id_destino" required>
      <option value="">--Selecciona un hotel destino--</option>
      <option value="HOTEL_BAHIA">Hotel Bahía</option>
      <option value="HOTEL_SOL">Hotel Sol</option>
      <option value="HOTEL_MAR">Hotel Mar</option>
      <option value="HOTEL_MONTAÑA">Hotel Montaña</option>
      <option value="HOTEL_CIUDAD">Hotel Ciudad</option>
    </select>
    <br><br>

    <!-- Bloque: Aeropuerto -> Hotel -->
    <div id="trayecto-ida" style="background: #eef; padding: 1rem; margin-bottom: 1rem; display: none;">
      <h4>Aeropuerto → Hotel</h4>
      <label>Fecha de Entrada:</label>
      <input type="date" name="fecha_entrada"><br><br>

      <label>Hora de Entrada:</label>
      <input type="time" name="hora_entrada"><br><br>

      <label>Número de vuelo (entrada):</label>
      <input type="text" name="numero_vuelo_entrada"><br><br>

      <label>Origen vuelo (entrada):</label>
      <input type="text" name="origen_vuelo_entrada"><br><br>
    </div>

    <!-- Bloque: Hotel -> Aeropuerto -->
    <div id="trayecto-vuelta" style="background: #efe; padding: 1rem; margin-bottom: 1rem; display: none;">
      <h4>Hotel → Aeropuerto</h4>
      <label>Fecha vuelo Salida:</label>
      <input type="date" name="fecha_vuelo_salida"><br><br>

      <label>Hora vuelo Salida:</label>
      <input type="time" name="hora_vuelo_salida"><br><br>

      <label>Número de vuelo (salida):</label>
      <input type="text" name="numero_vuelo_salida"><br><br>

      <label>Hora de recogida:</label>
      <input type="time" name="hora_recogida"><br><br>
    </div>

    <!-- ID del vehículo (varchar) -->
    <label for="id_vehiculo">Vehículo:</label>
    <select name="id_vehiculo" required>
      <option value="">--Selecciona un vehículo--</option>
      <option value="VEH_VAN1">Van 8 plazas</option>
      <option value="VEH_MINI2">Minibus</option>
      <option value="VEH_SEDAN3">Sedán Confort</option>
      <option value="VEH_LUX4">Luxury Car</option>
      <option value="VEH_BUS5">Autobús 25 pax</option>
    </select>
    <br><br>

    <!-- Email del cliente (por si se hace reserva en nombre de alguien) -->
    <label for="email_cliente">Email del Cliente:</label>
    <input type="email" name="email_cliente" required>
    <br><br>

    <!-- Nº Viajeros -->
    <label for="num_viajeros">Número de Viajeros:</label>
    <input type="number" name="num_viajeros" min="1" value="1" required>
    <br><br>

    <button type="submit" class="btn-primary">Guardar Reserva</button>
  </form>
</main>

<script>
  // Toggle visibility según tipo de reserva
  const selTipo = document.getElementById('tipo_reserva');
  const idaDiv  = document.getElementById('trayecto-ida');
  const vueltaDiv = document.getElementById('trayecto-vuelta');

  selTipo.addEventListener('change', function() {
    const val = this.value;
    // 1 = Aerop->Hotel, 2 = Hotel->Aerop, 3 = IdaYVuelta
    idaDiv.style.display    = (val == '1' || val == '3') ? 'block' : 'none';
    vueltaDiv.style.display = (val == '2' || val == '3') ? 'block' : 'none';
  });
</script>

<?php
require_once __DIR__ . '/../templates/footer.php';
