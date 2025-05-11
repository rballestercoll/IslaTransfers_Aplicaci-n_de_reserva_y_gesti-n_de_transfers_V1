<!-- Modal -->
<div class="modal fade" id="newCarModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Registrar vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.vehiculos.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="emailConductor" class="form-label">Email del conductor</label>
                            <input type="email" name="emailConductor" id="emailConductor" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="conductorPassword" class="form-label">Contraseña</label>
                            <input type="password" name="conductorPassword" id="conductorPassword" class="form-control" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Añadir vehículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
