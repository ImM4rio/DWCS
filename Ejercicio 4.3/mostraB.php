<?php
session_start();
    if(isset($_POST['modificar'])){
        modificar(establecerConexion());

    }else if(isset($_POST['eliminar']) || $_SESSION['usuario']['rol'] == 'administrador'){
        if(isset($_POST['checkbox'])){
            eliminar(establecerConexion());
        
        }else{
            usuario(establecerConexion());
            administrador(establecerConexion());
        }
   

    }else if(isset($_POST['volver'])){
        header("location: rexistroB.html");
        die;
    
        //Si el nombre de usuario o la contraseña son incorrectos, redirigimos a la página de origen y cerramos sesión.
    }else if($_SESSION['usuario']['usuario'] != $_POST['usuario']){
        echo "El nombre de usuario no es correcto, redirigiendo a la página de origen...";
        header("refresh:3;url=rexistroB.html");
        die;
        
        //Verificamos el password
    }else if(password_verify($_POST['passwd'], $_SESSION['usuario']['passwd']) && validarRol(establecerConexion())){
        usuario(establecerConexion());
        administrador(establecerConexion());
    
        //En caso de que no se valide la conexión para el administrador verificamos el password del usuario.
    }else if(password_verify($_POST['passwd'], $_SESSION['usuario']['passwd']) && $_SESSION['usuario']['rol'] == 'usuario'){
        usuario(establecerConexion());



        //En caso de que la contraseña no coincida con el usuario se dará otra oportunidad redirigiendo a login.php sin cerrar sesión.
    }else{
        echo "<h3>La contraseña para este usuario no es correcta, o no se ha logeado con el rol correcto, redirigiendo a rexistro.html...</h3>";
        header("refresh:3;url=rexistroB.html");
    }


    //Función para establecer conexión con la base de datos.
    function establecerConexion() {
        try{
            $conexion = new PDO("mysql:host=localhost;dbname=proba;charset=UTF8", 'Mario', '1234');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $ex){
            echo "Error: " .$ex->getMessage();
        }
        
        return $conexion;
    }

    function cerrarConexion($conexion) {
        $conexion = null;

    }

    //Función para entrar en mostraB.php con los permisos del rol usuario.
    function usuario($conexion) {
        //Saludo y fechas de conexión.
        $usuario = $_SESSION['usuario']['usuario'];
        $fecha = $_SESSION['usuario']['fecha'];
        $pass = isset($_POST['passwd']) ? $_POST['passwd'] : $_SESSION['usuario']['passwd'];
        $rol = $_SESSION['usuario']['rol'];
        
        

        $stmnt = $conexion->prepare("SELECT nome, ultimaconexion, passwd FROM usuariostempo WHERE nome = :nome");
        $stmnt->execute(array(
            ':nome' => $usuario
        ));

        if($stmnt->rowCount() == 0){

            
            $fecha = Date("Y-m-d H:i:s");
            $insert = $conexion->prepare("INSERT INTO usuariostempo (nome, passwd, ultimaconexion, rol) VALUES (:nome, :passwd, :ultimaconexion, :rol)");
            $insert->execute(array(
                ':nome' => $usuario,
                ':passwd' => $_SESSION['usuario']['passwd'],
                ':ultimaconexion' => $fecha,
                ':rol' => $rol
            ));

            echo "<h3>Hola ".$usuario.", bienvenido a <i>mostra.php</i></h3>";
            echo "<br><h4>Última fecha de conexión: ".$fecha."</h4>";
        
        }else{
            while($dato = $stmnt->fetch()){
                if(!password_verify($pass, $dato['passwd']) && !hash_equals($pass, $_SESSION['usuario']['passwd'])){
                    //En el caso de que el usuario esté en uso, es decir, la contraseña que se quiere crear para ese nombre sea distinta de la establecida anteriormente.
                    echo "<h3>Este nombre de usuario ya está en uso, inténtedo de nuevo con otro nombre de usuario, redirigiendo a rexistro.html...</h3>";
                    header("refresh:3;url=rexistroB.html");
                    die;

                }else{
                    //Si tenemos los datos sobre ese nombre y la contraseña es la misma que la que tenemos en la base de datos, se imprime el saludo con la última fecha de conexión.
                    $fecha = Date("Y-m-d H:i:s");
                    $update = $conexion->prepare("UPDATE usuariostempo SET ultimaconexion = :fecha WHERE nome = :nome");
                    $update->execute(array(
                        ':fecha' => $fecha,
                        ':nome' => $usuario
                    ));

                    echo "<h3>Hola ".$dato['nome'].", bienvenido a <i>mostra.php</i></h3>";
                    echo "<br><h4>Última fecha de conexión: ".$dato['ultimaconexion']."</h4>";
                }
            }
            
        }

    }

    //Función para entrar en mostraB.php con los permisos de administrador.
    function administrador($conexion) {

        $stmnt = $conexion->prepare("SELECT * FROM usuariostempo");
        $stmnt->execute();
        echo '<form action="mostraB.php" method="POST">';
        if($stmnt->rowCount() > 0){
            echo "<table>
                <tr>
                    <th>Nome</td>
                    <th>Contraseña</td>
                    <th>Última Conexión</td>
                    <th>Rol</td>
                </tr>";
            while($fila = $stmnt->fetch()){
                echo "<tr>
                    <td>".$fila['nome']."</td>
                    <td>".$fila['passwd']."</td>
                    <td>".$fila['ultimaconexion']."</td>
                    <td>".$fila['rol']."<br>
                    <select name='".$fila['nome']."'>
                        <option value='' selected hidden>Escoge una opción</option>
                        <option value='usuario'>Usuario</option>
                        <option value='administrador'>Administrador</option>
                    </select>
                    <input type='checkbox' name='checkbox[]' value='".$fila['nome']."'>
                    </td>
                </tr>";
            }
            echo "</table>";
            echo "<input type='submit' value='Modificar' name='modificar'>";
            echo "<input type='submit' value='Eliminar' name='eliminar'>";
            echo "</form>";
        }
    }

    //Función para modificar la tabla desde la administración.
    function modificar($conexion) {
        $nombres = $conexion->prepare("SELECT nome FROM usuariostempo");
        $nombres->execute();

        while($fila = $nombres->fetch()){
            if($_POST[$fila['nome']] != ""){
                $stmnt = $conexion->prepare("UPDATE usuariostempo SET rol = :rol WHERE NOME = :nome");
                $stmnt->execute(array (
                    'rol' => $_POST[$fila['nome']],
                    'nome' => $fila['nome']
                ));
            }
        }
    }

    //Función para validar si el log es de un admin.
    function validarRol($conexion){
        $stmnt = $conexion->prepare("SELECT rol FROM usuariostempo WHERE nome = :nome");
        $stmnt->execute(array(
            ':nome' => $_SESSION['usuario']['usuario']
        ));
        while($fila = $stmnt->fetch()){
            if($fila['rol'] != 'administrador'){
                return false;
            }else{
                $_SESSION['usuario']['rol'] = 'administrador';
                return true;
            }
        }
        
    }

    //Función para eliminar un registro de la base de datos.
    function eliminar($conexion) {
        $delete = implode(",", $_POST['checkbox']);
            $stmnt = $conexion->prepare("DELETE FROM usuariostempo WHERE nome IN (:lista)");
            $stmnt->execute(array(
                ':lista' => $delete
            ));
            header("location: mostraB.php");
        
    }
    cerrarConexion(establecerConexion());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostra</title>
    <style>
        table, th, td{
            border-collapse: collapse;
            border: 2px solid black;
            text-align: center;
            height: 50px;
        }
    </style>
</head>
<body>
    <form action="pechaSesionB.php">
        <input type="submit" value="Volver">
    </form>
    
    
</body>
</html>