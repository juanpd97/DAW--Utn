<?php
    require_once './Procesar.php';
    session_start();

    $procesar = new Procesar();

    if ($_SESSION["autenticacionOk"] == true){
        $procesar->inicioView();
    } else {
        $procesar->autenticar();
    }

    