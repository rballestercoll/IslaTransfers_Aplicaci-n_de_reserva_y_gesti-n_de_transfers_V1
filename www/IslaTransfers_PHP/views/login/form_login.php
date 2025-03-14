<?php
// views/login/form_login.php
$errorLogin = $_SESSION['error_login'] ?? null;
unset($_SESSION['error_login']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Isla Transfers</title>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
  <h2>Iniciar Sesión</h2>

  <?php if ($errorLogin): ?>
    <p style="color: red;"><?php echo $errorLogin; ?></p>
  <?php endif; ?>

  <form action="?controller=Login&action=processLogin" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Entrar</button>
  </form>

  <p>¿No tienes cuenta? <a href="?controller=Login&action=showRegisterForm">Regístrate aquí</a></p>
</body>
</html>
