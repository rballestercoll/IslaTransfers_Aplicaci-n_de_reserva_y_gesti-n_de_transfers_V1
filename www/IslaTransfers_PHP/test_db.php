<?php
require_once 'config/Database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "✅ Conexión establecida correctamente con la base de datos.";
} else {
    echo "❌ No se pudo conectar a la base de datos.";
}
