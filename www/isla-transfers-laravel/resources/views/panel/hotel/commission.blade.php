@extends('layouts.app')

@section('title', 'Comisiones del mes')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-euro-sign me-2"></i>Comisiones del mes de {{ $mes }}
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($reservas->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    No hay reservas registradas este mes.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Localizador</th>
                                <th>Cliente</th>
                                <th>Fecha Reserva</th>
                                <th>Vehículo</th>
                                <th>Precio</th>
                                <th>Comisión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->localizador }}</td>
                                <td>{{ $reserva->email_cliente }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}</td>
                                <td>{{ $reserva->vehiculo->descripcion }}</td>
                                <td>{{ number_format($reserva->precio, 2) }} €</td>
                                <td class="fw-bold text-success">{{ number_format($reserva->comision_hotel, 2) }} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Total comisión del mes:</th>
                                <th class="text-success fw-bold">{{ number_format($totalComision, 2) }} €</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
