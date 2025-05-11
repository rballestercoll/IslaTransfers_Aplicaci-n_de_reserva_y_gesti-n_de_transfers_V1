@php
use Illuminate\Support\Str;
use App\Models\TransferHotel;
use App\Models\TransferVehiculo;
use App\Models\TransferViajero;

$newUUID = Str::upper(Str::random(7));
$emails = TransferViajero::pluck('email');
$hoteles = TransferHotel::all();
$vehiculos = TransferVehiculo::all();
@endphp

<!-- Modal -->
<div class="modal fade" id="returnAdminModal" tabindex="-1" aria-labelledby="returnAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="returnAdminModalLabel">Reserva Hotel - Aeropuerto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.reserva.return') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $newUUID }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            @php($randomUserId = random_int(100000, 999999))
                            <label for="uuid1" class="form-label">ID Reserva</label>
                            <input type="number" name="uuid1" class="form-control" readonly value="{{ $randomUserId }}">
                        </div>
                        <div class="col-md-6">
                            <label for="uuid" class="form-label">Localizador</label>
                            <input type="text" value="{{ $newUUID }}" name="uuid" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="customerEmailSelect" class="form-label">Email del cliente</label>
                            <select class="form-select" name="customerEmailSelect" id="customerEmailSelect">
                                <option selected>Seleccionar...</option>
                                @foreach($emails as $email)
                                <option value="{{ $email }}">{{ $email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dateFly" class="form-label">Día del vuelo</label>
                            <input type="date" name="dateFly" id="dateFly" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="timeFly" class="form-label">Hora del vuelo</label>
                            <input type="time" name="timeFly" id="timeFly" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pickupTime" class="form-label">Hora de recogida</label>
                            <input type="time" name="pickupTime" id="pickupTime" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hotelSelect" class="form-label">Hotel de recogida</label>
                            <select class="form-select" name="hotelSelect" id="hotelSelect">
                                <option selected>Seleccionar...</option>
                                @foreach($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="carSelect" class="form-label">Vehículo</label>
                            <select class="form-select" name="carSelect" id="carSelect">
                                <option selected>Seleccionar...</option>
                                @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="passengerNum" class="form-label">Número de pasajeros</label>
                            <input type="number" name="passengerNum" id="passengerNum" class="form-control" required min="1">
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