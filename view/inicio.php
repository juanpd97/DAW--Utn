<?php
    session_start();
    if ($_SESSION["autenticacionOk"] == true){
    } else{
        header('Location: ./login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>XDXD Lol</h1>
</body>
</html>