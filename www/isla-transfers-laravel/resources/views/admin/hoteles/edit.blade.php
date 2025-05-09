<h2>Editar Comisión - Hotel {{ $hotel->id_hotel }}</h2>

<form method="POST" action="{{ url('/admin/hoteles/' . $hotel->id_hotel) }}">
    @csrf
    @method('PUT')

    <label>Comisión (%):
        <input type="number" name="Comision" value="{{ $hotel->Comision }}" step="0.01" min="0" max="100" required>
    </label><br>

    <button type="submit">💾 Guardar</button>
</form>

<br>
<a href="{{ url('/admin/hoteles') }}">← Volver al listado de hoteles</a>
