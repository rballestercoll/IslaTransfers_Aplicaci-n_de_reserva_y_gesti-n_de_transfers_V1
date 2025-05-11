@php
use Illuminate\Support\Str;
$uuid = Str::random(7);
@endphp

<div class="modal fade" id="oneWayModal" tabindex="-1" aria-labelledby="oneWayModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"">Nueva reserva (Aeropuerto → Hotel)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking.oneWay') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="uuid" class="form-label">Localizador</label>
                            <input type="text" id="uuid" name="uuid" class="form-control" value="{{ $uuid }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="email_cliente" class="form-label">Email</label>
                            <input type="text" id="email_cliente" name="email_cliente" class="form-control" value="{{ session('email') }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_entrada" class="form-label">Día de llegada</label>
                            <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hora_entrada" class="form-label">Hora de llegada</label>
                            <input type="time" name="hora_entrada" id="hora_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="numero_vuelo_entrada" class="form-label">Número de vuelo</label>
                            <input type="text" name="numero_vuelo_entrada" id="numero_vuelo_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="origen_vuelo_entrada" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="origen_vuelo_entrada" id="origen_vuelo_entrada" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_hotel" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="id_hotel" id="id_hotel" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($hoteles as $hotel)
                                <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre_hotel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" name="id_vehiculo" id="id_vehiculo" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">{{ $vehiculo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="num_viajeros" class="form-label">Número de pasajeros</label>
                            <input type="number" name="num_viajeros" id="num_viajeros" class="form-control" required min="1">
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