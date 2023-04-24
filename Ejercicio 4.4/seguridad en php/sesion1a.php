<?php
    session_start();
    if(!isset($_SESSION['marca'])){
        session_regenerate_id(true);
        $_SESSION['marca'] = true;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión 1A</title>
</head>
<body>
    <br>
    <!--Definimos unha variable-->
    <?php
        $_SESSION['usuario'] = 'Xan';
        echo "O seu ID é ", session_id();

    ?>
    <h2>Estou na páxina 1a!!</h2>
    <a href="sesion1b.php">Ir a sesion 1b</a>
</body>
</html>