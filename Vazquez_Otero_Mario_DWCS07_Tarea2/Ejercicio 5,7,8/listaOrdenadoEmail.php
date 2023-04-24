<?php
    $servidor = "localhost";
    $usuario = "Mario";
    $psw = '1234';
    $db = 'proba';

    try{
        $pdo = new PDO("mysql:host=$servidor;dbname=$db;charset=UTF8", $usuario, $psw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }catch(PDOException $err) {
        echo "Error en la conexión: " .$err->getMessage();
    }
     
    if($_POST['boton'] == 'ordenarNombreBtn'){
        $stmtn = $pdo->query("SELECT nome, email FROM vendedor ORDER BY nome DESC");
        

    }else if($_POST['boton'] == 'ordenadoMailBtn'){
        $stmtn = $pdo->query("SELECT nome, email FROM vendedor ORDER BY email ASC");
        
    }
    
    $result = $stmtn->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);

?>