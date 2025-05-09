<?php
// controllers/AdminController.php

require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__.'/../helpers/EmailHelper.php';

class AdminController {
    public function dashboard() {
        // Solo admins
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function guardar()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    /* Solo POST */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['popup'] = ['tipo'=>'error','texto'=>'⛔ Acceso no válido.'];
        header('Location: index.php'); exit();
    }

    /* 1. Validación mínima */
    $campos = [
        'email_cliente','id_hotel','id_tipo_reserva','id_destino',
        'fecha_entrada','hora_entrada','num_viajeros','id_vehiculo'
    ];
    foreach ($campos as $c) {
        if (empty($_POST[$c])) {
            echo "<p style='color:red;'>Falta el campo $c</p>"; return;
        }
    }

    /* 2. Obtener id_usuario real según email_cliente */
    require_once __DIR__.'/../models/Usuario.php';
    $usuarioModel = new Usuario();
    $cli = $usuarioModel->buscarPorEmail(trim($_POST['email_cliente']));
    $clienteId = $cli ? $cli['id_usuario'] : null;   // puede ser null

    /* 3. Construir datos y crear reserva */
    require_once __DIR__.'/../models/Reserva.php';
    require_once __DIR__.'/../helpers/EmailHelper.php';

    $reservaModel = new Reserva();
    $datos = [
        'id_usuario'           => $clienteId,
        'email_cliente'        => trim($_POST['email_cliente']),
        'localizador'          => uniqid('RES_'),
        'id_hotel'             => $_POST['id_hotel'],
        'id_tipo_reserva'      => $_POST['id_tipo_reserva'],
        'fecha_reserva'        => date('Y-m-d H:i:s'),
        'fecha_modificacion'   => date('Y-m-d H:i:s'),
        'id_destino'           => $_POST['id_destino'],
        'fecha_entrada'        => $_POST['fecha_entrada'],
        'hora_entrada'         => $_POST['hora_entrada'],
        'numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'] ?? null,
        'origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'] ?? null,
        'fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida']   ?? null,
        'hora_vuelo_salida'    => $_POST['hora_vuelo_salida']    ?? null,
        'numero_vuelo_salida'  => $_POST['numero_vuelo_salida']  ?? null,
        'hora_recogida'        => $_POST['hora_recogida']        ?? null,
        'num_viajeros'         => $_POST['num_viajeros'],
        'id_vehiculo'          => $_POST['id_vehiculo'],
        'creado_por'           => 'admin'
    ];

    if ($reservaModel->crearReserva($datos)) {

        /* ─── Enviar e‑mail de confirmación ─── */
        $body = "
          <h3>Confirmación de reserva</h3>
          Localizador: {$datos['localizador']}<br>
          Hotel: {$datos['id_hotel']}<br>
          Fecha entrada: {$datos['fecha_entrada']} {$datos['hora_entrada']}<br>
          Número de viajeros: {$datos['num_viajeros']}
        ";
        enviarConfirmacion(
            $datos['email_cliente'],
            "Reserva Isla Transfers {$datos['localizador']}",
            $body
        );
        /* ───────────────────────────────────── */

        $_SESSION['popup'] = ['tipo'=>'success','texto'=>'✅ Reserva creada.'];
        header('Location: ?controller=Admin&action=dashboard'); exit();
    }

    $_SESSION['popup'] = ['tipo'=>'error','texto'=>'❌ No se pudo crear.'];
    header('Location: ?controller=Reserva&action=crear'); exit();
}


    public function listarTodas() {
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        $reservaModel = new Reserva();
        $reservas = $reservaModel->obtenerTodasLasReservas();

        // Mostramos la vista
        require_once __DIR__ . '/../views/admin/lista_reservas_admin.php';
    }

    public function editar() {
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        if (!isset($_GET['id'])) {
            echo "Error: Falta el id de la reserva";
            return;
        }

        $id_reserva = $_GET['id'];
        $reservaModel = new Reserva();
        $reserva = $reservaModel->obtenerReserva($id_reserva);

        if (!$reserva) {
            echo "No se encontró la reserva con ID: $id_reserva";
            return;
        }

        // Mostramos el formulario de edición
        require_once __DIR__ . '/../views/admin/form_editar_reserva.php';
    }

    public function actualizar() {
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reserva = $_POST['id_reserva'] ?? null;
            if (!$id_reserva) {
                echo "Error: Falta el id de la reserva.";
                return;
            }

            // Preparamos array con binds
            $datos = [
                ':email_cliente'         => trim($_POST['email_cliente']),
                ':id_hotel'             => $_POST['id_hotel'],
                ':id_tipo_reserva'      => $_POST['id_tipo_reserva'],
                ':fecha_modificacion'   => date('Y-m-d H:i:s'),
                ':id_destino'           => $_POST['id_destino'],
                ':fecha_entrada'        => $_POST['fecha_entrada'],
                ':hora_entrada'         => $_POST['hora_entrada'],
                ':numero_vuelo_entrada' => $_POST['numero_vuelo_entrada'],
                ':origen_vuelo_entrada' => $_POST['origen_vuelo_entrada'],
                ':fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida'],
                ':hora_vuelo_salida'    => $_POST['hora_vuelo_salida'],
                ':numero_vuelo_salida'  => $_POST['numero_vuelo_salida'],
                ':hora_recogida'        => $_POST['hora_recogida'],
                ':num_viajeros'         => $_POST['num_viajeros'],
                ':id_vehiculo'          => $_POST['id_vehiculo']
            ];

            $reservaModel = new Reserva();
            $exito = $reservaModel->actualizarReserva($id_reserva, $datos);

            if ($exito) {
                // Redirigimos a la lista
                header('Location: ?controller=Admin&action=listarTodas');
            } else {
                echo "Error al actualizar la reserva.";
            }
        } else {
            echo "Acceso inválido.";
        }
    }

    public function eliminar() {
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        if (!isset($_GET['id'])) {
            echo "Error: Falta el id de la reserva.";
            return;
        }

        $id_reserva = $_GET['id'];

        $reservaModel = new Reserva();
        $exito = $reservaModel->eliminarReserva($id_reserva);

        if ($exito) {
            header('Location: ?controller=Admin&action=listarTodas');
        } else {
            echo "Error al eliminar la reserva.";
        }
    }

    public function verCalendario() {
        // Ejemplo de filtrado por día, semana o mes
        // Podríamos usar ?controller=Admin&action=verCalendario&vista=semanal, etc.
        // O integrarlo con librerías como FullCalendar
        if (!$this->isAdmin()) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }
        require_once __DIR__ . '/../views/admin/calendario.php';
    }

    private function isAdmin() {
        // Sencillo helper
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
    }

    public function show($id)
    {
        $reserva = TransferReserva::with(['hotel', 'vehiculo', 'viajeros', 'tipo'])
            ->where('id_reserva', $id)
            ->firstOrFail();

        return view('admin.reservas.show', compact('reserva'));
    }

    public function calendarEvents() {
        if (!$this->isAdmin()) {
            // O devuelves un JSON vacío
            echo json_encode([]);
            return;
        }
    
        header('Content-Type: application/json; charset=utf-8');
    
        $reservaModel = new Reserva();
        $reservas = $reservaModel->obtenerTodasLasReservas();
    
        // Convertimos $reservas en un array de objetos FullCalendar
        // FullCalendar espera 'title', 'start', 'end', 'id', etc.
        $eventos = [];
        foreach ($reservas as $r) {
            // Por ejemplo, si consideramos 'fecha_entrada' y 'hora_entrada'
            $start = $r['fecha_entrada'] . 'T' . $r['hora_entrada'];  // Formato YYYY-MM-DDTHH:MM
            // Podríamos usar 'fecha_vuelo_salida' para 'end'
            $end   = $r['fecha_vuelo_salida'] . 'T' . $r['hora_vuelo_salida'];
    
            $eventos[] = [
                'id'    => $r['id_reserva'],
                'title' => 'Reserva ' . $r['localizador'],
                'start' => $start,
                'end'   => $end
            ];
        }
    
        echo json_encode($eventos);
    }
    
}


