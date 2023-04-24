<?php
    session_start();
    if(isset($_GET['volver'])){
        session_destroy();
        header("Location: login.html");
        die();
    }

    
    if(isset($_GET['user'])){
        if($_GET['user'] != "Xan" && $_GET['user'] != "Ana"|| $_GET['pass'] != "abc123"){
            header("refresh:3;url=login.html");
            echo "<h2>El usuario ".$_GET['user']." no puede acceder a los datos, redirigiendo a la página de origen...</h2>";
            //Cerrar la redirección si esta es ignorada.
            die();
        
        }else{
            $_SESSION['user'] = $_GET['user'];
           
        }
       
    }

    if(!isset($_SESSION['user'])){
        echo "Inicie primero sesión como un usuario válido";
        header("refresh:3;url=login.html");
        die();
    }
    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>datos</title>
</head>
<body>
    <?php        
     echo "<h2>El usuario ".$_SESSION['user']." tiene abierta la sesión.</h2>";
        function conexion(){
            try{
                $conexion = null;
                $conexion = new PDO("mysql:host=localhost;dbname=empresa;charset=utf8", "Mario", "1234");
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $ex){
                echo "Error ".$ex->getMessage();
            }
            return $conexion;
        }

        function cerrarConexion($conexion){
            $conexion = null;
        }

        function cargarTabla($conexion){
            $stmnt = $conexion->prepare("SELECT * FROM cliente");
            $stmnt->execute();
            if($stmnt->rowCount() > 0){
                echo 
                    "<table>
                        <tr>
                            <th>Número</th>
                            <th>Nome</th>
                            <th>Número empregado asignado</th>
                            <th>Límite</th>    
                        </tr>";
                while($fila = $stmnt->fetch()){
                    echo
                        "<tr>
                            <td>".$fila['numero']."</td>
                            <td>".$fila['nome']."</td>
                            <td>".$fila['num_empregado_asignado']."</td>
                            <td>".$fila['limite_de_credito']."</td>
                        </tr>";
                }
                echo 
                    '</table>
                    <form action="datos.php" method="GET">
                        <input type="submit" name="nombre" value="Ordenar por nome">
                        <input type="submit" name="empleado" value="Ordenar por empregado asignado">
                    </form>
                        
                ';
                if($_SESSION['user'] == "Ana"){
                    echo '<form action="engadeRexistro.php" method="GET"><input type="submit" name="agregar" value="Agregar"></form>';
                }
                echo '<form action="login.html" method="get">
                <input type="submit" name="volver" value="Volver">
                </form>';  
            }
        }

        function ordenarNombre($conexion){
            $stmnt = $conexion->prepare("SELECT * FROM cliente ORDER BY nome");
            $stmnt->execute();
            if($stmnt->rowCount()>0){
                echo 
                    "<table>
                        <tr>
                            <th>Número</th>
                            <th>Nome</th>
                            <th>Número empregado asignado</th>
                            <th>Límite</th>    
                        </tr>";
                while($fila = $stmnt->fetch()){
                    echo
                        "<tr>
                            <td>".$fila['numero']."</td>
                            <td>".$fila['nome']."</td>
                            <td>".$fila['num_empregado_asignado']."</td>
                            <td>".$fila['limite_de_credito']."</td>
                        </tr>";
                }
                echo 
                '</table>
                <form action="datos.php" method="GET">
                    <input type="submit" name="nombre" value="Ordenar por nome">
                    <input type="submit" name="empleado" value="Ordenar por empregado asignado">
                    </form>';
                    if($_SESSION['user'] == "Ana"){
                        echo '<form action="engadeRexistro.php method="GET"><input type="submit" name="agregar" value="Agregar"></form>';
                    }
            echo '<form action="login.html" method="get">
                <input type="submit" name="volver" value="Volver">
                </form>';        
            }
        }


        function ordenarEmpleado($conexion){
            $stmnt = $conexion->prepare("SELECT * FROM cliente ORDER BY num_empregado_asignado");
            $stmnt->execute();
            if($stmnt->rowCount()>0){
                echo 
                "<table>
                    <tr>
                        <th>Número</th>
                        <th>Nome</th>
                        <th>Número empregado asignado</th>
                        <th>Límite</th>    
                    </tr>";
                while($fila = $stmnt->fetch()){
                    echo
                        "<tr>
                            <td>".$fila['numero']."</td>
                            <td>".$fila['nome']."</td>
                            <td>".$fila['num_empregado_asignado']."</td>
                            <td>".$fila['limite_de_credito']."</td>
                        </tr>";
                }
                echo 
                '</table>
                <form action="datos.php" method="GET">
                    <input type="submit" name="nombre" value="Ordenar por nome">
                    <input type="submit" name="empleado" value="Ordenar por empregado asignado">
                </form>
                ';
                if($_SESSION['user'] == "Ana"){
                    echo '<form action="engadeRexistro.php" method="GET"><input type="submit" name="agregar" value="Agregar"></form>';
                }
                echo '<form action="login.html" method="get">
                <input type="submit" name="volver" value="Volver">
                </form>';  
            }
        }
        
        function anadirEmpleado($conexion){

        }
        

        

        if(isset($_GET['nombre'])){
            ordenarNombre(conexion());
        }else if(isset($_GET['empleado'])){
            ordenarEmpleado(conexion());

        }else{
            cargarTabla(conexion());
        }
        
        cerrarConexion(conexion());
        
    ?>

   
    
</body>
</html>