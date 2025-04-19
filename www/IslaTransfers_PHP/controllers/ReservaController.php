<?php
// controllers/ReservaController.php

require_once __DIR__ . '/../models/Reserva.php';

class ReservaController
{
    private $reservaModel;

    public function __construct()
    {
        // Iniciamos sesión para poder usar $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Instanciamos el modelo de Reserva
        $this->reservaModel = new Reserva();
    }

    /**
     * Muestra la lista de reservas del usuario logueado.
     * Si no está logueado, redirige al formulario de login.
     */
    public function listar()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        $usuarioId    = $_SESSION['usuario_id'];
        $usuarioEmail = $_SESSION['usuario_email'];
        $reservas = $this->reservaModel->obtenerReservasPorUsuario($usuarioId, $usuarioEmail);

        // Vista que muestra las reservas del usuario
        require_once __DIR__ . '/../views/reservas/lista_reservas.php';
    }

    /**
     * (OPCIONAL) Creación de reserva para ADMIN.
     * Muestra el formulario de nueva reserva (admin).
     */
    public function crear()
    {
        // Solo admin puede usar esto, si lo deseas
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        // Mostramos el formulario de nueva reserva para admin
        require_once __DIR__ . '/../views/reservas/form_nueva_reserva.php';
    }

    /**
     * (OPCIONAL) Guarda la reserva como admin.
     * Procesa el formulario de crear() y guarda en la BD.
     */
    public function guardar()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos del formulario
            $datos = [
                'id_usuario'           => $_SESSION['usuario_id'],
                'email_cliente'        => trim($_POST['email_cliente']),
                'localizador'          => uniqid('RES_'),
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
                'numero_vuelo_salida'  => $_POST['numero_vuelo_salida'],
                'hora_recogida'        => $_POST['hora_recogida'],
                'num_viajeros'         => $_POST['num_viajeros'],
                'id_vehiculo'          => $_POST['id_vehiculo']
            ];

            $exito = $this->reservaModel->crearReserva($datos);
            if ($exito) {
                echo "<p style='color:green;'>Reserva creada correctamente (admin).</p>";
                header('Location: ?controller=Admin&action=listarTodas');
            } else {
                echo "<p style='color:red;'>Error al crear la reserva (admin).</p>";
            }
        } else {
            echo "Método no permitido.";
        }
    }

    /**
     * Mostrar formulario para que un USUARIO PARTICULAR cree su reserva.
     * Aplica la restricción de 48h al GUARDAR, no aquí.
     */
    public function crearParticular()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'particular') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        // Mostrar un formulario distinto para particulares (si quieres):
        require_once __DIR__ . '/../views/reservas/form_nueva_reserva_particular.php';
    }

    /**
     * Guarda la reserva de un usuario particular (con restricción 48h).
     */
    public function guardarParticular()
{
    if (session_status() === PHP_SESSION_NONE) session_start();
    if ($_SESSION['usuario_rol'] !== 'particular') {
        $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
        header('Location: index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '❌ Método no permitido.'];
        header('Location: ?controller=Reserva&action=crearParticular');
        exit();
    }

    /* 1. Validación de 48 h */
    $fechaEntrada = $_POST['fecha_entrada'] ?? null;
    $horaEntrada  = $_POST['hora_entrada'] ?? null;
    if ($fechaEntrada && $horaEntrada) {
        $trayectoDT = new DateTime("$fechaEntrada $horaEntrada");
        if ($trayectoDT < (new DateTime())->add(new DateInterval('P2D'))) {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⏰ No puedes reservar con menos de 48 h.'];
            header('Location: ?controller=Reserva&action=crearParticular');
            exit();
        }
    }

    /* 2. Insertar */
    require_once __DIR__.'/../helpers/EmailHelper.php';
    $datos = [
        'id_usuario'           => $_SESSION['usuario_id'],
        'email_cliente'        => $_SESSION['usuario_email'],
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
        'fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida'] ?? null,
        'hora_vuelo_salida'    => $_POST['hora_vuelo_salida'] ?? null,
        'numero_vuelo_salida'  => $_POST['numero_vuelo_salida'] ?? null,
        'hora_recogida'        => $_POST['hora_recogida'] ?? null,
        'num_viajeros'         => $_POST['num_viajeros'],
        'id_vehiculo'          => $_POST['id_vehiculo'],
        'creado_por'           => 'usuario'
    ];

    if ($this->reservaModel->crearReserva($datos)) {
        /* ─── Enviar e‑mail ─── */
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
        /* ───────────────────── */
        
        // Redirigir con mensaje de éxito
        $_SESSION['popup'] = ['tipo' => 'success', 'texto' => '✅ Reserva creada correctamente.'];
        header('Location: ?controller=Reserva&action=listar');
        exit();
    }

    // En caso de error al guardar
    $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '❌ Error al crear la reserva.'];
    header('Location: ?controller=Reserva&action=crearCorporativo');
    exit();
}


    /**
     * Editar reserva como particular, respetando la restricción de 48h.
     * Muestra el formulario de edición sólo si faltan +48h para el trayecto.
     */
    public function editarParticular()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'particular') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        // ID de la reserva
        $id_reserva = $_GET['id'] ?? null;
        if (!$id_reserva) {
            echo "ID de reserva no especificado.";
            return;
        }

        // Obtenemos la reserva
        $reserva = $this->reservaModel->obtenerReserva($id_reserva);
        if (!$reserva) {
            echo "No se encontró la reserva.";
            return;
        }

        // Verificar que la reserva pertenezca al usuario logueado (opcional, por seguridad)
        if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['popup'] = [
                'tipo' => 'error',
                'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
            ];
            header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
            exit();
        }

        // Comprobamos cuántas horas faltan para la fecha/hora del trayecto principal
        $fechaEntrada = $reserva['fecha_entrada'];
        $horaEntrada  = $reserva['hora_entrada'];
        $reservaDateTime = new DateTime("$fechaEntrada $horaEntrada");

        $now = new DateTime();
        $nowPlus48 = (clone $now)->add(new DateInterval("P2D"));
        if ($reservaDateTime < $nowPlus48) {
            echo "<p style='color:red;'>No puedes modificar la reserva con menos de 48 horas de antelación.</p>";
            return;
        }

        // Mostramos la vista (formulario) para editar la reserva
        require_once __DIR__ . '/../views/reservas/form_editar_reserva_particular.php';
    }

    /**
     * Procesa el formulario de editarParticular y guarda cambios si faltan +48h.
     */
    public function actualizarParticular()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'particular') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reserva = $_POST['id_reserva'] ?? null;
            if (!$id_reserva) {
                echo "Falta ID de la reserva.";
                return;
            }

            $reserva = $this->reservaModel->obtenerReserva($id_reserva);
            if (!$reserva) {
                echo "La reserva no existe.";
                return;
            }

            // Verificar que sea del usuario
            if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
                $_SESSION['popup'] = [
                    'tipo' => 'error',
                    'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
                ];
                header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
                exit();
            }

            // Verificamos las 48h
            $fechaEntrada = $reserva['fecha_entrada'];
            $horaEntrada  = $reserva['hora_entrada'];
            $reservaDateTime = new DateTime("$fechaEntrada $horaEntrada");
            $now = new DateTime();
            if ($reservaDateTime < (clone $now)->add(new DateInterval("P2D"))) {
                echo "<p style='color:red;'>No puedes modificar la reserva con menos de 48 horas de antelación.</p>";
                return;
            }

            // Preparamos los datos para actualizar
            $datos = [
                ':email_cliente'         => $_POST['email_cliente'],
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

            $exito = $this->reservaModel->actualizarReserva($id_reserva, $datos);
            if ($exito) {
                echo "<p style='color:green;'>Reserva actualizada correctamente.</p>";
                header('Location: ?controller=Reserva&action=listar');
            } else {
                echo "<p style='color:red;'>Error al actualizar la reserva.</p>";
            }
        } else {
            echo "Método no permitido.";
        }
    }

    /**
     * Cancelar (eliminar) la reserva como particular, también con 48h de restricción.
     */
    public function cancelarParticular()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'particular') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        $id_reserva = $_GET['id'] ?? null;
        if (!$id_reserva) {
            echo "Falta ID de la reserva.";
            return;
        }

        $reserva = $this->reservaModel->obtenerReserva($id_reserva);
        if (!$reserva) {
            echo "La reserva no existe.";
            return;
        }

        // Verificar dueño de la reserva
        if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['popup'] = [
                'tipo' => 'error',
                'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
            ];
            header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
            exit();
        }

        // Chequeo 48h
        $reservaDateTime = new DateTime($reserva['fecha_entrada'] . ' ' . $reserva['hora_entrada']);
        $nowPlus48 = (new DateTime())->add(new DateInterval("P2D"));
        if ($reservaDateTime < $nowPlus48) {
            echo "<p style='color:red;'>No puedes cancelar la reserva con menos de 48 horas de antelación.</p>";
            return;
        }

        // Eliminar
        $exito = $this->reservaModel->eliminarReserva($id_reserva);
        if ($exito) {
            echo "<p style='color:green;'>Reserva cancelada correctamente.</p>";
            header('Location: ?controller=Reserva&action=listar');
        } else {
            echo "<p style='color:red;'>Error al cancelar la reserva.</p>";
        }
    }


    /**
     * Mostrar formulario para que un USUARIO CORPORATIVO cree su reserva.
     * Aplica la restricción de 48h al GUARDAR, no aquí.
     */
    public function crearCorporativo()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'corporativo') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        // Mostrar un formulario distinto para particulares (si quieres):
        require_once __DIR__ . '/../views/reservas/form_nueva_reserva_corporativo.php';
    }

    /**
     * Guarda la reserva de un usuario particular (con restricción 48h).
     */
    public function guardarCorporativo()
{
    if (session_status() === PHP_SESSION_NONE) session_start();
    if ($_SESSION['usuario_rol'] !== 'corporativo') {
        $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
        header('Location: index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '❌ Método no permitido.'];
        header('Location: ?controller=Reserva&action=crearCorporativo');
        exit();
    }

    /* 1. Validación de 48 h */
    $fechaEntrada = $_POST['fecha_entrada'] ?? null;
    $horaEntrada  = $_POST['hora_entrada'] ?? null;
    if ($fechaEntrada && $horaEntrada) {
        $trayectoDT = new DateTime("$fechaEntrada $horaEntrada");
        if ($trayectoDT < (new DateTime())->add(new DateInterval('P2D'))) {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⏰ No puedes reservar con menos de 48 h.'];
            header('Location: ?controller=Reserva&action=crearCorporativo');
            exit();
        }
    }

    /* 2. Insertar */
    require_once __DIR__.'/../helpers/EmailHelper.php';
    $datos = [
        'id_usuario'           => $_SESSION['usuario_id'],
        'email_cliente'        => $_SESSION['usuario_email'],
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
        'fecha_vuelo_salida'   => $_POST['fecha_vuelo_salida'] ?? null,
        'hora_vuelo_salida'    => $_POST['hora_vuelo_salida'] ?? null,
        'numero_vuelo_salida'  => $_POST['numero_vuelo_salida'] ?? null,
        'hora_recogida'        => $_POST['hora_recogida'] ?? null,
        'num_viajeros'         => $_POST['num_viajeros'],
        'id_vehiculo'          => $_POST['id_vehiculo'],
        'creado_por'           => 'usuario'
    ];

    if ($this->reservaModel->crearReserva($datos)) {
        /* ─── Enviar e‑mail ─── */
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
        /* ───────────────────── */
        
        // Redirigir con mensaje de éxito
        $_SESSION['popup'] = ['tipo' => 'success', 'texto' => '✅ Reserva creada correctamente.'];
        header('Location: ?controller=Reserva&action=listar');
        exit();
    }

    // En caso de error al guardar
    $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '❌ Error al crear la reserva.'];
    header('Location: ?controller=Reserva&action=crearCorporativo');
    exit();
}

    /**
     * Editar reserva como particular, respetando la restricción de 48h.
     * Muestra el formulario de edición sólo si faltan +48h para el trayecto.
     */
    public function editarCorporativo()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'corporativo') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        // ID de la reserva
        $id_reserva = $_GET['id'] ?? null;
        if (!$id_reserva) {
            echo "ID de reserva no especificado.";
            return;
        }

        // Obtenemos la reserva
        $reserva = $this->reservaModel->obtenerReserva($id_reserva);
        if (!$reserva) {
            echo "No se encontró la reserva.";
            return;
        }

        // Verificar que la reserva pertenezca al usuario logueado (opcional, por seguridad)
        if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['popup'] = [
                'tipo' => 'error',
                'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
            ];
            header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
            exit();
        }

        // Comprobamos cuántas horas faltan para la fecha/hora del trayecto principal
        $fechaEntrada = $reserva['fecha_entrada'];
        $horaEntrada  = $reserva['hora_entrada'];
        $reservaDateTime = new DateTime("$fechaEntrada $horaEntrada");

        $now = new DateTime();
        $nowPlus48 = (clone $now)->add(new DateInterval("P2D"));
        if ($reservaDateTime < $nowPlus48) {
            echo "<p style='color:red;'>No puedes modificar la reserva con menos de 48 horas de antelación.</p>";
            return;
        }

        // Mostramos la vista (formulario) para editar la reserva
        require_once __DIR__ . '/../views/reservas/form_editar_reserva_corporativo.php';
    }

    /**
     * Procesa el formulario de editarParticular y guarda cambios si faltan +48h.
     */
    public function actualizarCorporativo()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'corporativo') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reserva = $_POST['id_reserva'] ?? null;
            if (!$id_reserva) {
                echo "Falta ID de la reserva.";
                return;
            }

            $reserva = $this->reservaModel->obtenerReserva($id_reserva);
            if (!$reserva) {
                echo "La reserva no existe.";
                return;
            }

            // Verificar que sea del usuario
            if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
                $_SESSION['popup'] = [
                    'tipo' => 'error',
                    'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
                ];
                header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
                exit();
            }

            // Verificamos las 48h
            $fechaEntrada = $reserva['fecha_entrada'];
            $horaEntrada  = $reserva['hora_entrada'];
            $reservaDateTime = new DateTime("$fechaEntrada $horaEntrada");
            $now = new DateTime();
            if ($reservaDateTime < (clone $now)->add(new DateInterval("P2D"))) {
                echo "<p style='color:red;'>No puedes modificar la reserva con menos de 48 horas de antelación.</p>";
                return;
            }

            // Preparamos los datos para actualizar
            $datos = [
                ':email_cliente'         => $_POST['email_cliente'],
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

            $exito = $this->reservaModel->actualizarReserva($id_reserva, $datos);
            if ($exito) {
                echo "<p style='color:green;'>Reserva actualizada correctamente.</p>";
                header('Location: ?controller=Reserva&action=listar');
            } else {
                echo "<p style='color:red;'>Error al actualizar la reserva.</p>";
            }
        } else {
            echo "Método no permitido.";
        }
    }

    /**
     * Cancelar (eliminar) la reserva como particular, también con 48h de restricción.
     */
    public function cancelarCorporativo()
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'corporativo') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        $id_reserva = $_GET['id'] ?? null;
        if (!$id_reserva) {
            echo "Falta ID de la reserva.";
            return;
        }

        $reserva = $this->reservaModel->obtenerReserva($id_reserva);
        if (!$reserva) {
            echo "La reserva no existe.";
            return;
        }

        // Verificar dueño de la reserva
        if ((int)$reserva['id_usuario'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['popup'] = [
                'tipo' => 'error',
                'texto' => '⛔ No tienes permisos para cancelar esta reserva.'
            ];
            header('Location: index.php'); // o a otra vista que tenga lógica para mostrar el popup
            exit();
        }

        // Chequeo 48h
        $reservaDateTime = new DateTime($reserva['fecha_entrada'] . ' ' . $reserva['hora_entrada']);
        $nowPlus48 = (new DateTime())->add(new DateInterval("P2D"));
        if ($reservaDateTime < $nowPlus48) {
            echo "<p style='color:red;'>No puedes cancelar la reserva con menos de 48 horas de antelación.</p>";
            return;
        }

        // Eliminar
        $exito = $this->reservaModel->eliminarReserva($id_reserva);
        if ($exito) {
            echo "<p style='color:green;'>Reserva cancelada correctamente.</p>";
            header('Location: ?controller=Reserva&action=listar');
        } else {
            echo "<p style='color:red;'>Error al cancelar la reserva.</p>";
        }
    }

    /*  Muestra el detalle de una reserva  */
public function detalle()
{
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ?controller=Login&action=showLoginForm'); exit();
    }

    /* id de la reserva en la URL  ?controller=Reserva&action=detalle&id=NN */
    $id = $_GET['id'] ?? null;
    if (!$id) { echo "Falta el id de la reserva"; return; }

    require_once __DIR__.'/../models/Reserva.php';
    $reservaModel = new Reserva();
    $reserva      = $reservaModel->obtenerReserva($id);

    if (!$reserva) { echo "No se encontró la reserva"; return; }

    /* ---- control de acceso ----
       El admin puede ver cualquiera;
       el particular sólo las que son suyas o su email_cliente           */
    $soyAdmin  = $_SESSION['usuario_rol'] === 'admin';
    $soyDueño  = $reserva['id_usuario'] == $_SESSION['usuario_id'];
    $mismoMail = $reserva['email_cliente'] == $_SESSION['usuario_email'];

    if (!$soyAdmin && !$soyDueño && !$mismoMail) {
        echo "⛔ No tienes permiso para ver esta reserva";
        return;
    }

    /* Pasamos $reserva a la vista */
    require __DIR__.'/../views/reservas/detalle_reserva.php';
}
}
