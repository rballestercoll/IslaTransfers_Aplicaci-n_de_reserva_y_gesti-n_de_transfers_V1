<h2>Comisiones de Hotel {{ $hotel->id_hotel }}</h2>
<p>Comisión pactada: <strong>{{ $hotel->Comision }} € por viajero</strong></p>

<table border="1">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Reservas</th>
            <th>Viajeros</th>
            <th>Total Comisión (€)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($resumen as $mes)
            <tr>
                <td>{{ $mes->mes }}</td>
                <td>{{ $mes->total_reservas }}</td>
                <td>{{ $mes->total_viajeros }}</td>
                <td>{{ number_format($mes->total_comision, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No hay reservas para este hotel.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>
<a href="{{ url('/admin/hoteles') }}">← Volver a hoteles</a>
