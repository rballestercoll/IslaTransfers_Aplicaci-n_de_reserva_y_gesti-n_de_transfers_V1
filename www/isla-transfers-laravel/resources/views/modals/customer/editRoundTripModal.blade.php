<div class="modal fade" id="editRoundTripModal" tabindex="-1" aria-labelledby="editRoundTripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nueva reserva (Ida-Vuelta / Aeropuerto → Hotel)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking.updateRoundTrip') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_reserva" id="editRoundTrip_id">
                    <div class="row mb-3">
                        <h6 class="mb-3">Datos de entrada</h6>
                        <div class="col-md-6">
                            <label for="editRoundTrip_uuid" class="form-label">Localizador</label>
                            <input type="text" id="editRoundTrip_uuid" name="editRoundTrip_uuid" class="form-control" value="uuid" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_email_cliente" class="form-label">Email</label>
                            <input type="text" id="editRoundTrip_email_cliente" name="editRoundTrip_email_cliente" class="form-control" value="{{ session('email') }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editRoundTrip_fecha_entrada" class="form-label">Día de llegada</label>
                            <input type="date" name="editRoundTrip_fecha_entrada" id="editRoundTrip_fecha_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_hora_entrada" class="form-label">Hora de llegada</label>
                            <input type="time" name="editRoundTrip_hora_entrada" id="editRoundTrip_hora_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editRoundTrip_numero_vuelo_entrada" class="form-label">Número de vuelo</label>
                            <input type="text" name="editRoundTrip_numero_vuelo_entrada" id="editRoundTrip_numero_vuelo_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_origen_vuelo_entrada" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="editRoundTrip_origen_vuelo_entrada" id="editRoundTrip_origen_vuelo_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editRoundTrip_id_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="editRoundTrip_id_hotel" id="editRoundTrip_id_hotel" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h6 class="mt-2 mb-3">Datos de salida</h6>
                        <div class="col-md-6">
                            <label for="editRoundTrip_fecha_vuelo_salida" class="form-label">Día de salida</label>
                            <input type="date" name="editRoundTrip_fecha_vuelo_salida" id="editRoundTrip_fecha_vuelo_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_hora_vuelo_salida" class="form-label">Hora de salida</label>
                            <input type="time" name="editRoundTrip_hora_vuelo_salida" id="editRoundTrip_hora_vuelo_salida" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editRoundTrip_hora_recogida_salida" class="form-label">Hora de recogida</label>
                            <input type="time" name="editRoundTrip_hora_recogida_salida" id="editRoundTrip_hora_recogida_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_tid_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="editRoundTrip_tid_hotel" id="editRoundTrip_tid_hotel" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editRoundTrip_id_vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" name="editRoundTrip_id_vehiculo" id="editRoundTrip_id_vehiculo" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editRoundTrip_num_viajeros" class="form-label">Número de pasajeros</label>
                            <input type="number" name="editRoundTrip_num_viajeros" id="editRoundTrip_num_viajeros" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Modificar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>