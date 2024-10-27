<?php

require_once __DIR__ . '/../init.php';

class Database {
    private $host;
    private $puerto;
    private $dnNombre;
    private $username;
    private $password;
    
    private $conexion;

    public function __construct() {
        $this->host = DB_HOST;
        $this->puerto = DB_PORT;
        $this->dnNombre = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
    }

    public function getConnection() {
        $this->conexion = null;
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->puerto . ";dbname=" . $this->dnNombre,
                $this->username,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->conexion;
    }
}
