@extends('layouts.app')

@section('title', 'Gestión vehículos')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-car"></i> Lista de vehículos registrados
        </h2>
        <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#newCarModal">
            <i class="fa-solid fa-car-side"></i>&nbsp;&nbsp;Añadir vehículo
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Descripción del vehículo</th>
                            <th>Email del conductor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehiculos as $vehiculo)
                        <tr>
                            <td>{{ $vehiculo->descripcion }}</td>
                            <td>{{ $vehiculo->email_conductor }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button"
                                        class="btn btn-sm btn-warning editCarBtn"
                                        data-id="{{ $vehiculo->id_vehiculo }}"
                                        data-descripcion="{{ $vehiculo->descripcion }}"
                                        data-email_conductor="{{ $vehiculo->email_conductor }}">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                    </button>

                                    <form action="{{ route('admin.vehiculos.destroy', $vehiculo->id_vehiculo) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar el vehículo?')">
                                            <i class="fa-solid fa-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('modals.admin.car.editCarModal')
@include('modals.admin.car.newCarModal')
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.editCarBtn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            document.getElementById('editCarId').value = id;
            document.getElementById('editCarForm').action = `/admin/vehiculo/${id}`;
            document.getElementById('editCarDescription').value = button.dataset.descripcion;
            document.getElementById('editCarEmail').value = button.dataset.email_conductor;
            document.getElementById('editCarPassword').value = button.dataset.password;

            const modal = new bootstrap.Modal(document.getElementById('editCarModal'));
            modal.show();
        });
    });
</script>
@endpush
