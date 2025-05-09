<h2>Editar Zona #{{ $zona->id_zona }}</h2>

<form method="POST" action="{{ url('/admin/zonas/' . $zona->id_zona) }}">
    @csrf
    @method('PUT')

    <label>Descripción:
        <input type="text" name="descripcion" value="{{ $zona->descripcion }}" required>
    </label><br>

    <button type="submit">💾 Guardar cambios</button>
</form>

<br>
<a href="{{ url('/admin/zonas') }}">← Volver al listado de zonas</a>
