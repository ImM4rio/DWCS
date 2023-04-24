<?php
        ini_set('soap.wsdl_cache_enable',0);
        ini_set('soap.wsdl_cache_ttl',0);
    
    try{
        $cliente = new SoapClient('http://localhost/EX3aval/server/servidorSoap/servicio.wsdl', ['trace' => true]);
    
    
            
    
    }catch(SoapFault $sf){
        echo 'Error al crear el cliente Soap: '.$sf->getMessage();
    }


    function listarFunciones($cliente) {
                
        $funciones = $cliente->__getFunctions();

        echo '<h3>Lista de las funciones</h3><ul>';
        foreach ($funciones as $key => $value) {
            echo '<li>'.$value.'</li>';
        }
        echo '</ul>';

        mostrarFormulario();
    }

    function mostrarFormulario() {
        echo '<form action="accedeservizo.php" method="GET">
            <label for="id">ID:</label>
            <input type="number" required name="idNum" min="1" max="10" placeholder="Introduzca un ID">
            <button type="submit" name="nomeBtn">Nombre</button>
            <button type="submit" name="prezoBtn">Precio</button>
            <button type="submit" name="infoBtn">Información</button>
        </form>';
    }

    function getNombre($cliente){
        return $cliente->nomeBici($_GET['idNum']);
    }

    function getPrecio($cliente) {
        $nombre = getNombre($cliente);
        return "La bicicleta $nombre cuesta ".$cliente->prezo($_GET['idNum'])."€";
    }

    function getInfo($cliente) {
        return $cliente->rexistroCompleto($_GET['idNum']);
    }

    //Me equivoqué e hice las funciones con la consulta, sin usar el SoapClient
    function conexion() : PDO {
        $usuario = 'root';
        $psw = 'root';
        try{
            $conexion = new PDO('mysql:host=dbex3;dbname=proba', $usuario, $psw);
            return $conexion;

        }catch(PDOException $e) {
            echo "Error en la conexión con la base de datos: ".$e->getMessage();
        }

    }

    function getName($conexion){
        $id = $_GET['idNum'];
        try{
            $resultado = $conexion->prepare('SELECT nomeBici FROM bicicletas WHERE id =:id');
            $resultado->execute(array(
                ':id' => $id
            ));
            if($resultado->rowCount() > 0){
                while($fila = $resultado->fetch())
                echo '<h6>Nombre: '.$fila['nomeBici'].'</h6>';
            }
        
        }catch(PDOException $ex){
            echo "Error en la consulta: ".$ex->getMessage();
        }
    }

    function getPrice($conexion) {
        $id = $_GET['idNum'];
        try{
            $resultado = $conexion->prepare('SELECT nomeBici, prezo FROM bicicletas WHERE id =:id');
            $resultado->execute(array(
                ':id' => $id
            ));
            if($resultado->rowCount() > 0){
                while($fila = $resultado->fetch())
                echo '<h6>El precio de la bicicleta '.$fila['nomeBici'].' es '.$fila['prezo'].'€</h6>';
            }
        
        }catch(PDOException $ex){
            echo "Error en la consulta: ".$ex->getMessage();
        }
    }



    listarFunciones($cliente);
    
    if(isset($_GET['nomeBtn']) && isset($_GET['idNum'])){
        //getName(conexion());
        echo getNombre($cliente);

    }else if(isset($_GET['prezoBtn']) && isset($_GET['idNum'])){
        echo getPrecio($cliente);

    }else if(isset($_GET['infoBtn']) && isset($_GET['idNum'])){
        echo getInfo($cliente);

    }
?>