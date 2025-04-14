<?php
// models/Usuario.php

require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function crearUsuario($datos) {
        try {
            $sql = "INSERT INTO usuarios (email, password, nombre, rol)
                    VALUES (:email, :password, :nombre, :rol)";
    
            $stmt = $this->conexion->prepare($sql);
            $hashedPassword = password_hash($datos['password'], PASSWORD_DEFAULT);
    
            $stmt->execute([
                ':email'    => $datos['email'],
                ':password' => $hashedPassword,
                ':nombre'   => $datos['nombre'] ?? '',
                ':rol'      => $datos['rol'] ?? 'particular'
            ]);
    
            return true;
    
        } catch (PDOException $e) {
            echo "<pre style='color:red;'>❌ Error al crear usuario: " . $e->getMessage() . "</pre>";
            return false;
        }        
    }
    

    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(); // Devuelve array asociativo o false
            return $usuario ?: false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
