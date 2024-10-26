<?php

class Database {
    private $host = "localhost";
    private $puerto = "3307";
    private $dnNombre = "tp";
    private $username = "root";
    private $password = "";
    
    private $conexion;


    public function getConnection() {
        $this->conexion = null;
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host.";port=". $this->puerto . ";dbname=" . $this->dnNombre,
                $this->username,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->conexion;
    }
}