<h2>Crear Nueva Reserva</h2>

<form method="post" action="?controller=Reserva&action=guardar">
  <label for="tipo_reserva">Tipo de reserva:</label>
  <select name="tipo_reserva" id="tipo_reserva" required>
    <option value="1">Aeropuerto → Hotel</option>
    <option value="2">Hotel → Aeropuerto</option>
    <option value="3">Ida y Vuelta</option>
  </select><br><br>

  <!-- Trayecto Aeropuerto -> Hotel -->
  <div id="aeropuerto_hotel" class="trayecto">
    <label>Día de llegada:</label>
    <input type="date" name="fecha_entrada"><br>

    <label>Hora de llegada:</label>
    <input type="time" name="hora_entrada"><br>

    <label>Número de vuelo:</label>
    <input type="text" name="numero_vuelo_entrada"><br>

    <label>Aeropuerto de origen:</label>
    <input type="text" name="origen_vuelo_entrada"><br>
  </div>

  <!-- Trayecto Hotel -> Aeropuerto -->
  <div id="hotel_aeropuerto" class="trayecto">
    <label>Día del vuelo:</label>
    <input type="date" name="fecha_vuelo_salida"><br>

    <label>Hora del vuelo:</label>
    <input type="time" name="hora_vuelo_salida"><br>

    <label>Hora de recogida:</label>
    <input type="time" name="hora_recogida"><br>
  </div>

  <label>Hotel:</label>
  <input type="text" name="hotel" required><br>

  <label>Número de viajeros:</label>
  <input type="number" name="num_viajeros" min="1" required><br>

  <label>Email del cliente:</label>
  <input type="email" name="email_cliente" required><br>

  <button type="submit">Guardar reserva</button>
</form>

<script>
document.getElementById('tipo_reserva').addEventListener('change', function() {
  const tipo = this.value;
  document.getElementById('aeropuerto_hotel').style.display = (tipo == 1 || tipo == 3) ? 'block' : 'none';
  document.getElementById('hotel_aeropuerto').style.display = (tipo == 2 || tipo == 3) ? 'block' : 'none';
});
</script>

<style>
.trayecto { display: none; margin-top: 10px; padding: 10px; background: #eef; }
</style>
