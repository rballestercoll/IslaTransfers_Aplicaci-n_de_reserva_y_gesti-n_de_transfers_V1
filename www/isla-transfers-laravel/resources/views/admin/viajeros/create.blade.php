<h2>Añadir Viajero a la Reserva #{{ $reserva->id_reserva }}</h2>

<form method="POST" action="{{ url('/admin/reservas/' . $reserva->id_reserva . '/viajeros') }}">
    @csrf

    <label>Nombre:
        <input type="text" name="nombre" required>
    </label><br>

    <label>Primer Apellido:
        <input type="text" name="apellido1" required>
    </label><br>

    <label>Segundo Apellido:
        <input type="text" name="apellido2">
    </label><br>

    <label>Email:
        <input type="email" name="email" required>
    </label><br>

    <label>Dirección:
        <input type="text" name="direccion">
    </label><br>

    <label>Código postal:
        <input type="text" name="codigoPostal" required>
    </label><br>

    <label>Ciudad:
        <input type="text" name="ciudad">
    </label><br>

    <label>País:
        <input type="text" name="pais">
    </label><br>

    <button type="submit">💾 Guardar viajero</button>
</form>

<br>
<a href="{{ url('/admin/reservas/' . $reserva->id_reserva) }}">← Volver al detalle de la reserva</a>
