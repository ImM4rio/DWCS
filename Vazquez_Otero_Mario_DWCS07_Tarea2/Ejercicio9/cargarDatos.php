<?php

    function conexion () : PDO {
        $usuario = "Mario";
        $ps = "1234";
        $db = 'proyecto';
        $host = 'localhost';

        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $usuario, $ps);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $ex) {
            echo "Error en la conexión con la base de datos: ". $ex->getMessage();
        }

        return $pdo;
    }


    function cargarSelect($pdo) {
        $stmnt = $pdo->prepare("SELECT * FROM familias");
        $stmnt->execute();
        if($stmnt->rowCount() > 0){
            while($fila = $stmnt->fetch()){
                echo '<option value="'.$fila['cod'].'">'.$fila["nombre"].'</option>';
            }
        }
    }

    if(isset($_POST['valor'])){
        $stmnt = conexion()->prepare("SELECT * FROM productos WHERE familia = :familia");
        $stmnt->execute(array(
            ':familia' => $_POST['valor']
        ));

        if($stmnt->rowCount() == 0){
            $result['error'] = 'No hay ningún producto de esta familia';
        }else{
            $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        }

        echo json_encode($result);
    
    }

    

?>