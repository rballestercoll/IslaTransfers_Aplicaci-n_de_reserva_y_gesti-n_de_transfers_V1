<?php
// controllers/PerfilController.php

/*  Cargamos el modelo del usuario */
require_once __DIR__ . '/../models/Usuario.php';

class PerfilController
{
    /* Muestra el perfil */
    public function ver()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }
        require __DIR__ . '/../views/usuario/perfil.php';
    }

    /* Procesa la actualización */
    public function actualizar()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=Login&action=showLoginForm');
            exit();
        }

        $idUsuario = $_SESSION['usuario_id'];
        $nombre    = trim($_POST['nombre']    ?? '');
        $email     = trim($_POST['email']     ?? '');
        $password  = trim($_POST['password']  ?? '');

        /* Validación rápida de email */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['popup'] = ['texto' => 'Email no válido', 'tipo' => 'error'];
            header('Location: ?controller=Perfil&action=ver'); exit();
        }

        $usuarioModel = new Usuario();
        $ok = $usuarioModel->actualizarUsuario(
                $idUsuario,
                $nombre,
                $email,
                $password === '' ? null : $password
              );

        if ($ok) {
            $_SESSION['usuario_email']  = $email;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['popup'] = ['texto' => 'Perfil actualizado', 'tipo' => 'success'];
        } else {
            $_SESSION['popup'] = ['texto' => 'Error al actualizar', 'tipo' => 'error'];
        }
        header('Location: ?controller=Perfil&action=ver');
        exit();
    }
}
