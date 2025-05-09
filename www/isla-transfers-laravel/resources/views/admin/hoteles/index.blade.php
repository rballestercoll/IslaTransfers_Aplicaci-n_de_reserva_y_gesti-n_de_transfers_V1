<h2>Listado de Hoteles</h2>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<table border="1">
    <thead>
        <tr>
            <th>ID Hotel</th>
            <th>Zona</th>
            <th>Comisión</th>
            <th>Usuario</th>
            <th>Acciones</th> {{-- cambiamos a plural --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($hoteles as $hotel)
            <tr>
                <td>{{ $hotel->id_hotel }}</td>
                <td>{{ $hotel->id_zona }}</td>
                <td>{{ $hotel->Comision }}%</td>
                <td>{{ $hotel->usuario }}</td>
                <td>
                    <a href="{{ url('/admin/hoteles/' . $hotel->id_hotel . '/edit') }}">✏️ Editar</a> |
                    <a href="{{ url('/admin/hoteles/' . $hotel->id_hotel . '/comisiones') }}">📊 Comisiones</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>
<a href="{{ url('/admin') }}">← Volver al panel</a>
