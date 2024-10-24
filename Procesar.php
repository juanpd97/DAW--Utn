<?php
//require_once './controller/LoginController.php';
require_once __DIR__ . './controller/LoginController.php';

if (isset($_GET['action'])) {
    $procesar = new Procesar();

    switch ($_GET['action']) {
        case 'logout':
            $procesar->logOut();
            break;

        case 'inicio':
            $procesar->inicioView();
            break;
        
        case 'importarCsv':
            $procesar->importarView();
            break;

        default:
            $procesar->autenticar();
            break;
    }
}
Class Procesar{


    public function autenticar(){
        header('Location: ./view/login.php');
        exit();
    }

    public function inicioView(){
        header('Location: ./view/inicio.php');
        exit();
    }

    public function logOut() {
        session_start();  
        session_destroy();  
        header('Location: ./view/login.php');  
        exit();
    }

    public function importarView(){
        header('Location: ./view/importarCsv.php');
        exit();
    }


}
