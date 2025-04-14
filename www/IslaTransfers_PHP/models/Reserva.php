<?php

require_once __DIR__ . '/../config/Database.php';

class Reserva {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->connect();
    }

    public function obtenerReservasPorUsuario($usuarioId) {
        $sql = "SELECT * FROM transfer_reservas WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $usuarioId]);
        return $stmt->fetchAll();
    }
}
