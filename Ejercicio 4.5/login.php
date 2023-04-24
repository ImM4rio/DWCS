<?php
    session_start();
    $_SESSION['rol'] = 'usuario';
    //Regenerar SID en nuevas sesiones.
    if(!isset($_SESSION['marcaDeControl'])){
        session_regenerate_id(true);
        $_SESSION['marcaDeControl'] = true;
    }
    setcookie('idioma', time()+300);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css" type="text/css">
</head>
<body>
    <?php
        //Conexion a la base de datos.
        function conexion() {
            $usuario = "Mario";
            $password = "1234";
            try{
                $pdo = new PDO('mysql:host=localhost;dbname=tarea4.5;charset=UTF8', $usuario, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $ex){
                echo "Error: " .$ex->getMessage();
            }

            return $pdo;
        }


        //Funcion que recibe como parametro el nombre de usuario y el objeto PDO a traves del cual comprueba si ese user ya esta definido en la BBDD.
        function userCheck($user, $pdo) {

            $stmnt = $pdo->prepare("SELECT nome FROM usuarios WHERE nome =:user");
            $stmnt->execute(array (
                ':user' => $user
            ));

            return $stmnt->rowCount() > 0 ? true : false;
            
        }

        //Funcion para insertar un nuevo usuario con el rol de 'usuario' por defecto.
        function insertUser($conexion, $user, $nombre, $psw, $mail){
            date_default_timezone_set('Europe/Madrid');
            $date = date("Y-m-d H:i:s");
            
            $stmnt = $conexion->prepare("INSERT INTO usuarios (nome, contrasinal, nomeCompleto, email, data, rol) VALUES (:user, :contrasinal, :nombre, :mail, :fecha, 'usuario')");
            $stmnt->execute(array(
                ':user' => $user,
                ':contrasinal' => $psw,
                ':nombre' => $nombre,
                ':mail' => $mail,
                ':fecha' => $date  
            ));

            return "<script>alert('El usuario se ha añadido');window.location.href='login.php';</script>";

        }


        //Cuando se envie el formulario.
        if(isset($_POST['registrarseBtn'])){
            $user = htmlentities($_POST['usuarioTxt']); 
            $nombre = htmlentities($_POST['nombreTxt']); 
            $psw = htmlentities(password_hash($_POST['passPsw'], PASSWORD_DEFAULT));
            $mail = htmlentities($_POST['mailE']);

            //switch para true/false de la función userCheck que recibe como parámetro el alias del usuario y el objeto PDO.
            switch (userCheck($user, conexion())) {
                case true:
                    echo "Ese nombre de usuario ya existe y no te puedes registrar con él, logéate";
                    break;
                
                case false:
                    //En caso de que no exista ese usuario, se procede al registro.
                    echo insertUser(conexion(), $user, $nombre, $psw, $mail);
                    break;
            }
        }
        
    ?>

    <form action="mostra.php" id="generico" method="POST">
        <fieldset>
            <legend>Datos de acceso</legend>
            <label for="nombre">Nombre de usuario: </label><br>
            <input type="text" name="usuarioTxt" required placeholder="Nombre de usuasrio" pattern="^[\w\d\S]{4, 30}$"><br>
            <label for="pass">Contraseña:</label><br>
            <input type="password" name="passPsw" required placeholder="Introduce contraseña" pattern="^[\w\d\S@#$%&()_.]{4,30}$"><br>
            <select name="idiomaS">
                <option value="" selected hidden >Escoge un idioma</option>
                <option value="gallego">Galego</option>
                <option value="castellano">Castellano</option>
                <option value="ingles">English</option>
            </select>
        </fieldset>
        <div id="botones">
            <input type="submit" value="Login" name="loginBtn">
            <input type="reset" value="Borrar">
        </div>
        <a href="pechaSesion.php">Cerrar sesión</a>
    </form>
</body>
</html>