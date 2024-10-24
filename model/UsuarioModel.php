<?php
//require_once './Database.php';
require_once __DIR__ . './Database.php';
class UsuarioModel {

    public function __construct() {}

    public function verificarUsuario($usuarioIngresado, $contrasenaIngresada) {

        $db = new Database;
        $conexion = $db->getConnection();

        $query = "SELECT * FROM Usuario WHERE usuario = :usuario";
        $buscarUsuario = $conexion->prepare($query);
        $buscarUsuario->bindParam(':usuario', $usuarioIngresado);
        $buscarUsuario->execute();
    
        $usuario = $buscarUsuario->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
           if ($usuario['usuario'] == $usuarioIngresado && $usuario["contrasena"] == $contrasenaIngresada) {
                return true; 
            }
        }

        return false;
    }
}