<?php
    require_once '../controller/LoginController.php';
    $loginController = new LoginController();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Iniciar Sesión
                    </div>
                    <div class="card-body">
                    <form method="POST">

                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input name="inpNombreUsuario" type="text" class="form-control" id="usuario" aria-describedby="usuarioHelp" required>
                                <div id="usuarioHelp" class="form-text">Ingrese su nombre de usuario.</div>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input name="inpContrasenaUsuario" type="password" class="form-control" id="contrasena" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="btnLogin">Iniciar Sesión</button>
                            <?php
                            $loginController->login();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>