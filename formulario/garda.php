<?php
    try{
        $con = new PDO('mysql:host=localhost;dbname=proba; charset=UTF8', 'Mario', '1234');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $ex) {
        echo "Error en la conexion " .$ex->getMessage();
    }

    $nombre = $_POST['nombre'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    
    $stmnt = $con->prepare('INSERT INTO usuario (nombre, pass) VALUES ("'.$nombre.'", "'.$pass.'")');

    $stmnt->execute();
    if($stmnt->rowCount() > 0){
        echo "<h2>Usuario introducido con éxito.</h2>";
    }

?>