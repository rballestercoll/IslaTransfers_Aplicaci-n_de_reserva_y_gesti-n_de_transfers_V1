<!-- Modal de edición de reserva -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Formulario de edición -->
      <form id="editReservationForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="reservaId" id="reservaId">
        <input type="hidden" name="tipoReserva" id="tipoReservaEdit">

        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar reserva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="uuidEdit" class="form-label">Localizador</label>
              <input type="text" name="uuid" id="uuidEdit" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label for="customerEmailEdit" class="form-label">Email del cliente</label>
              <input type="email" name="customerEmailSelect" id="customerEmailEdit" class="form-control" required>
            </div>
          </div>

          <!-- Entrada -->
          <div class="row mb-3">
            <div class="col-md-6 campo-entrada">
              <label for="bookingDateEdit" class="form-label">Fecha de entrada</label>
              <input type="date" name="bookingDate" id="bookingDateEdit" class="form-control">
            </div>
            <div class="col-md-6 campo-entrada">
              <label for="bookingTimeEdit" class="form-label">Hora de entrada</label>
              <input type="time" name="bookingTime" id="bookingTimeEdit" class="form-control">
            </div>
          </div>

          <div class="row mb-3 campo-entrada">
            <div class="col-md-6">
              <label for="flyNumerEdit" class="form-label">Número de vuelo</label>
              <input type="text" name="flyNumer" id="flyNumerEdit" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="originAirportEdit" class="form-label">Aeropuerto de origen</label>
              <input type="text" name="originAirport" id="originAirportEdit" class="form-control">
            </div>
          </div>

          <!-- Salida -->
          <div class="row mb-3 campo-salida">
            <div class="col-md-6">
              <label for="dateFlyEdit" class="form-label">Fecha vuelo salida</label>
              <input type="date" name="dateFly" id="dateFlyEdit" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="timeFlyEdit" class="form-label">Hora vuelo salida</label>
              <input type="time" name="timeFly" id="timeFlyEdit" class="form-control">
            </div>
          </div>

          <div class="row mb-3 campo-salida">
            <div class="col-md-6">
              <label for="pickupTimeEdit" class="form-label">Hora de recogida</label>
              <input type="time" name="pickupTime" id="pickupTimeEdit" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="passengerNumEdit" class="form-label">Número de pasajeros</label>
              <input type="number" name="passengerNum" id="passengerNumEdit" class="form-control" min="1">
            </div>
          </div>

          <!-- Siempre visibles -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="hotelSelectEdit" class="form-label">Hotel</label>
              <select name="hotelSelect" id="hotelSelectEdit" class="form-select">
                @foreach(\App\Models\TransferHotel::all() as $hotel)
                  <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="carSelectEdit" class="form-label">Vehículo</label>
              <select name="carSelect" id="carSelectEdit" class="form-select">
                @foreach(\App\Models\TransferVehiculo::all() as $vehiculo)
                  <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </form>

      <!-- Formulario de eliminación (fuera del anterior) -->
      <form id="deleteReservationForm" method="POST" class="text-end px-4 pb-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta reserva?')">
          Eliminar reserva
        </button>
      </form>

    </div>
  </div>
</div>