<?php
// views/templates/header.php

// Asumimos que la sesión ya está iniciada en index.php.
// Podríamos usar las variables ya definidas en index.php, o volver a construirlas:
$usuarioLogueado = isset($_SESSION['usuario_id']);
$rolUsuario      = $_SESSION['usuario_rol'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Isla Transfers</title>
  <link rel="stylesheet" href="assets/css/estilo.css" />
</head>
<body>
<header>
  <h1>Isla Transfers</h1>
  <nav>
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#">Servicios</a></li>
      <li><a href="#">Contacto</a></li>
      <?php if (!$usuarioLogueado): ?>
      <!-- Si NO está logueado, mostramos enlaces a login y registro -->
        <a href="?controller=Login&action=showLoginForm">Iniciar Sesión</a>
        <a href="?controller=Login&action=showRegisterForm">Registrarse</a>
      <?php else: ?>
        <?php if ($rolUsuario === 'admin'): ?>
          <a href="?controller=Admin&action=panel">Panel Admin</a>
        <?php elseif ($rolUsuario === 'particular'): ?>
          <a href="?controller=Reserva&action=listar">Mis Reservas</a>
        <?php elseif ($rolUsuario === 'corporativo'): ?>
          <a href="?controller=Reserva&action=corporativo">Reservas del Hotel</a>
        <?php endif; ?>
        <a href="?controller=Login&action=logout">Cerrar Sesión</a>
      <?php endif; ?>

    </ul>
  </nav>
</header>
