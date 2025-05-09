<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, {{ Auth::user()->nombre }}!</h1>
    <p>Tu rol es: {{ Auth::user()->rol }}</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>

