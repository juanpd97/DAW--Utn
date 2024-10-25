<?php
//require_once './controller/LoginController.php';
require_once __DIR__ . './controller/LoginController.php';
require_once __DIR__ .'./controller/importarCsvController.php';

if (isset($_GET['action'])) {
    $procesar = new Procesar();

    switch ($_GET['action']) {
        case 'logout':
            $procesar->logOut();
            break;

        case 'inicioView':
            $procesar->inicioView();
            break;
        
        case 'importarCsvView':
            $procesar->importarCsvView();
            break;

        case 'importarCsvController':
            $procesar->importarCsvView();

        case 'importarCsv':
            $procesar->importarCsv();
        
        default:
            $procesar->autenticar();
            break;
    }
}

if(isset($_POST['action'])){
    $procesar = new Procesar();

    switch ($_POST['action']) {
        case 'importarCsv':
            $procesar->importarCsv();
    break;
    }
}
Class Procesar{


    public function autenticar(){
        header('Location: ./view/loginView.php');
        exit();
    }

    public function inicioView(){
        header('Location: ./view/inicioView.php');
        exit();
    }

    public function logOut() {
        session_start();  
        session_destroy();  
        header('Location: ./view/loginView.php');  
        exit();
    }

    public function importarCsvView(){
        header('Location: ./view/importarCsvView.php');
        exit();
    }

    public function importarCsv(){
       


        
    }
}
