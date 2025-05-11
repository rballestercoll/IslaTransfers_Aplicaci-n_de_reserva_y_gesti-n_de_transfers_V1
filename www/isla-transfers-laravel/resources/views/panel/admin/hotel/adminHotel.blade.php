@extends('layouts.app')

@section('title', 'Gestión hoteles')

@section('content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-hotel me-2"></i>Lista de hoteles registrados
        </h2>
        <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#newHotelModal">
            <i class="fa-solid fa-square-h me-2"></i> Añadir hotel
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Nombre del hotel</th>
                            <th>Zona del hotel</th>
                            <th>Comisión</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hoteles as $hotel)
                        <tr>
                            <td>{{ $hotel->nombre_hotel }}</td>
                            <td>{{ optional($hotel->zona)->descripcion ?? 'Zona no asignada' }}</td>
                            <td>{{ $hotel->comision }}%</td>
                            <td>{{ $hotel->email_hotel }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-warning editHotelBtn"
                                        data-id="{{ $hotel->id_hotel }}"
                                        data-nombre="{{ $hotel->nombre_hotel }}"
                                        data-comision="{{ $hotel->comision }}"
                                        data-email="{{ $hotel->email_hotel }}"
                                        data-zona="{{ $hotel->id_zona }}">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                    </button>

                                    <form action="{{ route('admin.hotel.destroy', $hotel->id_hotel) }}" method="POST">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar este hotel?')">
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

@include('modals.admin.hotel.edit_hotel')
@include('modals.admin.hotel.new_hotel')
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.editHotelBtn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            document.getElementById('editHotelId').value = id;
            document.getElementById('editHotelForm').action = `/admin/hotel/${id}`;
            document.getElementById('editHotelName').value = button.dataset.nombre;
            document.getElementById('editHotelCommission').value = button.dataset.comision;
            document.getElementById('editHotelEmail').value = button.dataset.email;
            document.getElementById('editHotelZona').value = button.dataset.zona;
            document.getElementById('editHotelPassword').value = button.dataset.password;
            const modal = new bootstrap.Modal(document.getElementById('editHotelModal'));
            modal.show();
        });
    });
</script>
@endpush