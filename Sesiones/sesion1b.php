<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesion1b.php</title>
</head>
<body>
    <br>
    <?php
        $datos = array("nombre"=>$_GET['user'], "pass"=>$_GET['pass']);
        $_SESSION['datos'] = $datos;
        
    ?>
    <h2>Estoy en la página 1b!!</h2>
    <a href="sesion1a.php">Ir a sesion1a</a>
    <br>
</body>
</html>