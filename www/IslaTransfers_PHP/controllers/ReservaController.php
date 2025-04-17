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

        $usuarioId = $_SESSION['usuario_id'];
        $reservas = $this->reservaModel->obtenerReservasPorUsuario($usuarioId);

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
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'particular') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Supongamos que, para particular, el trayecto principal es fecha_entrada+hora_entrada
            $fechaEntrada = $_POST['fecha_entrada'] ?? null;
            $horaEntrada  = $_POST['hora_entrada']  ?? null;
            if ($fechaEntrada && $horaEntrada) {
                $trayectoDateTime = new DateTime("$fechaEntrada $horaEntrada");
                $ahora = new DateTime();
                // Sumamos 48h a la fecha/hora actual
                $ahoraMas48 = (clone $ahora)->add(new DateInterval('P2D'));

                if ($trayectoDateTime < $ahoraMas48) {
                    echo "<p style='color:red;'>No puedes reservar con menos de 48 horas de antelación.</p>";
                    return;
                }
            }
            // O si es “hotel→aeropuerto”, chequear $_POST['fecha_vuelo_salida'] y $_POST['hora_vuelo_salida']
            // O si es ida y vuelta, chequear ambos.

            // Si pasa la validación 48h, guardamos
            $datos = [
                'id_usuario'           => $_SESSION['usuario_id'],
                'email_cliente'        => $_SESSION['usuario_email'],  // O $_POST, si lo pides
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
                echo "<p style='color:green;'>Reserva creada correctamente.</p>";
                // Redirigir a la lista de reservas del usuario
                header('Location: ?controller=Reserva&action=listar');
            } else {
                echo "<p style='color:red;'>Error al crear la reserva.</p>";
            }
        } else {
            echo "Método no permitido.";
        }
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
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'corporativo') {
            $_SESSION['popup'] = ['tipo' => 'error', 'texto' => '⛔ Acceso no autorizado.'];
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Supongamos que, para particular, el trayecto principal es fecha_entrada+hora_entrada
            $fechaEntrada = $_POST['fecha_entrada'] ?? null;
            $horaEntrada  = $_POST['hora_entrada']  ?? null;
            if ($fechaEntrada && $horaEntrada) {
                $trayectoDateTime = new DateTime("$fechaEntrada $horaEntrada");
                $ahora = new DateTime();
                // Sumamos 48h a la fecha/hora actual
                $ahoraMas48 = (clone $ahora)->add(new DateInterval('P2D'));

                if ($trayectoDateTime < $ahoraMas48) {
                    echo "<p style='color:red;'>No puedes reservar con menos de 48 horas de antelación.</p>";
                    return;
                }
            }
            // O si es “hotel→aeropuerto”, chequear $_POST['fecha_vuelo_salida'] y $_POST['hora_vuelo_salida']
            // O si es ida y vuelta, chequear ambos.

            // Si pasa la validación 48h, guardamos
            $datos = [
                'id_usuario'           => $_SESSION['usuario_id'],
                'email_cliente'        => $_SESSION['usuario_email'],  // O $_POST, si lo pides
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
                echo "<p style='color:green;'>Reserva creada correctamente.</p>";
                // Redirigir a la lista de reservas del usuario
                header('Location: ?controller=Reserva&action=listar');
            } else {
                echo "<p style='color:red;'>Error al crear la reserva.</p>";
            }
        } else {
            echo "Método no permitido.";
        }
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
}
