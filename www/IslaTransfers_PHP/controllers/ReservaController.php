<?php

class ReservaController {

    public function listar() {
        // Verificamos si el usuario está logueado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Login&action=showLoginForm');
            exit();
        }

        // Obtenemos el ID del usuario logueado
        $usuarioId = $_SESSION['usuario_id'];

        // Cargamos el modelo de reservas
        require_once __DIR__ . '/../models/Reserva.php';
        $reservaModel = new Reserva();

        // Obtenemos las reservas del usuario
        $reservas = $reservaModel->obtenerReservasPorUsuario($usuarioId);

        // Mostramos la vista
        require_once __DIR__ . '/../views/reservas/lista_reservas.php';
    }

    public function crear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Solo accesible si eres admin
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            echo "⛔ Acceso no autorizado.";
            exit();
        }

        // Mostramos el formulario de nueva reserva
        require_once __DIR__ . '/../views/reservas/form_nueva_reserva.php';
    }

}
