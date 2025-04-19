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
      <?php
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
      // Mostrar mensajes tipo popup si existen
      if (isset($_SESSION['popup'])):
          $mensaje = $_SESSION['popup']['texto'];
          $tipo = $_SESSION['popup']['tipo'];
          unset($_SESSION['popup']); // Eliminar el mensaje tras mostrarlo
          ?>
          <script>
              window.onload = function () {
                  alert("<?= addslashes($mensaje) ?>");
              };
          </script>
      <?php endif; ?>

      <section class="presentacion">
        <h2>Bienvenido a Isla Transfers</h2>
        <p>Te ofrecemos traslados cómodos y seguros desde el aeropuerto hasta tu hotel y viceversa.</p>
        <p>Nuestro objetivo es brindarte la mejor experiencia de viaje en la isla.</p>

        <?php if (!$usuarioLogueado): ?>
          <!-- Invitación a iniciar sesión o registrarse si el usuario no está logueado -->
          <a href="?controller=Login&action=showLoginForm" class="boton-cta">Inicia Sesión</a>
          <a href="?controller=Login&action=showRegisterForm" class="boton-cta">Regístrate</a>
        <?php else: ?>
          <!-- Comprobamos el tipo de usuario -->
          <?php if ($_SESSION['usuario_rol'] === 'corporativo'): ?>
            
            <a href="?controller=Reserva&action=crearCorporativo" class="boton-cta">Reservar Ahora</a>
          <?php elseif ($_SESSION['usuario_rol'] === 'particular'): ?>
           
            <a href="?controller=Reserva&action=crearParticular" class="boton-cta">Reservar Ahora</a>
          <?php elseif ($_SESSION['usuario_rol'] === 'admin'): ?>
            
            <a href="?controller=Reserva&action=crear" class="boton-cta">Reservar Ahora</a>
          <?php endif; ?>
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

    <style>
      .presentacion {
    text-align: center;
    margin: 40px 0;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.presentacion h2 {
    font-size: 2rem;
    color: #343a40;
    margin-bottom: 20px;
}

.presentacion p {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Información destacada */
.info-destacada {
    background-color: #007bff;
    color: #fff;
    padding: 30px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin: 40px 0;
}

.info-destacada h3 {
    font-size: 1.8rem;
    margin-bottom: 20px;
}

.info-destacada ul {
    list-style-type: none;
    padding: 0;
}

.info-destacada li {
    font-size: 1.2rem;
    margin: 10px 0;
}

.boton-cta {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 12px 24px;
    margin: 10px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.boton-cta:hover {
    background-color: #0056b3;
}
      </style>
    <?php
    // Pie de página
    require_once __DIR__ . '/../views/templates/footer.php';
}