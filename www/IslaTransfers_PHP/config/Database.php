<?php
// config/Database.php

define('DB_HOST', 'localhost');           // Servidor local
define('DB_NAME', 'isla_transfers');      // Nombre real de la base de datos
define('DB_USER', 'root');                // Usuario local
define('DB_PASS', 'root');                    // Contraseña
define('DB_CHARSET', 'utf8mb4');

class Database {
    private $host    = DB_HOST;
    private $db      = DB_NAME;
    private $user    = DB_USER;
    private $pass    = DB_PASS;
    private $charset = DB_CHARSET;

    private $pdo = null;

    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ];
                $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                die("❌ Error de conexión a la BD: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
