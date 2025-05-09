<!DOCTYPE html>
<html>
<head>
    <title>Login - Isla Transfers</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="/login">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
