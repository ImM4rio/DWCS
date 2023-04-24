<?php
    $servidor = 'localhost';
    $usuario = 'Mario';
    $pass = '1234';
    $db = 'proba';

    try{
        $pdo = new PDO("mysql:host=$servidor;dbname=$db;charset=UTF8", $usuario, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        
        $stmtn = $pdo->prepare("INSERT INTO vendedor (nome, email) VALUES(:nome, :email)");
        $stmtn->execute(array(
            ':nome' => $_POST['nombreTxt'],
            ':email' => $_POST['emailEm']
        ));

        $mensaje['resultado'] = 'OK';
        echo json_encode($mensaje); 

    }catch(PDOException $ex) {;
        $problema = "Hubo un error con la inserción: ".$ex->getMessage();
        $error['resultado'] = $problema;
            if($ex->getCode() == 23000){
                $error['resultado'] = 'El email '.$_POST['emailEm'].' ya existe en nuestra base de datos.';

            }
        echo json_encode($error);

    }

?>