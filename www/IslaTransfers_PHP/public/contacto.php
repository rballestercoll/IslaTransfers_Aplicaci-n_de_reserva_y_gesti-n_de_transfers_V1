<?php
// Iniciar la sesión para verificar si el usuario está logueado
session_start();

// Verificar si la sesión está activa (es decir, si el usuario está logueado)
$usuarioLogueado = isset($_SESSION['usuario_id']);
$rolUsuario = $_SESSION['usuario_rol'] ?? null; // Obtener rol si está seteado
?>


<!-- views/contacto.php -->
<?php require_once __DIR__ . '/../views/templates/header.php'; ?>
<section class="contacto">
    <h2 class="titulo-contacto">Contacto</h2>
    <p class="descripcion-contacto">Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros:</p>
    
    <form class="form-contacto" action="contacto.php" method="POST">
        <div class="campo-form">
            <label class="etiqueta-form" for="nombre">Nombre:</label>
            <input class="input-form" type="text" id="nombre" name="nombre" required>
        </div>

        <div class="campo-form">
            <label class="etiqueta-form" for="email">Correo Electrónico:</label>
            <input class="input-form" type="email" id="email" name="email" required>
        </div>

        <div class="campo-form">
            <label class="etiqueta-form" for="mensaje">Mensaje:</label>
            <textarea class="textarea-form" id="mensaje" name="mensaje" required></textarea>
        </div>

        <button class="boton-enviar" type="submit">Enviar</button>
    </form>
</section>

<style>
  .titulo-contacto {
    text-align: center;
    font-size: 2rem;
    color: #343a40;
    margin-bottom: 20px;
}

/* Descripción de contacto */
.descripcion-contacto {
  text-align: center;  
  font-size: 1.1rem;
    color: #666;
    margin-bottom: 30px;
}

/* Formulario de contacto */
.form-contacto {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    margin-bottom: 20px;
}

/* Campos del formulario */
.campo-form {
    margin-bottom: 15px;
}

.etiqueta-form {
    display: block;
    font-size: 1.1rem;
    color: #343a40;
    margin-bottom: 8px;
}

.input-form, .textarea-form {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    color: #333;
    margin-bottom: 10px;
}

.textarea-form {
    height: 150px;
}

/* Botón de envío */
.boton-enviar {
    background-color: #007bff;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.boton-enviar:hover {
    background-color: #0056b3;
}
</style>


<?php require_once __DIR__ . '/../views/templates/footer.php'; ?>