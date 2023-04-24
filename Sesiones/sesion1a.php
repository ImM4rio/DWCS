<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sesion1a.php</title>
</head>
<body>
    <br>
    <form action="sesion1b.php" method="GET">
        <label for="usuario">Usuario</label><br>
        <input type="text" name="user" placeholder="Introduce un usuario" title="Sólo letras y números" pattern="^[\w\d]{1,20}$"><br>
        <label for="password">Contraseña</label><br>
        <input type="password" name="pass" placeholder="Introduce una contraseña"><br>
        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </form>

    <h2>Estoy en la página 1a!!</h2>
    <?php
        /*$_SESSION array aosociativo que permite guardar variables que estarán 
        * disponibles mientras esté abierta la sesión.
        */
        if(isset($_SESSION['datos'])){
            $datos = $_SESSION['datos'];
            $nombre = $datos['nombre'];
            $pass = $datos['pass'];
            echo "El usuario es ".$nombre." y su contraseña es ".$pass;

        }else{
            echo "Todavía no hay ninguna sesión de usuario disponible.";
        }
    ?>
    <br>
    <a href="sesion1b.php">Ir a sesion1b</a>
</body>
</html>