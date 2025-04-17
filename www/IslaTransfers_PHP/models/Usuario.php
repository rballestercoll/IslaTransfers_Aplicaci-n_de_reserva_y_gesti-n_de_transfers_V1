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

    public function actualizarUsuario($id, $nombre, $email, $password = null)
{
    try {
        $sql  = "UPDATE usuarios SET nombre = :nombre, email = :email";
        if ($password !== null) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id_usuario = :id";
        $stmt = $this->conexion->prepare($sql);

        $params = [
            ':nombre' => $nombre,
            ':email'  => $email,
            ':id'     => $id
        ];
        if ($password !== null) {
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        return $stmt->execute($params);
    } catch (PDOException $e) {
        return false;
    }
}
    public function eliminarUsuario($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarUsuarios() {
        try {
            $sql = "SELECT * FROM usuarios";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
