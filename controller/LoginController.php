<?php
    //require_once '../model/Usuario.php';
    // En LoginController.php
    require_once __DIR__ . '/../model/UsuarioModel.php';
    
class LoginController {
    public function __construct() {
    }


    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuarioIngresado = $_POST['inpNombreUsuario'];
            $contrasenaIngresada = $_POST['inpContrasenaUsuario'];

            $usuario = new UsuarioModel();
            $usuarioAutenticado = $usuario->verificarUsuario($usuarioIngresado, $contrasenaIngresada);
            
            if ($usuarioAutenticado) {
                session_start();
                $_SESSION['usuario'] = $usuarioIngresado;
                $_SESSION['autenticacionOk'] = true;
                header("Location: ../view/inicioView.php"); 
                exit;
            } else {
                echo "<br>";
                echo "<div class='alert alert-info'>Usuario o contraseña incorrecto.</div>";
            }
        }
    }

}