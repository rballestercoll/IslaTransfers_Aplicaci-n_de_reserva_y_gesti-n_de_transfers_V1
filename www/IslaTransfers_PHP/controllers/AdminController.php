<?php
// controllers/AdminController.php

require_once __DIR__ . '/../models/Reserva.php';

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

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación básica
            $campos = [
                'email_cliente', 'id_hotel', 'id_tipo_reserva', 'id_destino',
                'fecha_entrada', 'hora_entrada', 'numero_vuelo_entrada', 'origen_vuelo_entrada',
                'fecha_vuelo_salida', 'hora_vuelo_salida', 'num_viajeros', 'id_vehiculo'
            ];

            foreach ($campos as $campo) {
                if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                    echo "<p style='color:red;'>Falta el campo: $campo</p>";
                    return;
                }
            }

            // Preparamos datos
            $reservaModel = new Reserva();

            $datos = [
                'id_usuario'           => $_SESSION['usuario_id'],
                'email_cliente'        => trim($_POST['email_cliente']),
                'localizador'          => uniqid('RES_'), // Se genera automáticamente
                'id_hotel'             => $_POST['id_hotel'],
                'id_tipo_reserva'      => $_POST['id_tipo_reserva'],
                'fecha_reserva'        => date('Y-m-d H:i:s'),
                'fecha_modificacion'   => date('Y-m-d H:i:s'),
                'id_destino'           => $_POST['id_destino'],
                'fecha_entrada'        => $_POST['fecha_entrada'],
                'hora_entrada'         => $_POST['hora_entrada'],
                'numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'],
                'origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'],
                'fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida'],
                'hora_vuelo_salida'    => $_POST['hora_vuelo_salida'],
                'num_viajeros'         => $_POST['num_viajeros'],
                'id_vehiculo'          => $_POST['id_vehiculo']
            ];

            // Guardar en base de datos
            $guardado = $reservaModel->crearReserva($datos);

            if ($guardado) {
                echo "<p style='color:green;'>✅ Reserva creada correctamente.</p>";
                // Aquí se podría redirigir o mostrar un mensaje
                // header('Location: ?controller=Admin&action=dashboard');
            } else {
                echo "<p style='color:red;'>❌ No se pudo crear la reserva.</p>";
            }
        } else {
            echo "<p style='color:red;'>Acceso no válido.</p>";
        }
    }
}
