<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <style>
            .oculta {
                display:none;
            }
        </style>
    </head>
    <body>
        <h3>Registro</h3>
            <form name='login' id='rexistro' method='POST' action='registro.php'>
                <input type="text" placeholder="usuario" id='usuario' name='usuario' required>
                <p id='errUsuario' for='usuario' class='oculta'> Debe ter máis de 3 caracteres </p>
            <br>
                <input type="password" placeholder="contrasinal" id='pass' name='pass' required>
            <br>
                <input type="password" placeholder="repite contrasinal" id='pass2' name='pass2' required>
                <p id='errPassword' for='pass' class='oculta'></p >
            <br>
                <input type="mail" placeholder="e-Mail" name='mail' id='mail' required>
                <p id='errMail' for='email' class='oculta'>A dirección de email non é correcta</p>
            <br>
                <input type="submit" value="Registrar" name='enviar'>
        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="validar.js"></script>
    </body>
</html>