<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user'] != "Ana"){
        header("Location: login.html");
        die();

    }else if(isset($_GET['volver'])){
        session_destroy();
        header("Location: login.html");
        die();
    }



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="engadeRexistro.php" method="GET">
        <label for="campos">Añade un nuevo registro.</label><br>
        <input type="text" name="numero" placeholder="Número" min="0000" max="9999" required>
        <input type="text" name="nome" placeholder="Nombre" required><br>
        <input type="text" name="num_empregado_asignado" required placeholder="Nº empleado asignado">
        <input type="text" name="limite_de_credito" required placeholder="Límite de crédito"><br>
        <input type="submit" name="anadir" value="Añadir">
    </form>
    <form action="engadeRexistro.php" method="get">
        <input type="submit" name="volver" value="Volver">
    </form>    

    <?php
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

        function anadirRegistro($conexion, $numero, $nombre, $numEmpleado, $limite){
            $stmnt = $conexion->prepare("INSERT INTO cliente (numero, nome, num_empregado_asignado, limite_de_credito) VALUES (:numero, :nombre, :numEmpleado, :limite)");
            $stmnt->execute(array(
                ':numero' => $numero,
                ':nombre' => $nombre,
                ':numEmpleado' => $numEmpleado,
                ':limite' => $limite
            ));
            if($stmnt->rowCount()>0){
                echo "Registro añadido";
                header("refresh:3;url= login.html");
            }
        }

        if(isset($_GET['anadir'])){
            anadirRegistro(conexion(), $_GET['numero'], $_GET['nome'], $_GET['num_empregado_asignado'], $_GET['limite_de_credito']);
        }
    ?>


</body>
</html>