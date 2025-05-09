<h2>Reservas</h2>

@if(session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<form method="GET" action="{{ url('/admin/reservas') }}">
    <label>Desde: <input type="date" name="inicio" value="{{ request('inicio') }}"></label>
    <label>Hasta: <input type="date" name="fin" value="{{ request('fin') }}"></label>
    <button type="submit">Filtrar</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hotel</th>
            <th>Vehículo</th>
            <th>Fecha</th>
            <th>Nº Viajeros</th>
            <th>Acción</th> {{-- Nueva columna --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($reservas as $reserva)
            <tr>
                <td>{{ $reserva->id_reserva }}</td>
                <td>{{ $reserva->hotel->id_hotel ?? '-' }}</td>
                <td>{{ $reserva->vehiculo->descripcion ?? '-' }}</td>
                <td>{{ $reserva->fecha_reserva }}</td>
                <td>{{ $reserva->num_viajeros }}</td>
                <td>
                    <a href="{{ url('/admin/reservas/' . $reserva->id_reserva) }}">Ver</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<form action="{{ url('/admin') }}" method="get" style="display:inline;">
    <button type="submit">🏠 Volver al panel de administración</button>
</form>

