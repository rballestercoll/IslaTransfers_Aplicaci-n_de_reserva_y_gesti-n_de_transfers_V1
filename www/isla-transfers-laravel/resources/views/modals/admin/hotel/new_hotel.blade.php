<!-- Modal de nuevo hotel -->
<div class="modal fade" id="newHotelModal" tabindex="-1" aria-labelledby="newHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newHotelModalLabel">Registrar hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.hotel.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelName" class="form-label">Nombre hotel</label>
                            <input type="text" id="hotelName" name="hotelName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="zoneSelect" class="form-label">Zona hotel</label>
                            <select class="form-select" name="zoneSelect" id="zoneSelect" required>
                                <option value="">Seleccionar...</option>
                                @foreach(\App\Models\TransferZona::all() as $zona)
                                    <option value="{{ $zona->id_zona }}">{{ $zona->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelCommission" class="form-label">Comisión (%)</label>
                            <input type="number" name="hotelCommission" id="hotelCommission" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hotelEmail" class="form-label">Email</label>
                            <input type="email" name="hotelEmail" id="hotelEmail" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelPassword" class="form-label">Contraseña</label>
                            <input type="password" name="hotelPassword" id="hotelPassword" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Añadir hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>