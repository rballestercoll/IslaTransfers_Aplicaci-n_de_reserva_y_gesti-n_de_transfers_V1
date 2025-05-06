@extends('layouts.app')

@section('title',"Reserva {$reserva->localizador}")

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h2>Detalle de Reserva</h2>

    <table class="table table-striped">
      <tbody>
        <tr>
          <th>Localizador</th>
          <td>{{ $reserva->localizador }}</td>
        </tr>
        <tr>
          <th>Tipo</th>
          <td>{{ $reserva->tipo->descripcion }}</td>
        </tr>
        <tr>
          <th>Hotel Origen</th>
          <td>{{ $reserva->hotel->descripcion }}</td>
        </tr>
        <tr>
          <th>Hotel Destino</th>
          <td>{{ $reserva->destino->descripcion }}</td>
        </tr>
        <tr>
          <th>Fecha Entrada</th>
          <td>{{ $reserva->fecha_entrada }} {{ $reserva->hora_entrada }}</td>
        </tr>
        <tr>
          <th>Fecha Salida</th>
          <td>{{ $reserva->fecha_vuelo_salida }} {{ $reserva->hora_vuelo_salida }}</td>
        </tr>
        <tr>
          <th>Nº Viajeros</th>
          <td>{{ $reserva->num_viajeros }}</td>
        </tr>
        <tr>
          <th>Vehículo</th>
          <td>{{ $reserva->vehiculo->descripcion }}</td>
        </tr>
        <tr>
          <th>Creada en</th>
          <td>{{ $reserva->fecha_reserva }}</td>
        </tr>
        <tr>
          <th>Última modificación</th>
          <td>{{ $reserva->fecha_modificacion }}</td>
        </tr>
      </tbody>
    </table>

    <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Volver</a>

    @php
      $cutoff = \Carbon\Carbon::parse($reserva->fecha_entrada.' '.$reserva->hora_entrada)
                    ->gt(\Carbon\Carbon::now()->addHours(48));
    @endphp

    @if($cutoff)
      <a href="{{ route('reservas.edit',$reserva) }}" class="btn btn-primary">Editar</a>

      <form action="{{ route('reservas.destroy',$reserva) }}" method="POST" class="d-inline"
            onsubmit="return confirm('¿Cancelar la reserva?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Cancelar</button>
      </form>
    @endif
  </div>
</div>
@endsection
