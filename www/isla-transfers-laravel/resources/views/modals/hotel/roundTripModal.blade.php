@php
use Illuminate\Support\Str;
$uuid = Str::random(7);
use App\Models\TransferVehiculo;
use App\Models\TransferViajero;
$emails = TransferViajero::pluck('email');
$vehiculos = TransferVehiculo::all();
@endphp
<!-- Modal -->
<div class="modal fade" id="hotelRoundTripModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Nueva reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hotel.reserva.roundtrip') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            @php($randomUserId = random_int(100000, 999999))
                            <label for="uuid1" class="form-label">ID Reserva</label>
                            <input type="number" name="uuid1" class="form-control" readonly value="{{ $randomUserId }}">
                        </div>
                        <div class="col-md-6">
                            <label for="rthotelUUID" class="form-label">Localizador</label>
                            <input type="text" value="{{ $uuid }}" name="rthotelUUID" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="rthotelCustomerEmail" class="form-label">Email del cliente</label>
                            <select class="form-select" name="rthotelCustomerEmail" id="rthotelCustomerEmail">
                                <option selected>Seleccionar...</option>
                                @foreach($emails as $email)
                                <option value="{{ $email }}">{{ $email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthotel_fecha_entrada" class="form-label">Día de llegada</label>
                            <input type="date" name="rthotel_fecha_entrada" id="rthotel_fecha_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthotel_hora_entrada" class="form-label">Hora de llegada</label>
                            <input type="time" name="rthotel_hora_entrada" id="rthotel_hora_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthotel_numero_vuelo_entrada" class="form-label">Número de vuelo</label>
                            <input type="text" name="rthotel_numero_vuelo_entrada" id="rthotel_numero_vuelo_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthotel_origen_vuelo_entrada" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="rthotel_origen_vuelo_entrada" id="rthotel_origen_vuelo_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthotel_fecha_vuelo_salida" class="form-label">Día de salida</label>
                            <input type="date" name="rthotel_fecha_vuelo_salida" id="rthotel_fecha_vuelo_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthotel_hora_vuelo_salida" class="form-label">Hora de salida</label>
                            <input type="time" name="rthotel_hora_vuelo_salida" id="rthotel_hora_vuelo_salida" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthotel_hora_recogida_salida" class="form-label">Hora de recogida</label>
                            <input type="time" name="rthotel_hora_recogida_salida" id="rthotel_hora_recogida_salida" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rthotel_vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" name="rthotel_vehiculo" id="rthotel_vehiculo">
                                <option selected>Selecionar...</option>
                                @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rthotel_num_viajeros" class="form-label">Número de pasajeros</label>
                            <input type="number" name="rthotel_num_viajeros" id="rthotel_num_viajeros" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-download"></i> Registrar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>