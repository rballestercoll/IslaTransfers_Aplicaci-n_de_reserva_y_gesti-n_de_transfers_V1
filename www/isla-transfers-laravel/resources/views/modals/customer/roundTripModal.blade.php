@php
use Illuminate\Support\Str;
$uuid = Str::random(7);
@endphp

<div class="modal fade" id="roundTripModal" tabindex="-1" aria-labelledby="roundTripModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nueva reserva (Ida-Vuelta / Aeropuerto → Hotel)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking.roundTrip') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <h6 class="mb-3">Datos de entrada</h6>
                        <div class="col-md-6">
                            <label for="rtuuid" class="form-label">Localizador</label>
                            <input type="text" id="rtuuid" name="rtuuid" class="form-control" value="{{ $uuid }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="rtemail_cliente" class="form-label">Email</label>
                            <input type="text" id="rtemail_cliente" name="rtemail_cliente" class="form-control" value="{{ session('email') }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rtfecha_entrada" class="form-label">Día de llegada</label>
                            <input type="date" name="rtfecha_entrada" id="rtfecha_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthora_entrada" class="form-label">Hora de llegada</label>
                            <input type="time" name="rthora_entrada" id="rthora_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rtnumero_vuelo_entrada" class="form-label">Número de vuelo</label>
                            <input type="text" name="rtnumero_vuelo_entrada" id="rtnumero_vuelo_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rtorigen_vuelo_entrada" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="rtorigen_vuelo_entrada" id="rtorigen_vuelo_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rtid_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="rtid_hotel" id="rtid_hotel" required>
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
                            <label for="rtfecha_vuelo_salida" class="form-label">Día de salida</label>
                            <input type="date" name="rtfecha_vuelo_salida" id="rtfecha_vuelo_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthora_vuelo_salida" class="form-label">Hora de salida</label>
                            <input type="time" name="rthora_vuelo_salida" id="rthora_vuelo_salida" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthora_recogida_salida" class="form-label">Hora de recogida</label>
                            <input type="time" name="rthora_recogida_salida" id="rthora_recogida_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rttid_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="rttid_hotel" id="rttid_hotel" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rtid_vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" name="rtid_vehiculo" id="rtid_vehiculo" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="rtnum_viajeros" class="form-label">Número de pasajeros</label>
                            <input type="number" name="rtnum_viajeros" id="rtnum_viajeros" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-download"></i> Registrar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>