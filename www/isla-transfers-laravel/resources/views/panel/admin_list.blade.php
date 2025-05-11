@extends('layouts.app')

@section('title', 'Listado de reservas')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-list-check me-2"></i>Listado de reservas registradas
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Localizador</th>
                            <th>Cliente</th>
                            <th>Fecha reserva</th>
                            <th>Última modificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservas as $reserva)
                        @php
                            // Detectar tipo de trayecto como en el API
                            $tipo_trayecto = 3;
                            if ($reserva->fecha_entrada && !$reserva->fecha_vuelo_salida) {
                                $tipo_trayecto = 1;
                            } elseif (!$reserva->fecha_entrada && $reserva->fecha_vuelo_salida) {
                                $tipo_trayecto = 2;
                            }
                        @endphp
                        <tr>
                            <td>{{ $reserva->localizador }}</td>
                            <td>{{ $reserva->email_cliente }}</td>
                            <td>{{ $reserva->fecha_reserva }}</td>
                            <td>{{ $reserva->fecha_modificacion ?? '—' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning editAdminBtn"
                                        data-id="{{ $reserva->id_reserva }}"
                                        data-tipo="{{ $tipo_trayecto }}">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                    </button>

                                    <form action="{{ route('admin.reserva.destroy', $reserva->id_reserva) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta reserva?')">
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

@include('modals.edit_admin')
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('.editAdminBtn').on('click', function () {
        const id = $(this).data('id');
        const tipo = parseInt($(this).data('tipo'));

        console.log('ID de reserva:', id);
        console.log('Tipo (desde botón):', tipo);

        // Mostrar/ocultar campos según tipo
        if (tipo === 1) {
            $('.campo-entrada').removeClass('d-none');
            $('.campo-salida').addClass('d-none');
        } else if (tipo === 2) {
            $('.campo-entrada').addClass('d-none');
            $('.campo-salida').removeClass('d-none');
        } else {
            $('.campo-entrada').removeClass('d-none');
            $('.campo-salida').removeClass('d-none');
        }

        fetch(`/admin/reserva/${id}`)
            .then(response => response.json())
            .then(reserva => {
                console.log('Datos recibidos del fetch:', reserva);
                $('#editReservationForm').attr('action', `/admin/reserva/${id}`);
                $('#deleteReservationForm').attr('action', `/admin/reserva/${id}`);
                $('#reservaId').val(reserva.id_reserva);
                $('#tipoReservaEdit').val(reserva.id_tipo_reserva);
                $('#uuidEdit').val(reserva.localizador ?? '');
                $('#customerEmailEdit').val(reserva.email_cliente ?? '');
                $('#passengerNumEdit').val(reserva.num_viajeros ?? '');
                $('#hotelSelectEdit').val(reserva.id_destino ?? '');
                $('#carSelectEdit').val(reserva.id_vehiculo ?? '');
                $('#bookingDateEdit').val(reserva.fecha_entrada ? reserva.fecha_entrada.substring(0, 10) : '');
                $('#bookingTimeEdit').val(reserva.hora_entrada ? reserva.hora_entrada.substring(0, 5) : '');
                $('#flyNumerEdit').val(reserva.numero_vuelo_entrada ?? '');
                $('#originAirportEdit').val(reserva.origen_vuelo_entrada ?? '');
                $('#dateFlyEdit').val(reserva.fecha_vuelo_salida ? reserva.fecha_vuelo_salida.substring(0, 10) : '');
                $('#timeFlyEdit').val(reserva.hora_vuelo_salida ? reserva.hora_vuelo_salida.substring(0, 5) : '');
                $('#pickupTimeEdit').val(reserva.hora_recogida_salida ? reserva.hora_recogida_salida.substring(0, 5) : '');
                $('#editModal').modal('show');
            });
    });
});
</script>
@endpush