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
        <li><a href="?controller=Login&action=showLoginForm">Iniciar Sesión</a></li>
        <li><a href="?controller=Login&action=showRegisterForm">Registrarse</a></li>
      <?php else: ?>
        <li><a href="?controller=Login&action=logout">Cerrar Sesión</a></li>
        <?php if ($rolUsuario === 'admin'): ?>
          <li><a href="?controller=Admin&action=dashboard">Panel Admin</a></li>
        <?php else: ?>
          <li><a href="?controller=Reserva&action=listar">Mis Reservas</a></li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </nav>
</header>
