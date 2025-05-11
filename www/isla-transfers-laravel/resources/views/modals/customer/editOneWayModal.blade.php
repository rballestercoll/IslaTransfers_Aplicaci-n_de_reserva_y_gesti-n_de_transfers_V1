<div class="modal fade" id="editOneWayModal" tabindex="-1" aria-labelledby="editOneWayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOneWayModalLabel">Editar reserva (Aeropuerto → Hotel)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('booking.updateOneWay') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_reserva" id="edit_id">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_uuid" class="form-label">Localizador</label>
                            <input type="text" class="form-control" id="edit_uuid" name="edit_uuid" value="uuid" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email_cliente" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email_cliente" name="edit_email_cliente" value="{{ session('email') }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_fecha_entrada" class="form-label">Fecha llegada</label>
                            <input type="date" class="form-control" id="edit_fecha_entrada" name="edit_fecha_entrada" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_hora_entrada" class="form-label">Hora llegada</label>
                            <input type="time" class="form-control" id="edit_hora_entrada" name="edit_hora_entrada" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_numero_vuelo_entrada" class="form-label">Número de vuelo</label>
                            <input type="text" class="form-control" id="edit_numero_vuelo_entrada" name="edit_numero_vuelo_entrada" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_origen_vuelo_entrada" class="form-label">Origen del vuelo</label>
                            <input type="text" class="form-control" id="edit_origen_vuelo_entrada" name="edit_origen_vuelo_entrada" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_id_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" id="edit_id_hotel" name="edit_id_hotel" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_id_vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" id="edit_id_vehiculo" name="edit_id_vehiculo" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_num_viajeros" class="form-label">Número de pasajeros</label>
                        <input type="number" class="form-control" id="edit_num_viajeros" name="edit_num_viajeros" required min="1">
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Modificar reserva
                </button>
            </div>
            </form>
        </div>
    </div>
</div>