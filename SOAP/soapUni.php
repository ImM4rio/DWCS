<?php

    $clienteUniversidad = new SoapClient('https://cvnet.cpd.ua.es/servicioweb/publicos/pub_gestdocente.asmx?wsdl', array('trace'=>true));
        $funcionesUni = $clienteUniversidad->__getFunctions();
        echo "<h4>Lista con las funciones de la Universidad</h4>";
        echo "<ul>";
        foreach($funcionesUni as $key=>$value){
            echo "<li><code>$value</code></li>";
        }
        echo "</ul>";

        echo "<h4>Lista con los tipos de SOAP de la universidad</h4>";
        echo "<ul>";
        $tipos = $clienteUniversidad->__getTypes();
        foreach($tipos as $v){
            echo "<li><code>$v</code></li>";
        }
        echo "<ul>";


    function titulos($clienteUniversidad) {
        $titulos = $clienteUniversidad->wstitulosuni(["plengua" => $_GET['plenguaS'], "pcurso" => $_GET['pcursoN']]);
        $resultado = $titulos->wstitulosuniResult;
        
        return $resultado;
        
    }

    function listado($resultado) {

        foreach($resultado as $key=>$value){
            echo "<table>
                    <tr>
                        <th>Nº</th>";
            if($_GET['plenguaS'] == 'C'){
                echo
                        "<th>Título</th>
                    </tr>";
            }else if($_GET['plenguaS'] == 'E'){
                echo
                        "<th>Title</th>
                    </tr>";

            }else if($_GET['plenguaS'] == 'V'){
                echo
                        "<th>Títol</th>
                    </tr>";
            }
            
            for($i = 0;$i<count($value); $i++){
                $n = $i+1;
                echo 
                    "<tr>
                        <td>".$n."</td>
                        <td>".$value[$i]->nombre."</td>
                    </tr>";

            }
        }
    }

    if(isset($_GET['buscarBtn'])){
        listado(titulos($clienteUniversidad));
    }

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Títulos Universidad,</title>
    <style>
        table, tr, td{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

    </style>
</head>
<body>
    <form action="soapUni.php" method="GET">
        <input type="number" name="pcursoN" min="2010" max="2022" placeholder="Introduce un año" title="año">
        <select name="plenguaS">
            <option value="C">Castellano</option>
            <option value="E">English</option>
            <option value="V">Valenciano</option>
        </select>
        <input type="submit" value="Buscar" name="buscarBtn">
    </form>
    
</body>
</html>