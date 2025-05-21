<?php
// Iniciar la sesión para verificar si el usuario está logueado
session_start();

// Verificar si la sesión está activa (es decir, si el usuario está logueado)
$usuarioLogueado = isset($_SESSION['usuario_id']);
$rolUsuario = $_SESSION['usuario_rol'] ?? null; // Obtener rol si está seteado
?>


<!-- views/servicios.php -->
<?php require_once __DIR__ . '/../views/templates/header.php'; ?>

<section class="servicios">
    <h2 class="titulo-servicios">Servicios</h2>
    <p class="descripcion-servicios">En nuestra empresa ofrecemos los siguientes servicios:</p>
    
    <div class="lista-servicios">
        <div class="servicio-item">
            <span class="servicio-titulo">Transporte Aeropuerto → Hotel:</span>
            <p class="servicio-descripcion">Transporte privado desde el aeropuerto hasta el hotel.</p>
        </div>
        <div class="servicio-item">
            <span class="servicio-titulo">Excursiones Turísticas:</span>
            <p class="servicio-descripcion">Ofrecemos tours guiados por los principales atractivos turísticos de la ciudad.</p>
        </div>
        <div class="servicio-item">
            <span class="servicio-titulo">Alquiler de Vehículos:</span>
            <p class="servicio-descripcion">Rentamos vehículos de diversas categorías para su comodidad durante su estancia.</p>
        </div>
        <div class="servicio-item">
            <span class="servicio-titulo">Servicio de Concierge:</span>
            <p class="servicio-descripcion">Ayuda personalizada para hacer reservas, recomendaciones de restaurantes, y más.</p>
        </div>
    </div>
</section>

<style>
  .titulo-servicios {
    text-align: center;
    font-size: 2rem;
    color: #343a40;
    margin-bottom: 20px;
}

/* Descripción */
.descripcion-servicios {
  text-align: center;
  font-size: 1.1rem;
    color: #666;
    margin-bottom: 30px;
}

/* Lista de servicios */
.lista-servicios {
    padding: 0;
}

.servicio-item {
    background-color: #ffffff;
    margin: 10px 0;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.servicio-item:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
}

/* Enfatizar el texto en cada servicio */
.servicio-titulo {
    font-size: 1.2rem;
    color: #007bff;
    display: block;
    margin-bottom: 10px;
}

.servicio-descripcion {
    font-size: 1rem;
    color: #666;
}
</style>
<?php require_once __DIR__ . '/../views/templates/footer.php'; ?>