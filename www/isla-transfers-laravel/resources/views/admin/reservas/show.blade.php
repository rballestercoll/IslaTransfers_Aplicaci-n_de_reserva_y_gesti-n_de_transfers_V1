<h2>Detalle de la Reserva #{{ $reserva->id_reserva }}</h2>

<ul>
    <li><strong>Hotel:</strong> {{ $reserva->hotel->id_hotel ?? '-' }}</li>
    <li><strong>Vehículo:</strong> {{ $reserva->vehiculo->descripcion ?? '-' }}</li>
    <li><strong>Tipo de reserva:</strong> {{ $reserva->tipo->descripcion ?? '-' }}</li>
    <li><strong>Fecha reserva:</strong> {{ $reserva->fecha_reserva }}</li>
    <li><strong>Fecha modificación:</strong> {{ $reserva->fecha_modificacion }}</li>
    <li><strong>Fecha entrada:</strong> {{ $reserva->fecha_entrada }}</li>
    <li><strong>Hora entrada:</strong> {{ $reserva->hora_entrada }}</li>
    <li><strong>Fecha salida:</strong> {{ $reserva->fecha_vuelo_salida }}</li>
    <li><strong>Hora recogida:</strong> {{ $reserva->hora_recogida }}</li>
    <li><strong>Número de viajeros:</strong> {{ $reserva->num_viajeros }}</li>
    <li><strong>Email cliente:</strong> {{ $reserva->email_cliente }}</li>
    <li><strong>Número vuelo entrada:</strong> {{ $reserva->numero_vuelo_entrada }}</li>
    <li><strong>Número vuelo salida:</strong> {{ $reserva->numero_vuelo_salida }}</li>
    <li><strong>Origen vuelo entrada:</strong> {{ $reserva->origen_vuelo_entrada }}</li>
    <li><strong>Creado por:</strong> {{ $reserva->creado_por }}</li>
</ul>

<hr>

<h3>🧳 Viajeros</h3>

@if($reserva->viajeros->isEmpty())
    <p>No hay viajeros registrados para esta reserva.</p>
@else
    <ul>
        @foreach ($reserva->viajeros as $viajero)
            <li>{{ $viajero->nombre }} {{ $viajero->apellido1 }} ({{ $viajero->email }})</li>
        @endforeach
    </ul>
@endif

<a href="{{ url('/admin/reservas/' . $reserva->id_reserva . '/viajeros/create') }}">➕ Añadir viajero</a>

<hr>

<a href="{{ url('/admin/reservas/' . $reserva->id_reserva . '/edit') }}">📝 Editar</a>

<form method="POST" action="{{ url('/admin/reservas/' . $reserva->id_reserva) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')">❌ Cancelar reserva</button>
</form>

<a href="{{ url('/admin/reservas') }}">← Volver al listado</a>

