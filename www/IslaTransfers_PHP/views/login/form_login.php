<?php
// views/login/form_login.php

// Tomamos el posible mensaje de error desde la sesión
$errorLogin = $_SESSION['error_login'] ?? null;
unset($_SESSION['error_login']);

// Incluimos el header
require_once __DIR__ . '/../templates/header.php';
?>
<main class="page-content">
  <div class="auth-wrapper">
    <div class="auth-card">
      <h2 class="auth-title">Iniciar Sesión</h2>

      <?php if ($errorLogin): ?>
        <p class="error-msg"><?php echo $errorLogin; ?></p>
      <?php endif; ?>

      <form action="?controller=Login&action=processLogin" method="POST">
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

        <button type="submit" class="btn-primary">Entrar</button>
      </form>
      <p class="auth-switch">
        ¿No tienes cuenta? <a href="?controller=Login&action=showRegisterForm">Regístrate aquí</a>
      </p>
    </div>
  </div>
</main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
