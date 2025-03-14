<?php
// views/login/form_register.php
$errorRegistro   = $_SESSION['error_registro']   ?? null;
$mensajeRegistro = $_SESSION['mensaje_registro'] ?? null;
unset($_SESSION['error_registro'], $_SESSION['mensaje_registro']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario - Isla Transfers</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
  <h2>Registro de Usuario</h2>

  <?php if ($errorRegistro): ?>
    <p style="color: red;"><?php echo $errorRegistro; ?></p>
  <?php endif; ?>

  <?php if ($mensajeRegistro): ?>
    <p style="color: green;"><?php echo $mensajeRegistro; ?></p>
  <?php endif; ?>

  <form action="?controller=Login&action=processRegister" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br><br>

    <label for="nombre">Nombre (opcional):</label>
    <input type="text" name="nombre"><br><br>

    <!-- Campo para elegir el rol -->
    <label for="rol">Tipo de usuario:</label>
    <select name="rol">
      <option value="particular">Particular</option>
      <option value="admin">Administrador</option>
    </select><br><br>

    <button type="submit">Registrarse</button>
  </form>

  <p>¿Ya tienes cuenta? <a href="?controller=Login&action=showLoginForm">Inicia sesión</a></p>
</body>
</html>
