<?php
    require_once '../Procesar.php';
    $procesar = new Procesar();
    
    session_start();

    if (!isset($_SESSION['autenticacionOk']) || $_SESSION['autenticacionOk'] !== true) {
    header("Location: ./login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        body {
            padding-top: 60px; /* Para evitar que el contenido quede debajo del navbar */
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: white;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación (Header) -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Procesar.php?action=inicio">Trabajo Practico 1</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../Procesar.php?action=importarCsv">Importar CSV</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../Procesar.php?action=logout">Cerrar Sesión</a>
                       <!-- <a class="nav-link" href="../controller/LogOutController.php">Cerrar Sesión</a>-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <!------------------- Contenido Principal ------------>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Aquí se agregará el contenido dinámico de cada página -->
                <h1>importar</h1>
                <p>Funca (? -_-</p>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
