<?php
// controllers/AdminController.php

class AdminController {
    public function dashboard() {
        // Asegurar que solo los admins pueden acceder
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        // Mostramos la vista del panel
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}
