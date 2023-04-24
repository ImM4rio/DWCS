<?php
    session_start();
    if(!isset($_SESSION['control'])){
        session_regenerate_id(true);
        $_SESSION['control'] = true;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión 1B</title>
</head>
<body>
    <br>
    <?php
        /*Podemos acceder á variable*/
        echo "O usuario é ", $_SESSION['usuario'];
        echo "<br>O seu ID é ", session_id();
    ?>
    <h2>Estoy na páxina 1b!!</h2>
    <a href="sesion1a.php">Ir a sesión 1a</a>
</body>
</html>