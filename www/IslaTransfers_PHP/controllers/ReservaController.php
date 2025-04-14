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

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            echo "⛔ Acceso no autorizado.";
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Reserva.php';
            $reservaModel = new Reserva();
    
            // Creamos un localizador único
            $localizador = strtoupper(uniqid('RES-'));
    
            // Obtenemos datos del formulario
            $datos = [
                'localizador'           => $localizador,
                'id_hotel'              => $_POST['id_hotel'] ?? null,
                'id_tipo_reserva'       => $_POST['tipo_reserva'],
                'email_cliente'         => $_POST['email_cliente'],
                'fecha_reserva'         => date('Y-m-d H:i:s'),
                'fecha_modificacion'    => date('Y-m-d H:i:s'),
                'id_destino'            => $_POST['id_destino'] ?? null,
                'fecha_entrada'         => $_POST['fecha_entrada'] ?? null,
                'hora_entrada'          => $_POST['hora_entrada'] ?? null,
                'numero_vuelo_entrada'  => $_POST['numero_vuelo_entrada'] ?? null,
                'origen_vuelo_entrada'  => $_POST['origen_vuelo_entrada'] ?? null,
                'hora_vuelo_salida'     => $_POST['hora_vuelo_salida'] ?? null,
                'fecha_vuelo_salida'    => $_POST['fecha_vuelo_salida'] ?? null,
                'num_viajeros'          => $_POST['num_viajeros'],
                'id_vehiculo'           => $_POST['id_vehiculo'] ?? null
            ];
    
            $resultado = $reservaModel->crearReserva($datos);
    
            if ($resultado) {
                echo "<p style='color:green;'>✅ Reserva creada con éxito. Localizador: <strong>{$localizador}</strong></p>";
            } else {
                echo "<p style='color:red;'>❌ Error al guardar la reserva.</p>";
            }
        } else {
            echo "⚠ Método no permitido.";
        }
    }    

}
