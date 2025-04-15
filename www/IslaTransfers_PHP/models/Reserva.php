<?php

require_once __DIR__ . '/../config/Database.php';

class Reserva {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->connect();
    }

    public function crearReserva($datos) {
        try {
            $sql = "INSERT INTO transfer_reservas (
                id_usuario, email_cliente, localizador, id_hotel, id_tipo_reserva, 
                fecha_reserva, fecha_modificacion, id_destino, 
                fecha_entrada, hora_entrada, numero_vuelo_entrada, 
                origen_vuelo_entrada, hora_vuelo_salida, 
                fecha_vuelo_salida, numero_vuelo_salida, hora_recogida, 
                num_viajeros, id_vehiculo
            ) VALUES (
                :id_usuario, :email_cliente, :localizador, :id_hotel, :id_tipo_reserva, 
                :fecha_reserva, :fecha_modificacion, :id_destino,
                :fecha_entrada, :hora_entrada, :numero_vuelo_entrada,
                :origen_vuelo_entrada, :hora_vuelo_salida,
                :fecha_vuelo_salida, :numero_vuelo_salida, :hora_recogida,
                :num_viajeros, :id_vehiculo
            )";            

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':id_usuario'           => $datos['id_usuario'],
                ':email_cliente'        => $datos['email_cliente'],
                ':localizador'          => $datos['localizador'],
                ':id_hotel'             => $datos['id_hotel'],
                ':id_tipo_reserva'      => $datos['id_tipo_reserva'],
                ':fecha_reserva'        => $datos['fecha_reserva'],
                ':fecha_modificacion'   => $datos['fecha_modificacion'],
                ':id_destino'           => $datos['id_destino'],
                ':fecha_entrada'        => $datos['fecha_entrada'],
                ':hora_entrada'         => $datos['hora_entrada'],
                ':numero_vuelo_entrada' => $datos['numero_vuelo_entrada'],
                ':origen_vuelo_entrada' => $datos['origen_vuelo_entrada'],
                ':hora_vuelo_salida'    => $datos['hora_vuelo_salida'],
                ':fecha_vuelo_salida'   => $datos['fecha_vuelo_salida'],
                ':numero_vuelo_salida'  => $datos['numero_vuelo_salida'],
                ':hora_recogida'        => $datos['hora_recogida'],
                ':num_viajeros'         => $datos['num_viajeros'],
                ':id_vehiculo'          => $datos['id_vehiculo']
            ]);            
        } catch (PDOException $e) {
            echo "<pre style='color:red;'>❌ Error al crear la reserva: " . $e->getMessage() . "</pre>";
            return false;
        }
    }

    public function obtenerReservasPorUsuario($usuarioId) {
        $sql = "SELECT * FROM transfer_reservas WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $usuarioId]);
        return $stmt->fetchAll();
    }

}
