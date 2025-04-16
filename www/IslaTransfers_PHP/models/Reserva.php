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
                ':numero_vuelo_salida'  => $datos['numero_vuelo_salida'] ?? null,
                ':hora_recogida'        => $datos['hora_recogida'] ?? null,
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

        // NUEVO: Lista todas las reservas sin filtrar (para admin)
    public function obtenerTodasLasReservas() {
        try {
            $sql = "SELECT * FROM transfer_reservas ORDER BY fecha_reserva DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error al obtener reservas: " . $e->getMessage();
            return [];
        }
    }

    // NUEVO: Obtiene una reserva específica para edición
    public function obtenerReserva($id_reserva) {
        try {
            $sql = "SELECT * FROM transfer_reservas WHERE id_reserva = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id_reserva]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error al obtener la reserva: " . $e->getMessage();
            return false;
        }
    }

    // NUEVO: Actualizar reserva
    public function actualizarReserva($id_reserva, $datos) {
        try {
            $sql = "UPDATE transfer_reservas
                    SET 
                        email_cliente        = :email_cliente,
                        id_hotel            = :id_hotel,
                        id_tipo_reserva     = :id_tipo_reserva,
                        fecha_modificacion  = :fecha_modificacion,
                        id_destino          = :id_destino,
                        fecha_entrada       = :fecha_entrada,
                        hora_entrada        = :hora_entrada,
                        numero_vuelo_entrada= :numero_vuelo_entrada,
                        origen_vuelo_entrada= :origen_vuelo_entrada,
                        fecha_vuelo_salida  = :fecha_vuelo_salida,
                        hora_vuelo_salida   = :hora_vuelo_salida,
                        numero_vuelo_salida = :numero_vuelo_salida,
                        hora_recogida       = :hora_recogida,
                        num_viajeros        = :num_viajeros,
                        id_vehiculo         = :id_vehiculo
                    WHERE id_reserva = :id_reserva";

            $stmt = $this->db->prepare($sql);
            $datos[':id_reserva'] = $id_reserva;
            return $stmt->execute($datos);

        } catch (PDOException $e) {
            echo "Error al actualizar la reserva: " . $e->getMessage();
            return false;
        }
    }

    // NUEVO: Eliminar reserva
    public function eliminarReserva($id_reserva) {
        try {
            $sql = "DELETE FROM transfer_reservas WHERE id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id_reserva' => $id_reserva]);
        } catch (PDOException $e) {
            echo "Error al eliminar la reserva: " . $e->getMessage();
            return false;
        }
    }

}
