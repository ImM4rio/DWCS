<?php

$cliente = new SoapClient('https://www.crcind.com/csp/samples/SOAP.Demo.CLS?WSDL', array('trace'=>true));
    $funcions = $cliente->__getFunctions();
    echo "<h4>Lista con las funciones de SOAP</h4>";
    echo "<ul>";

    foreach ($funcions as $k => $v) {
        echo "<li><code>$v</code></li>";
    }

    echo "</ul>";
    
    echo "<h4>Lista con los tipos de SOAP</h4>";
    echo "<ul>";
    $tipos = $cliente->__getTypes();
    foreach($tipos as $v){
        echo "<li><code>$v</code></li>";
    }
    echo "</ul>";


    function suma($cliente) {
        $resultado = $cliente->AddInteger(["Arg1" => $_GET['num1N'], "Arg2" => $_GET['num2N']]);
        return $resultado->AddIntegerResult;

    }


    function dividir($cliente) {
        $resultado = $cliente->DivideInteger(["Arg1" => $_GET['num1N'], "Arg2" => $_GET['num2N']]);
        return $resultado->DivideIntegerResult;

    }


    function buscarPersona($cliente) {
        $resultado = $cliente->FindPerson(["id" =>$_GET['personaN']]);
        $persona = $resultado->FindPersonResult;
        echo "<br>";
        foreach($persona as $key => $value){
            switch ($key) {
                case 'Name':
                    echo "Nombre: $value<br>";
                    break;
                
                case 'DOB':
                    echo "Fecha de Nacimiento: $value<br>";
                    break;
                
                case 'Home':
                    echo "Ciudad donde vive:";
                    foreach($value as $home=>$direccion){
                        if($home == 'City'){
                            echo "$direccion<br>";
                        }
                    }
                    break;
                
                case 'FavoriteColors':
                    echo "Colores Favoritos: ";
                    foreach($value as $color){
                        echo $color." ";
                    }

            }
        }

        
    }

    function listaPorNombre($cliente) {
        $resultado = $cliente->GetListByName(["name" => $_GET['nombreTxt']]);
        $arrayResultado = $resultado->GetListByNameResult;
        echo "<br>";
        foreach($arrayResultado as $key=>$value){
            foreach($value as $key => $value){
               foreach($value as $key=>$value){
                    switch ($key) {
                        case 'Name':
                            echo "Nombre: $value<br>";
                            break;
                        
                        case 'DOB':
                            echo "Fecha de Nacimiento: $value<br>";
                            break;
                        
                        case 'ID':
                            echo "ID: $value<br>";

                            break;
        
                    }
                }
            }
        }       

        
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SOAP</title>
    <style>
        form{
            margin-top: 5%;
        }
    </style>
</head>
<body>
    <form action="soap.php" method="GET">
        <input type="number" name="num1N" placeholder="Introduce un valor" title="Valor1">
        <input type="number" name="num2N" placeholder="Introduce un valor" title="Valor 2">
        <input type="submit" value="Suma" name="sumaBtn">
        <input type="submit" value="Dividir" name="dividirBtn">
        <?php   
            if(isset($_GET['sumaBtn'])){
                echo '<input type="text" readonly="readonly" name="resultado" value="Resultado: '.suma($cliente).'">';
        
            }else if(isset($_GET['dividirBtn'])){
                echo '<input type="text" name="resultado" readonly="readonly" value="Resultado: '.dividir($cliente).'">';

            } 
        ?>
        <br>
        <input type="number" name="personaN" placeholder="Introduce un Id" title="Id">
        <input type="submit" value="Buscar Persona" name="buscarPersonaBtn">
        <?php
            if(isset($_GET['buscarPersonaBtn'])){
                buscarPersona($cliente);
            }

        ?>
        <br>
        <input type="text" name="nombreTxt" placeholder="Nombre de la persona" title="Nombre">
        <input type="submit" value="Buscar" name="listaPersonaBtn">
        <?php
            if(isset($_GET['listaPersonaBtn'])){
                listaPorNombre($cliente);
            }
        ?>
    </form>
</body>
</html>