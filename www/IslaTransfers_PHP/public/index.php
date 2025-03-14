<?php
/**
 * Archivo: public/index.php
 * Descripción:
 *  - Punto de entrada de la aplicación Isla Transfers.
 *  - Implementa un mini router que interpreta los parámetros ?controller=...&action=...
 *  - Si no se pasan esos parámetros, muestra la página de inicio por defecto.
 */

session_start(); // Iniciamos la sesión de forma centralizada

// Comprobamos si vienen ?controller=XYZ & ?action=XYZ
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controllerName = $_GET['controller'] . 'Controller';  // p.ej. "LoginController"
    $actionName     = $_GET['action'];                     // p.ej. "showLoginForm"

    // Archivo donde debería estar la clase Controladora
    $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        if (class_exists($controllerName)) {
            $controllerObject = new $controllerName();

            if (method_exists($controllerObject, $actionName)) {
                // Invocamos el método
                $controllerObject->$actionName();
                exit(); // Detenemos aquí para no cargar la página de inicio
            } else {
                echo "Error: Método <b>$actionName</b> no existe en el controlador <b>$controllerName</b>.";
                exit();
            }
        } else {
            echo "Error: Clase <b>$controllerName</b> no encontrada en <b>$controllerFile</b>.";
            exit();
        }
    } else {
        echo "Error: El controlador <b>$controllerFile</b> no existe.";
        exit();
    }
} else {
    // Si NO hay controller/action en la URL, mostramos la página de inicio:

    // Identificamos si el usuario está logueado (ya que se inició la sesión al principio)
    $usuarioLogueado = isset($_SESSION['usuario_id']);
    $rolUsuario      = $_SESSION['usuario_rol'] ?? null;

    // Cabecera
    require_once __DIR__ . '/../views/templates/header.php';
    ?>
    
    <main>
      <section class="presentacion">
        <h2>Bienvenido a Isla Transfers</h2>
        <p>Te ofrecemos traslados cómodos y seguros desde el aeropuerto hasta tu hotel y viceversa.</p>
        <p>Nuestro objetivo es brindarte la mejor experiencia de viaje en la isla.</p>

        <?php if (!$usuarioLogueado): ?>
          <!-- Invitación a iniciar sesión o registrarse si el usuario no está logueado -->
          <a href="?controller=Login&action=showLoginForm" class="boton-cta">Inicia Sesión</a>
          <a href="?controller=Login&action=showRegisterForm" class="boton-cta">Regístrate</a>
        <?php else: ?>
          <!-- Invitación a hacer una reserva si el usuario ya está logueado -->
          <a href="?controller=Reserva&action=crear" class="boton-cta">Reservar Ahora</a>
        <?php endif; ?>
      </section>

      <section class="info-destacada">
        <h3>¿Por qué elegirnos?</h3>
        <ul>
          <li>Flota de vehículos moderna</li>
          <li>Conductores profesionales</li>
          <li>Reservas fáciles y rápidas</li>
          <li>Servicio 24/7</li>
        </ul>
      </section>
    </main>

    <?php
    // Pie de página
    require_once __DIR__ . '/../views/templates/footer.php';
}
