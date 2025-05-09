<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
</head>
<body>
    <h1>👤 Panel de Administración</h1>

    <p>Bienvenido, {{ Auth::user()->nombre ?? Auth::user()->email }}</p>

    <ul>
        <li><a href="{{ url('/admin/reservas') }}">📋 Gestión de reservas</a></li>
        <li><a href="{{ url('/admin/hoteles') }}">🏨 Hoteles y comisiones</a></li>
        <li><a href="{{ url('/admin/zonas') }}">📊 Estadísticas por zona</a></li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">🔒 Cerrar sesión</button>
    </form>
</body>
</html>

