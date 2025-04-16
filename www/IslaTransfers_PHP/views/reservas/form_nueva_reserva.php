<h2>Crear Nueva Reserva</h2>

<form method="post" action="?controller=Admin&action=guardar">
  <label>Email del cliente:</label>
  <input type="email" name="email_cliente" required><br><br>

  <label for="tipo_reserva">Tipo de trayecto:</label>
  <select name="id_tipo_reserva" id="tipo_reserva" required>
    <option value="1">Aeropuerto → Hotel</option>
    <option value="2">Hotel → Aeropuerto</option>
    <option value="3">Ida y Vuelta</option>
  </select><br><br>

  <!-- Trayecto Aeropuerto -> Hotel -->
  <div id="aeropuerto_hotel" class="trayecto">
    <h4>Aeropuerto → Hotel</h4>
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
    <h4>Hotel → Aeropuerto</h4>
    <label>Fecha del vuelo:</label>
    <input type="date" name="fecha_vuelo_salida"><br>

    <label>Hora del vuelo:</label>
    <input type="time" name="hora_vuelo_salida"><br>

    <label>Número de vuelo:</label>
    <input type="text" name="numero_vuelo_salida"><br>

    <label>Hora de recogida:</label>
    <input type="time" name="hora_recogida"><br>
  </div>

  <label>Hotel de Recogida :</label>
  <select name="id_hotel">
  <option value="HOTEL_BAHIA">Hotel Bahía</option>
  <option value="HOTEL_SOL">Hotel Sol</option>
  <option value="HOTEL_MAR">Hotel Mar</option>
  <option value="HOTEL_MONTAÑA">Hotel Montaña</option>
  <option value="HOTEL_CIUDAD">Hotel Ciudad</option>
</select><br><br>

  <label>Hotel de Destino:</label>
  <select name="id_destino">
  <option value="HOTEL_BAHIA">Hotel Bahía</option>
  <option value="HOTEL_SOL">Hotel Sol</option>
  <option value="HOTEL_MAR">Hotel Mar</option>
  <option value="HOTEL_MONTAÑA">Hotel Montaña</option>
  <option value="HOTEL_CIUDAD">Hotel Ciudad</option>
</select><br><br>

  <label>Vehículo:</label>
  <select name="id_vehiculo">
  <option value="VEH_VAN1">Van de 8 plazas</option>
  <option value="VEH_MINI2">HMinibus</option>
  <option value="VEH_SEDAN3">Sedán Confort</option>
  <option value="VEH_LUX4">Luxury Car</option>
  <option value="VEH_BUS5">Autobús 25 pax</option>
</select><br><br>

  <label>Número de viajeros:</label>
  <input type="number" name="num_viajeros" min="1" required><br><br>

  <button type="submit">Guardar reserva</button>
</form>

<script>
document.getElementById('tipo_reserva').addEventListener('change', function() {
  const tipo = this.value;
  document.getElementById('aeropuerto_hotel').style.display = (tipo == 1 || tipo == 3) ? 'block' : 'none';
  document.getElementById('hotel_aeropuerto').style.display = (tipo == 2 || tipo == 3) ? 'block' : 'none';
});
window.addEventListener('DOMContentLoaded', function () {
  document.getElementById('tipo_reserva').dispatchEvent(new Event('change'));
});
</script>

<style>
.trayecto {
  display: none;
  background: #eef;
  padding: 10px;
  margin: 10px 0;
}
</style>
