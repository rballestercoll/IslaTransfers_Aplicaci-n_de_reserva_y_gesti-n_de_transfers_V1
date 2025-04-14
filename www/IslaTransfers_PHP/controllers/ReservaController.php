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
    
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger los datos
            $usuarioId = $_SESSION['usuario_id'];
            $tipo      = $_POST['tipo_reserva'];
            $hotelId   = $_POST['hotel'] ?? null;
            $destinoId = $_POST['destino'] ?? null;
            $vehiculoId = $_POST['vehiculo'] ?? null;
            $numViajeros = $_POST['num_viajeros'] ?? 1;
            $localizador = strtoupper(uniqid('RES'));
    
            // Datos comunes
            $datos = [
                'id_usuario'         => $usuarioId,
                'localizador'        => $localizador,
                'id_tipo_reserva'    => $tipo,
                'id_hotel'           => $hotelId,
                'id_destino'         => $destinoId,
                'id_vehiculo'        => $vehiculoId,
                'num_viajeros'       => $numViajeros,
                'fecha_reserva'      => date('Y-m-d H:i:s'),
                'fecha_modificacion' => date('Y-m-d H:i:s'),
            ];
    
            // AEROPUERTO → HOTEL
            if ($tipo == 1 || $tipo == 3) {
                $datos['fecha_entrada']       = $_POST['fecha_entrada'] ?? null;
                $datos['hora_entrada']        = $_POST['hora_entrada'] ?? null;
                $datos['numero_vuelo_entrada'] = $_POST['numero_vuelo_entrada'] ?? null;
                $datos['origen_vuelo_entrada'] = $_POST['origen_vuelo_entrada'] ?? null;
            }
    
            // HOTEL → AEROPUERTO
            if ($tipo == 2 || $tipo == 3) {
                $datos['fecha_vuelo_salida'] = $_POST['fecha_vuelo_salida'] ?? null;
                $datos['hora_vuelo_salida'] = $_POST['hora_vuelo_salida'] ?? null;
                $datos['numero_vuelo_salida'] = $_POST['numero_vuelo_salida'] ?? null;
                $datos['hora_recogida']       = $_POST['hora_recogida'] ?? null;
            }
    
            require_once __DIR__ . '/../models/Reserva.php';
            $reservaModel = new Reserva();
    
            $exito = $reservaModel->crearReserva($datos);
    
            if ($exito) {
                header('Location: ?controller=Reserva&action=listar');
            } else {
                echo "<p style='color:red;'>❌ Error al guardar la reserva.</p>";
            }
        } else {
            echo "Acceso no permitido.";
        }
    }    

}
