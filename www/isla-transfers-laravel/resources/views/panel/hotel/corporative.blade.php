@extends('layouts.app')

@section('title', 'Hotel - Administración')

@include('modals.hotel.oneWayModal')
@include('modals.hotel.returnModal')
@include('modals.hotel.roundTripModal')
@include('modals.hotel.editOneWayModal')
@include('modals.hotel.editReturnModal')
@include('modals.hotel.editRoundTripModal')


@section('content')

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<style>
  body {
    font-family: 'Open Sans', sans-serif;
    background: #f5f5f5;
  }
  .admin-section {
    padding: 4rem 1rem;
  }
  .admin-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  .admin-header h1 {
    font-weight: 700;
    color: #333;
  }
  .admin-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
  }
  .admin-actions .btn {
  font-weight: 600;
  min-width: 220px;
  color: #111;
  transition: background 0.2s;
}

/* Azul claro suave */
.btn-primary {
  background: #a3c5f0;
}
.btn-primary:hover {
  background: #8bb2de;
}

/* Cambiamos “danger” a un azul más pálido */
.btn-danger {
  background: #b8d1f7;
}
.btn-danger:hover {
  background: #9fbeef;
}

/* “Success” a un celeste suave */
.btn-success {
  background: #c3e0fb;
}
.btn-success:hover {
  background: #a9d3f7;
}

/* “Secondary” a un azul muy claro */
.btn-secondary {
  background: #d0e6ff;
  color: #333;
}
.btn-secondary:hover {
  background: #b8d9ff;
}

  .card-calendar {
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 1rem;
    max-width: 1200px;
    margin: 0 auto;
  }
  #calendar {
    min-height: 600px;
  }
</style>

<section class="admin-section">
  <div class="admin-header">
    <h1>Panel de Administración de cliente corporativo</h1>
  </div>

  <div class="admin-actions">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal">
      <i class="fa-solid fa-circle-plus me-2"></i> Nueva reserva A→H
    </button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#returnAdminModal">
      <i class="fa-solid fa-circle-plus me-2"></i> Nueva reserva H→A
    </button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal">
      <i class="fa-solid fa-circle-plus me-2"></i> Reserva ida y vuelta
    </button>
  </div>
</section>

<!-- Modales -->
@include('modals.one_way_admin')
@include('modals.return_admin')
@include('modals.round_trip_admin')
@include('modals.edit_admin')
    <hr>
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
</div>
<!-- Sección para vuelos de IDA -->
<div class="mt-5">
    
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

   <div class="d-flex justify-content-center align-items-center mb-4">
        <h2 class="fw-bold text-center text-gray-300">
            <i class="fa-solid fa-list-check me-2"></i>
            Listado de reservas registradas
        </h2>
    </div>

    {{-- Aquí combinamos las tres colecciones en una sola --}}
    @php
        $reservas = $oneWayBookings
            ->concat($returnBookings)
            ->concat($roundTripBookings)
            ->sortByDesc('fecha_reserva')
            ->values();
    @endphp

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
                                // Detectamos tipo de trayecto para el modal de edición
                                $tipo_trayecto = 3;
                                if ($reserva->fecha_entrada && ! $reserva->fecha_vuelo_salida) {
                                    $tipo_trayecto = 1;
                                } elseif (! $reserva->fecha_entrada && $reserva->fecha_vuelo_salida) {
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

                                        <form action="{{ route('hotel.reserva.destroy', $reserva->id_reserva) }}"
                                              method="POST" onsubmit="return confirm('¿Eliminar esta reserva?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
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

{{-- Reutiliza tu modal de edición (puedes renombrar o hacer uno específico para corporate) --}}
@include('modals.edit_admin')
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.editAdminBtn').on('click', function () {
        const id   = $(this).data('id');
        const tipo = parseInt($(this).data('tipo'), 10);

        // Mostrar/ocultar campos del modal según tipo
        if (tipo === 1) {
            $('.campo-entrada').removeClass('d-none');
            $('.campo-salida').addClass('d-none');
        } else if (tipo === 2) {
            $('.campo-entrada').addClass('d-none');
            $('.campo-salida').removeClass('d-none');
        } else {
            $('.campo-entrada, .campo-salida').removeClass('d-none');
        }

        // Traer datos y rellenar formulario
        fetch(`/hotel/reserva/${id}`)
            .then(res => res.json())
            .then(reserva => {
                $('#editReservationForm').attr('action', `/hotel/reserva/${id}`);
                $('#reservaId').val(reserva.id_reserva);
                $('#tipoReservaEdit').val(reserva.id_tipo_reserva);
                $('#uuidEdit').val(reserva.localizador);
                $('#customerEmailEdit').val(reserva.email_cliente);
                $('#passengerNumEdit').val(reserva.num_viajeros);
                $('#hotelSelectEdit').val(reserva.id_destino);
                $('#carSelectEdit').val(reserva.id_vehiculo);

                // Campos de llegada
                $('#bookingDateEdit').val(reserva.fecha_entrada?.substring(0,10) || '');
                $('#bookingTimeEdit').val(reserva.hora_entrada?.substring(0,5) || '');
                $('#flyNumerEdit').val(reserva.numero_vuelo_entrada || '');
                $('#originAirportEdit').val(reserva.origen_vuelo_entrada || '');

                // Campos de salida
                $('#dateFlyEdit').val(reserva.fecha_vuelo_salida?.substring(0,10) || '');
                $('#timeFlyEdit').val(reserva.hora_vuelo_salida?.substring(0,5) || '');
                $('#pickupTimeEdit').val(reserva.hora_recogida_salida?.substring(0,5) || '');

                $('#editModal').modal('show');
            });
    });
});
</script>
@endpush
