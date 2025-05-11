@extends('layouts.app')

@section('title', 'Administración')

@include('modals.edit_admin')

@section('content')

<!-- Fuente profesional -->
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
    <h1>Panel de Administración</h1>
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
    <a href="{{ url('/admin/estadisticas-zonas') }}" target="_blank"
      class="btn btn-secondary">
      <i class="fa-solid fa-chart-bar me-2"></i> Estadísticas (JSON)
    </a>
    <a href="{{ route('admin.hoteles.resumen') }}" class="btn btn-warning">
      <i class="fa-solid fa-file-invoice-dollar me-2"></i> Resumen hoteles (comisiones)
    </a>
  </div>


  <div class="card-calendar">
    <div id="calendar"></div>
  </div>
</section>

<!-- Modales -->
@include('modals.one_way_admin')
@include('modals.return_admin')
@include('modals.round_trip_admin')
@include('modals.edit_admin')

@endsection

@push('scripts')
<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales-all.global.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      buttonText: {
        today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día'
      },
      events: '/api/reservas',
      eventDisplay: 'list-item',
      eventDidMount: function(info) {
        if (info.event.extendedProps.tooltip) {
          info.el.setAttribute('title', info.event.extendedProps.tooltip);
        }
      },
      eventClick: function(info) {
        const reservaId = info.event.id.split('-')[0];
        const tipo = info.event.extendedProps.tipo_trayecto;
        // Mostrar/ocultar campos según tipo
        $('.campo-entrada').toggle(tipo != 2);
        $('.campo-salida').toggle(tipo != 1);
        fetch(`/admin/reserva/${reservaId}`)
          .then(res => res.json())
          .then(data => {
            $('#editReservationForm').attr('action', `/admin/reserva/${reservaId}`);
            $('#deleteReservationForm').attr('action', `/admin/reserva/${reservaId}`);
            $('#reservaId').val(data.id_reserva);
            $('#tipoReservaEdit').val(data.id_tipo_reserva);
            $('#uuidEdit').val(data.localizador || '');
            $('#customerEmailEdit').val(data.email_cliente || '');
            $('#passengerNumEdit').val(data.num_viajeros || '');
            $('#hotelSelectEdit').val(data.id_destino || '');
            $('#carSelectEdit').val(data.id_vehiculo || '');
            $('#bookingDateEdit').val(data.fecha_entrada?.substring(0,10) || '');
            $('#bookingTimeEdit').val(data.hora_entrada?.substring(0,5) || '');
            $('#flyNumerEdit').val(data.numero_vuelo_entrada || '');
            $('#originAirportEdit').val(data.origen_vuelo_entrada || '');
            $('#dateFlyEdit').val(data.fecha_vuelo_salida?.substring(0,10) || '');
            $('#timeFlyEdit').val(data.hora_vuelo_salida?.substring(0,5) || '');
            $('#pickupTimeEdit').val(data.hora_recogida_salida?.substring(0,5) || '');
            $('#editModal').modal('show');
          });
      }
    });
    calendar.render();
  });
</script>
@endpush
