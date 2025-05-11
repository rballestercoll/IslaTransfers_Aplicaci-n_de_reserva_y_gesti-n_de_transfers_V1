<h2>Resumen de reservas por hotel</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Hotel</th>
            <th>Email</th>
            <th>Reservas</th>
            <th>Pasajeros</th>
            <th>Comisión/Reserva (€)</th>
            <th>Total Comisión (€)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resumen as $hotel)
            <tr>
                <td>{{ $hotel['descripcion'] }}</td>
                <td>{{ $hotel['email'] }}</td>
                <td>{{ $hotel['reservas'] }}</td>
                <td>{{ $hotel['pasajeros'] }}</td>
                <td>{{ $hotel['comision'] }}</td>
                <td><strong>{{ $hotel['total'] }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>
