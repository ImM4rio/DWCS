<?php
    session_start();
    if(isset($_POST['passwd'])){
        $usuario = $_POST['usuario'];
        $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
        $rol = $_POST['rol'];
        $data = new DateTime('1970-07-01');
        $fecha = $data->format('d-m-y H:i:s');
        $_SESSION['usuario'] = array (
            'usuario' => $usuario,
            'passwd' => $passwd,
            'rol' => $rol,
            'fecha' => $fecha
        );

    }else if(isset($_POST['volverLogin'])){


    }else{
        echo "Primero regístrese en la página siguiente...";
        header("refresh:3;url=rexistro.html");
        die;
    }
    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="mostra.php" method="POST">
        <fieldset>
            <legend>Login</legend>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" placeholder="Nombre de usuario" pattern="^[\w\d]{1, 40}$" title="Sólo caracteres alfabéticos, decimales y los signos !@#$%&/()=?¿¡"><br>
            <label for="passwd">Contraseña: </label>
            <input type="password" name="passwd" placeholder="Introduzca contraseña" pattern="^[\S]{8,}$" title="Mayor a 8 caracteres, sin espacios"><br>
            <input type="submit" value="Aceptar">
            <input type="submit" value="Volver" name="volver">
        </fieldset>
    </form>
</body>
</html>