<div class="modal fade" id="editRoundTripModal" tabindex="-1" aria-labelledby="editRoundTripModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('hotel.update.roundtrip') }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-id-roundtrip">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Reserva Ida-Vuelta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label>Email cliente</label>
            <input type="email" class="form-control" name="email_cliente" id="edit-email-roundtrip" required readonly>
          </div>

          {{-- IDA --}}
          <div class="col-12"><strong>Datos de llegada (IDA)</strong></div>
          <div class="col-md-6">
            <label>Número vuelo entrada</label>
            <input type="text" class="form-control" name="numero_vuelo_entrada" id="edit-vuelo-roundtrip" required>
          </div>
          <div class="col-md-6">
            <label>Fecha llegada</label>
            <input type="date" class="form-control" name="fecha_entrada" id="edit-fecha-entrada-roundtrip" required>
          </div>
          <div class="col-md-6">
            <label>Hora llegada</label>
            <input type="time" class="form-control" name="hora_entrada" id="edit-hora-entrada-roundtrip" required>
          </div>
          <div class="col-md-6">
            <label>Origen vuelo</label>
            <input type="text" class="form-control" name="origen_vuelo_entrada" id="edit-origen-roundtrip" required>
          </div>

          {{-- VUELTA --}}
          <div class="col-12"><strong>Datos de salida (VUELTA)</strong></div>
          <div class="col-md-6">
            <label>Fecha salida</label>
            <input type="date" class="form-control" name="fecha_vuelo_salida" id="edit-fecha-salida-roundtrip" required>
          </div>
          <div class="col-md-6">
            <label>Hora salida</label>
            <input type="time" class="form-control" name="hora_vuelo_salida" id="edit-hora-salida-roundtrip" required>
          </div>
          <div class="col-md-6">
            <label>Hora recogida</label>
            <input type="time" class="form-control" name="hora_recogida_salida" id="edit-hora-recogida-roundtrip" required>
          </div>

          <div class="col-md-6">
            <label>Pasajeros</label>
            <input type="number" class="form-control" name="num_viajeros" id="edit-pasajeros-roundtrip" required min="1">
          </div>
          <div class="col-md-6">
            <label>Vehículo</label>
            <select class="form-control" name="id_vehiculo" id="edit-vehiculo-roundtrip">
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
