<h2>Editar Reserva #{{ $reserva->id_reserva }}</h2>

@if(session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ url('/admin/reservas/' . $reserva->id_reserva) }}">
    @csrf
    @method('PUT')

    <label>Fecha reserva:
        <input type="datetime-local" name="fecha_reserva" value="{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('Y-m-d\TH:i') }}">
    </label><br>

    <label>Fecha modificación:
        <input type="date" name="fecha_modificacion" value="{{ $reserva->fecha_modificacion }}">
    </label><br>

    <label>Fecha entrada:
        <input type="date" name="fecha_entrada" value="{{ $reserva->fecha_entrada }}">
    </label><br>

    <label>Hora entrada:
        <input type="time" name="hora_entrada" value="{{ $reserva->hora_entrada }}">
    </label><br>

    <label>Fecha salida:
        <input type="date" name="fecha_vuelo_salida" value="{{ $reserva->fecha_vuelo_salida }}">
    </label><br>

    <label>Hora salida:
        <input type="time" name="hora_vuelo_salida" value="{{ $reserva->hora_vuelo_salida }}">
    </label><br>

    <label>Hora recogida:
        <input type="time" name="hora_recogida" value="{{ $reserva->hora_recogida }}">
    </label><br>

    <label>Número de viajeros:
        <input type="number" name="num_viajeros" value="{{ $reserva->num_viajeros }}">
    </label><br>

    <label>Email cliente:
        <input type="email" name="email_cliente" value="{{ $reserva->email_cliente }}">
    </label><br>

    <label>Número vuelo entrada:
        <input type="text" name="numero_vuelo_entrada" value="{{ $reserva->numero_vuelo_entrada }}">
    </label><br>

    <label>Número vuelo salida:
        <input type="text" name="numero_vuelo_salida" value="{{ $reserva->numero_vuelo_salida }}">
    </label><br>

    <label>Origen vuelo entrada:
        <input type="text" name="origen_vuelo_entrada" value="{{ $reserva->origen_vuelo_entrada }}">
    </label><br>

    <label>Creado por:
        <input type="text" name="creado_por" value="{{ $reserva->creado_por }}">
    </label><br>

    <button type="submit">💾 Guardar cambios</button>
</form>

<br>
<a href="{{ url('/admin/reservas/' . $reserva->id_reserva) }}">← Volver al detalle</a>
