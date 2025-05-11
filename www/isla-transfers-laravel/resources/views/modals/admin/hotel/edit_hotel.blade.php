<!-- Modal de edición de hotel -->
<div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editHotelForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_hotel" id="editHotelId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHotelModalLabel">Editar hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editHotelName" class="form-label">Nombre hotel</label>
                            <input type="text" id="editHotelName" name="hotelName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editHotelZona" class="form-label">Zona hotel</label>
                            <select name="zoneSelect" id="editHotelZona" class="form-select" required>
                                @foreach(\App\Models\TransferZona::all() as $zona)
                                    <option value="{{ $zona->id_zona }}">{{ $zona->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editHotelCommission" class="form-label">Comisión</label>
                            <input type="number" name="hotelCommission" id="editHotelCommission" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editHotelEmail" class="form-label">Email</label>
                            <input type="email" name="hotelEmail" id="editHotelEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="editHotelPassword" class="form-label">Contraseña</label>
                        <input type="password" name="hotelPassword" id="editHotelPassword" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>