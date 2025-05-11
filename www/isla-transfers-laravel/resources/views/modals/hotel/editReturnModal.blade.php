<div class="modal fade" id="editReturnModal" tabindex="-1" aria-labelledby="editReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('hotel.update.return') }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-id-return">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Reserva Hotel - Aeropuerto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label>Email cliente</label>
            <input type="email" class="form-control" name="email_cliente" id="edit-email-return" required readonly>
          </div>
          <div class="col-md-6">
            <label>Fecha salida</label>
            <input type="date" class="form-control" name="fecha_vuelo_salida" id="edit-fecha-salida-return" required>
          </div>
          <div class="col-md-6">
            <label>Hora salida</label>
            <input type="time" class="form-control" name="hora_vuelo_salida" id="edit-hora-salida-return" required>
          </div>
          <div class="col-md-6">
            <label>Hora recogida</label>
            <input type="time" class="form-control" name="hora_recogida_salida" id="edit-hora-recogida-return" required>
          </div>
          <div class="col-md-6">
            <label>Pasajeros</label>
            <input type="number" class="form-control" name="num_viajeros" id="edit-pasajeros-return" required min="1">
          </div>
          <div class="col-md-6">
            <label>Vehículo</label>
            <select class="form-control" name="id_vehiculo" id="edit-vehiculo-return">
              @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </form>
  </div>
</div>
