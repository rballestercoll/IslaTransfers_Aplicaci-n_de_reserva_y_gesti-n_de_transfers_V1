<?php
// controllers/LoginController.php

require_once __DIR__ . '/../models/Usuario.php';

class LoginController {

    public function showLoginForm() {
        // Muestra el formulario de login
        require_once __DIR__ . '/../views/login/form_login.php';
    }

    public function processLogin() {
        // Reanudamos la sesión, por si no está
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['email'], $_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                // Credenciales correctas
                $_SESSION['usuario_id']    = $usuario['id_usuario'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol']   = $usuario['rol'];

                // Redirigir según rol
                if ($usuario['rol'] === 'admin') {
                    header('Location: ?controller=Admin&action=dashboard');
                } else {
                    header('Location: ?controller=Reserva&action=listar');
                }
                exit();
            } else {
                $_SESSION['error_login'] = "Email o contraseña incorrectos.";
            }
        } else {
            $_SESSION['error_login'] = "Debes ingresar email y contraseña.";
        }
        header('Location: ?controller=Login&action=showLoginForm');
        exit();
    }

    public function showRegisterForm() {
        require_once __DIR__ . '/../views/login/form_register.php';
    }

    public function processRegister() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email    = trim($_POST['email']);
            $password = $_POST['password'];
            $nombre   = trim($_POST['nombre'] ?? '');
            $rol      = 'particular'; // Rol por defecto

            $usuarioModel = new Usuario();
            if ($usuarioModel->buscarPorEmail($email)) {
                $_SESSION['error_registro'] = "El email ya está en uso. Prueba con otro.";
                header('Location: ?controller=Login&action=showRegisterForm');
                exit();
            }

            $exito = $usuarioModel->crearUsuario([
                'email'    => $email,
                'password' => $password,
                'nombre'   => $nombre,
                'rol'      => $rol
            ]);

            if ($exito) {
                $_SESSION['mensaje_registro'] = "Registro exitoso. Ya puedes iniciar sesión.";
                header('Location: ?controller=Login&action=showLoginForm');
            } else {
                $_SESSION['error_registro'] = "Ocurrió un problema al registrar. Intenta de nuevo.";
                header('Location: ?controller=Login&action=showRegisterForm');
            }
        } else {
            $_SESSION['error_registro'] = "Debes llenar al menos Email y Contraseña.";
            header('Location: ?controller=Login&action=showRegisterForm');
        }
        exit();
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ?controller=Login&action=showLoginForm');
        exit();
    }
    
}
