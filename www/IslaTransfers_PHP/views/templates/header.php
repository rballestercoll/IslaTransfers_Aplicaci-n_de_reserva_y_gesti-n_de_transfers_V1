<?php
// views/templates/header.php

/* Aseguramos la sesión para poder leer $_SESSION */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Evitamos warnings si no existe la variable */
$usuarioLogueado = isset($_SESSION['usuario_id']);
$rolUsuario      = $_SESSION['usuario_rol'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Isla Transfers</title>
  <link rel="stylesheet" href="../assets/css/estilo.css" />
</head>

<?php
/* Popup (flash‑message) */
if (isset($_SESSION['popup'])):
    $mensaje = $_SESSION['popup']['texto'];
    $tipo    = $_SESSION['popup']['tipo'];   // success / error …
    unset($_SESSION['popup']);
?>
  <script>
    window.onload = function () {
      alert("<?= addslashes($mensaje) ?>");
    };
  </script>
<?php endif; ?>

<body>
<header class="main-header">
  <div class="header-container">
    <h1 class="site-title">Isla Transfers</h1>

    <nav class="navbar">
      <ul>
        <!-- enlaces visibles para todos -->
        <li><a href="index.php">Inicio</a></li>
        <li><a href="servicios.php">Servicios</a></li>
        <li><a href="contacto.php">Contacto</a></li>

        <?php if (!$usuarioLogueado): ?>
          <!-- Invitado -->
          <li><a href="index.php?controller=Login&action=showLoginForm">Iniciar Sesión</a></li>
          <li><a href="index.php?controller=Login&action=showRegisterForm">Registrarse</a></li>

        <?php else: ?>
          <!-- Usuario identificado -->
          <?php if ($rolUsuario === 'admin'): ?>
            <li><a href="index.php?controller=Admin&action=dashboard">Panel Admin</a></li>
            <li><a href="index.php?controller=Perfil&action=ver">Perfil del Administrador</a></li>

          <?php elseif ($rolUsuario === 'particular'): ?>
            <!-- NUEVO bloque para el usuario particular -->
            <li><a href="index.php?controller=Reserva&action=listar">Mis reservas</a></li>
            <li><a href="index.php?controller=Reserva&action=crearParticular">Nueva reserva</a></li>
            <li><a href="index.php?controller=Perfil&action=ver">Mi perfil</a></li>

          <?php elseif ($rolUsuario === 'corporativo'): ?>
            <li><a href="index.php?controller=Reserva&action=listar">Mis reservas</a></li>
            <li><a href="index.php?controller=Reserva&action=crearCorporativo">Reservas del Hotel</a></li>
            <li><a href="index.php?controller=Perfil&action=ver">Perfil del Hotel</a></li>
          <?php endif; ?>

          <li><a href="index.php?controller=Login&action=logout">Cerrar Sesión</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>