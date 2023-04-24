<?php
    session_start();
    //Regenerar SID en nuevas sesiones.
    if(!isset($_SESSION['marcaDeControl'])){
        session_regenerate_id(true);
        $_SESSION['marcaDeControl'] = true;
    }
    
    if(isset($_POST['loginBtn'])){
        $user = htmlentities($_POST['usuarioTxt']);
        $psw = htmlentities($_POST['passPsw']);
        
        comprobarUsuario(conexion(), $user, $psw);
        setcookie('idioma', $_POST['idiomaS'], time()+300);
        if($_COOKIE['idioma'] == 'gallego'){
            echo '<script type="text/javascript">alert("Benvido de novo!");window.location.href="mostra.php";</script>';

        }else if($_COOKIE['idioma'] == 'castellano'){
            echo '<script type="text/javascript">alert("Bienvenido de nuevo!");window.location.href="mostra.php";</script>';

        }else if($_COOKIE['idioma'] == 'ingles'){
            echo '<script type="text/javascript">alert("Welcome again!");window.location.href="mostra.php";</script>';

        }
    }
    
    
    if($_SESSION['rol'] == 'usuario'){
        tablaProductos(conexion());
        verComentarios(conexion());
        
        if(isset($_POST['comentarBtn'])){
            if(comentar(conexion(), htmlentities($_POST['comentarioTxt']), $_SESSION['user'])){
                echo '<script type="text/javascript">alert("Se ha añadido un nuevo comentario");window.location.href="mostra.php";</script>';
            }
        }

    }else if($_SESSION['rol'] == 'administrador'){
        header('Location:xestiona.php');

    }else{
        echo " algo va mal";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muestra</title>
    <link rel="stylesheet" href="estilos.css" type="text/css">
</head>
<body>
    <?php
        //Funcion para conectarse a la base de datos.
        function conexion() {
            $usuario = "Mario";
            $password = "1234";
            try{
                $pdo = new PDO('mysql:host=localhost;dbname=tarea4.5;charset=UTF8', $usuario, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $ex){
                echo "Error en la conexión a la base de datos: " .$ex->getMessage();
            }
            return $pdo;
        }


        //Funcion a la que se pasa como parámentros el objeto PDO junto con el usuario y el psw del formulario del login y a partir del cual comprueba que existe en la base de datos.
        function comprobarUsuario($conexion, $user, $psw) {            
            $stmnt = $conexion->prepare("SELECT nome, rol, contrasinal FROM usuarios WHERE nome =:nome");
            $stmnt->execute(array(
                ':nome' => $user
            ));

            if($stmnt->rowCount() > 0){
                while($fila = $stmnt->fetch()){
                    if(password_verify($psw, $fila['contrasinal']) && $fila['rol'] == 'administrador'){
                        $_SESSION['rol'] = 'administrador';
                    
                    }else if(!password_verify($psw, $fila['contrasinal'])){
                        header('Location: login.php');
                    
                    }else{
                        //Guardamos la variable del nombre del usuario en una variable de session para poder trabajar con ella más adelante.
                        $_SESSION['user'] = $fila['nome'];
                    }
                }
            }else{
                header('Location: login.php');
            }
        }

        //Funcion que muestra los productos.
        function tablaProductos($conexion) {
            $stmnt = $conexion->prepare("SELECT * FROM produto");
            $stmnt->execute();
            if($stmnt->rowCount() > 0){
                echo "<table id='productos'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                    </tr>";
                while($fila = $stmnt->fetch()){
                    echo "<tr>
                        <td>".$fila['idProduto']."</td>
                        <td>".$fila['nome']."</td>
                        <td>".$fila['descricion']."</td>
                        <td>".$fila['prezo']."</td>
                        <td><img src='imaxes/".$fila['imaxe']."' alt='imagen de un tomate rojo' width='50px'></td>
                    </tr>";
                    
                }
                echo "</table>";
            }
        }

        //Funcion para dejar comentarios que retorna un booleano si se hace un insert con éxito.
        function comentar($conexion, $comentario, $user){
            date_default_timezone_set('Europe/Madrid');
            $fecha = date('Y-m-d H:i:s');
            
            $stmnt = $conexion->prepare("INSERT INTO comentarios (comentario, data, usuario) VALUES (:comentario, :data, :usuario)");
            $stmnt->execute(array(
                ':comentario' => $comentario,
                ':data' => $fecha,
                ':usuario' => $user
            ));

            if($stmnt){
                return true;
            
            }else{
                return false;
            }
        }

        
        //Funcion para ver los 5 últimos comentarios
        function verComentarios($conexion) {
            $stmnt = $conexion->prepare("SELECT * FROM comentarios ORDER BY data DESC LIMIT 5");
            $stmnt->execute();
            if($stmnt->rowCount() > 0){
                echo "<table id='comentarios'>
                        <tr>
                            <th>Usuario</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>";
                while($fila = $stmnt->fetch()){
                    echo "<tr>
                            <td>".$fila['usuario']."</td>
                            <td>".$fila['comentario']."</td>
                            <td>".$fila['data']."</td>
                        </tr>";
                }
            echo "</table>";
            }
        }
        
    ?>
    <form action="mostra.php" method="POST" id="comentarioForm">
        <label for="comentario">Comentario:</label><br>
        <textarea name="comentarioTxt" cols="25" rows="2" maxlength="50" placeholder="Introduce tu comentario..."></textarea><br>
        <input type="submit" value="Comentar" name="comentarBtn">
        <input type="reset" value="Borrar">
        <a href="pechaSesion.php">Cerrar sesión</a>
    </form>
</body>
</html>