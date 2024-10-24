<?php

require_once './controller/LoginController.php';

Class Procesar{


    public function autenticar(){
        header('Location: ./view/login.php');
        exit();
    }
    public function logOut(){
    session_start();
    $_SESSION = array();
    session_destroy();

    header("Location: ./view/login.php");
    exit();
    }

    public function inicioView(){
        header('Location: ./view/inicio.php');
        exit();
    }
}
