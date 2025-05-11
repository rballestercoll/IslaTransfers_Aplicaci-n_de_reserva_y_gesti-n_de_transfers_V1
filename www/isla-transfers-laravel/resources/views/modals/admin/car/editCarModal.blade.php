<!-- Modal de edición de vehículo -->
<div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editCarForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_vehiculo" id="editCarId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCarModalLabel">Editar vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editCarDescription" class="form-label">Descripción del vehículo</label>
                            <input type="text" id="editCarDescription" name="descripcion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editCarEmail" class="form-label">Email del conductor</label>
                            <input type="email" name="email_conductor" id="editCarEmail" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editCarPassword" class="form-label">Contraseña (opcional)</label>
                            <input type="password" name="password" id="editCarPassword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
