<?php
// views/login/form_register.php

$errorRegistro   = $_SESSION['error_registro']   ?? null;
$mensajeRegistro = $_SESSION['mensaje_registro'] ?? null;
unset($_SESSION['error_registro'], $_SESSION['mensaje_registro']);

require_once __DIR__ . '/../templates/header.php';
?>
<main class="page-content">
  <div class="auth-wrapper">
    <div class="auth-card">
      <h2 class="auth-title">Registro de Usuario</h2>

      <?php if ($errorRegistro): ?>
        <p class="error-msg"><?php echo $errorRegistro; ?></p>
      <?php endif; ?>

      <?php if ($mensajeRegistro): ?>
        <p class="success-msg"><?php echo $mensajeRegistro; ?></p>
      <?php endif; ?>

      <form action="?controller=Login&action=processRegister" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input 
            type="email"
            name="email"
            id="email"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input 
            type="password"
            name="password"
            id="password"
            required
          />
        </div>

        <div class="form-group">
          <label for="nombre">Nombre (opcional)</label>
          <input 
            type="text"
            name="nombre"
            id="nombre"
          />
        </div>

        <div class="form-group">
          <label for="rol">Tipo de usuario</label>
          <select name="rol" id="rol">
            <option value="particular">Particular</option>
            <option value="corporativo">Corporativo</option>
            <option value="admin">Administrador</option>
          </select>
        </div>

        <button type="submit" class="btn-primary">Registrarse</button>
      </form>
      <p class="auth-switch">
        ¿Ya tienes cuenta? <a href="?controller=Login&action=showLoginForm">Inicia sesión</a>
      </p>
    </div>
  </div>
</main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
