<div class="modal fade" id="editOneWayModal" tabindex="-1" aria-labelledby="editOneWayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('hotel.update.oneway') }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-id-oneway">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Reserva Aeropuerto - Hotel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label>Email cliente</label>
            <input type="email" class="form-control" name="email_cliente" id="edit-email-oneway" required readonly>
          </div>
          <div class="col-md-6">
            <label>Número de vuelo</label>
            <input type="text" class="form-control" name="numero_vuelo_entrada" id="edit-vuelo-oneway" required>
          </div>
          <div class="col-md-6">
            <label>Fecha llegada</label>
            <input type="date" class="form-control" name="fecha_entrada" id="edit-fecha-oneway" required>
          </div>
          <div class="col-md-6">
            <label>Hora llegada</label>
            <input type="time" class="form-control" name="hora_entrada" id="edit-hora-oneway" required>
          </div>
          <div class="col-md-6">
            <label>Origen vuelo llegada</label>
            <input type="text" class="form-control" name="origen_vuelo_entrada" id="edit-origen-oneway" required>
          </div>
          <div class="col-md-6">
            <label>Pasajeros</label>
            <input type="number" class="form-control" name="num_viajeros" id="edit-pasajeros-oneway" required min="1">
          </div>
          <div class="col-md-6">
            <label>Vehículo</label>
            <select class="form-control" name="id_vehiculo" id="edit-vehiculo-oneway">
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
