<?php
// views/templates/header.php

// Aseguramos la sesión para poder leer $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definimos estas variables para no tener warnings:
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
<header class="main-header">
  <div class="header-container">
    <h1 class="site-title">Isla Transfers</h1>
    <nav class="navbar">
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Contacto</a></li>

        <?php if (!$usuarioLogueado): ?>
          <li><a href="?controller=Login&action=showLoginForm">Iniciar Sesión</a></li>
          <li><a href="?controller=Login&action=showRegisterForm">Registrarse</a></li>
        <?php else: ?>
          <?php if ($rolUsuario === 'admin'): ?>
            <li><a href="?controller=Admin&action=dashboard">Panel Admin</a></li>
          <?php elseif ($rolUsuario === 'particular'): ?>
            <li><a href="?controller=Reserva&action=listar">Mis Reservas</a></li>
          <?php elseif ($rolUsuario === 'corporativo'): ?>
            <li><a href="?controller=Reserva&action=corporativo">Reservas del Hotel</a></li>
          <?php endif; ?>
          <li><a href="?controller=Login&action=logout">Cerrar Sesión</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
