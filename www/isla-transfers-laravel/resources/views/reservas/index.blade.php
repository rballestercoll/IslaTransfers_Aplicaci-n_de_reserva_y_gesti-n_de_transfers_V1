@extends('layouts.app')

@section('title','Mis Reservas')

@push('styles')
<style>
  .chip { padding: 2px 6px; border-radius: 4px; font-size: .75rem; }
  .chip-admin { background: #ffe0e0; color: #c00; }
  .chip-usuario { background: #e0ffe0; color: #070; }
</style>
@endpush

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Mis Reservas</h2>
    <a href="{{ route('reservas.create') }}" class="btn btn-success">Nueva Reserva</a>
  </div>

  @if($reservas->isEmpty())
    <div class="alert alert-info">
      Aún no tienes reservas. <a href="{{ route('reservas.create') }}">Haz una ahora</a>.
    </div>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Localizador</th>
          <th>Entrada</th>
          <th>Salida</th>
          <th>Viajeros</th>
          <th>Creado por</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reservas as $r)
          @php
            $fechaHora = \Carbon\Carbon::parse("{$r->fecha_entrada} {$r->hora_entrada}");
            $puedeModificar = $fechaHora->gt(\Carbon\Carbon::now()->addHours(48));
          @endphp
          <tr>
            <td>{{ $r->localizador }}</td>
            <td>{{ $r->fecha_entrada }} {{ $r->hora_entrada }}</td>
            <td>{{ $r->fecha_vuelo_salida }} {{ $r->hora_vuelo_salida }}</td>
            <td>{{ $r->num_viajeros }}</td>
            <td>
              <span class="chip chip-{{ $r->creado_por === 'admin' ? 'admin' : 'usuario' }}">
                {{ ucfirst($r->creado_por) }}
              </span>
            </td>
            <td>
              <a href="{{ route('reservas.show', $r) }}" class="btn btn-sm btn-outline-primary">Ver</a>
              @if($puedeModificar)
                <a href="{{ route('reservas.edit', $r) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                <form action="{{ route('reservas.destroy', $r) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Cancelar la reserva?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Cancelar</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
