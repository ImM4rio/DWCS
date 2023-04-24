<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <style>
            .oculta {
                display:none;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="validar.js"></script>
    </head>
    <body>
        <?php require 'validar.php'; ?>
        <h3>Registro</h3>
            <form name='login' method='POST' action='validacion.php'>
                <input type="text" placeholder="usuario" id='usuario' name='usuario' value='<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : '' ?>' required>
                <p id='errUsuario' for='usuario' class='<?php echo (!isset($_POST['enviar']) || validarNome($_POST['usuario'])) ? "oculta" : "" ?>' > Debe ter máis de 3 caracteres </p>
            <br>
                <input type="password" placeholder="contrasinal" id='pass' name='pass' required>
            <br>
                <input type="password" placeholder="repite contrasinal" id='pass2' name='pass2' required>
                <p id='errPassword' for='pass' class='<?php echo (!isset($_POST['enviar']) || validarPasswords($_POST['pass'], $_POST['pass2'])) ? "oculta" : "" ?>'> <?php validarPasswords($_POST['pass'], $_POST['pass2'])?></p >
            <br>
                <input type="mail" placeholder="e-Mail" name='mail' id='mail' value='<?php echo isset($_POST['mail']) ? $_POST['mail'] : '' ?>' required>
                <p id='errMail' for='email' class='<?php echo (!isset($_POST['enviar']) || validarEmail($_POST['mail'])) ? "oculta" : "" ?> '>A dirección de email non é correcta</p>
            <br>
                <input type="submit" value="Registrar" name='enviar'>
        </form>
    </body>
</html>