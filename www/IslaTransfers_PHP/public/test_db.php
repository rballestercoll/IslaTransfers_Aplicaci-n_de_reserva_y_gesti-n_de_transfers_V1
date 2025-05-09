<?php
/**
 * Archivo: public/test_db.php
 * Descripción:
 *  - Archivo de prueba para verificar la conexión a la base de datos.
 */

require_once __DIR__ . '/../config/Database.php';
// Ajustar la ruta según la ubicación real de Database.php

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "Conexión exitosa con la base de datos!";
} else {
    echo "Error al conectar con la base de datos";
}
