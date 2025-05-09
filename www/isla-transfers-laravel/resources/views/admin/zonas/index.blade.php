<h2>Listado de Zonas Turísticas</h2>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<table border="1">
    <thead>
        <tr>
            <th>ID Zona</th>
            <th>Descripción</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zonas as $zona)
            <tr>
                <td>{{ $zona->id_zona }}</td>
                <td>{{ $zona->descripcion }}</td>
                <td><a href="{{ url('/admin/zonas/' . $zona->id_zona . '/edit') }}">Editar</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ url('/admin') }}">← Volver al panel</a>
