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
<div class="modal fade" id="oneWayAdminModal" tabindex="-1" aria-labelledby="customerModalLabel" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Nueva reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.reserva.oneway') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="uuid" class="form-label">Localizador</label>
                            <input type="text" value="{{ $newUUID }}" name="uuid" id="uuid" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="customerEmailSelect" class="form-label">Email del cliente</label>
                            <select class="form-select" name="customerEmailSelect" id="customerEmailSelect" required>
                                <option value="" disabled @selected(old('hotelSelect') === null)>Seleccionar...</option>
                                @foreach($emails as $email)
                                    <option value="{{ $email }}">{{ $email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bookingDate" class="form-label">Día de llegada</label>
                            <input type="date" name="bookingDate" id="bookingDate" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bookingTime" class="form-label">Hora de llegada</label>
                            <input type="time" name="bookingTime" id="bookingTime" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="flyNumber" class="form-label">Número de vuelo</label>
                            <input type="text" name="flyNumber" id="flyNumber" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="originAirport" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="originAirport" id="originAirport" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelSelect" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="hotelSelect" id="hotelSelect" required>
                                <option value="" disabled @selected(old('hotelSelect') === null)>Seleccionar...</option>
                                @foreach($hoteles as $hotel)
                                    <option value="{{ $hotel->id_hotel }}">{{ $hotel->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="carSelect" class="form-label">Vehículo</label>
                            <select class="form-select" name="carSelect" id="carSelect" required>
                                <option value="" disabled @selected(old('hotelSelect') === null)>Seleccionar...</option>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
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
