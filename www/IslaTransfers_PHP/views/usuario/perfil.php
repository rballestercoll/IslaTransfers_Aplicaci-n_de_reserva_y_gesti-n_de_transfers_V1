<?php require_once __DIR__.'/../templates/header.php'; ?>
<main class="page-content">
  <h1>Mi perfil</h1><br>
  <p><strong>Mi nombre:</strong> <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Desconocido') ?></p>
  <p><strong>Rol:</strong> <?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'Sin rol') ?></p><br><br>
  <h2>Actualizar datos del Perfil</h2><br>
  
  <form action="?controller=Perfil&action=actualizar" method="POST">
    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($_SESSION['usuario_nombre'] ?? '') ?>"><br><br>
    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['usuario_email']) ?>" required><br><br>
    <label>Nueva contraseña</label>
    <input type="password" name="password"><br><small>déjala vacía si no cambia</small><br><br>
    <button class="btn-primary">Guardar</button>
  </form>
</main>
<?php require_once __DIR__.'/../templates/footer.php'; ?>
