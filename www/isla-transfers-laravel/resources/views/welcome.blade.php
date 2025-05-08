<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isla Transfers</title>
</head>
<body>
    <h1>Bienvenido a Isla Transfers</h1>
    <p>Gestiona tus traslados del aeropuerto al hotel de forma sencilla.</p>
    <a href="{{ route('login') }}">Iniciar sesión</a> |
    <a href="{{ route('register') }}">Registrarse</a>
</body>
</html>
