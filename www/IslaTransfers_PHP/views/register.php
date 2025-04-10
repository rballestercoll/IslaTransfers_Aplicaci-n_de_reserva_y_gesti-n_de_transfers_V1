<h2>Registro de Usuario</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>
  <p style="color: red;">Ocurrió <strong>un problema al registrar</strong>. Intenta de nuevo.</p>
<?php endif; ?>

<form method="post" action="?controller=Login&action=processRegister">
  <label>Email:</label><br>
  <input type="email" name="email" required><br><br>

  <label>Contraseña:</label><br>
  <input type="password" name="password" required><br><br>

  <label>Nombre (opcional):</label><br>
  <input type="text" name="nombre"><br><br>

  <label>Tipo de usuario:</label><br>
  <select name="rol">
    <option value="particular">Particular</option>
    <option value="corporativo">Corporativo</option>
    <option value="admin">Administrador</option>
  </select><br><br>

  <input type="submit" value="Registrarse">
</form>

<p>¿Ya tienes cuenta? <a href="?controller=Login&action=showLoginForm">Inicia sesión</a></p>
