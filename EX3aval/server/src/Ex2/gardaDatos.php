<?php
        $usuario = 'root';
        $psw = 'root';
    try{
        $conexion = new PDO('mysql:host=dbex3;dbname=proba', $usuario, $psw);

    }catch(PDOException $ex){
        echo json_encode('Error en la conexión con la base de datos' .$ex->getMessage());
    }

    $api = 'https://sensoralia.iessanclemente.net/api/v1/';
    $mediciones = $_POST['numMed'];
    if(isset($_POST['boton']) && $_POST['boton'] = 'guardarBtn'){

        switch ($_POST['select']) {
            case 8:
                $api .= 'sensores/8/mediciones?limit='.$mediciones;
                $resultado = json_decode(file_get_contents($api));
                
                try{
                    $variable = $resultado->sensor->nombresensor;
                    foreach ($resultado->datos as $dato) {
                        
                        $stmnt = $conexion->prepare('INSERT INTO medidas(Variable, DataHora, Medicion) Values (:variable, :datahora, :medicion)');
                        $stmnt->execute(array(
                            ':variable' => $variable,
                            ':datahora' => $dato->fechahora,
                            ':medicion' => $dato->valor
                        ));

                    }

                    if($stmnt->execute() > 0){
                        echo 'Se ha actualizado la base de datos';
                    }

                }catch(PDOException $ex){
                    echo "Error al guardar los datos: ".$ex->getMessage();
                }

                break;

            case 9:
                $api .= 'sensores/9/mediciones?limit='.$mediciones;
                $resultado = json_decode(file_get_contents($api));

                try{
                    $variable = $resultado->sensor->nombresensor;
                    foreach ($resultado->datos as $dato) {
                        
                        $stmnt = $conexion->prepare('INSERT INTO medidas(Variable, DataHora, Medicion) Values (:variable, :datahora, :medicion)');
                        $stmnt->execute(array(
                            ':variable' => $variable,
                            ':datahora' => $dato->fechahora,
                            ':medicion' => $dato->valor
                        ));

                    }

                    if($stmnt->execute() > 0){
                        echo 'Se ha actualizado la base de datos';
                    }

                }catch(PDOException $ex){
                    echo "Error al guardar los datos: ".$ex->getMessage();
                }

                break;

            case 10:
                $api .= 'sensores/10/mediciones?limit='.$mediciones;
                $resultado = json_decode(file_get_contents($api));

                try{
                    $variable = $resultado->sensor->nombresensor;
                    foreach ($resultado->datos as $dato) {
                        
                        $stmnt = $conexion->prepare('INSERT INTO medidas(Variable, DataHora, Medicion) Values (:variable, :datahora, :medicion)');
                        $stmnt->execute(array(
                            ':variable' => $variable,
                            ':datahora' => $dato->fechahora,
                            ':medicion' => $dato->valor
                        ));

                    }

                    if($stmnt->execute() > 0){
                        echo 'Se ha actualizado la base de datos';
                    }

                }catch(PDOException $ex){
                    echo "Error al guardar los datos: ".$ex->getMessage();
                }
                
                break;

            default:
                echo json_encode("Error en el servidor");
                break;
        }
    
    }
?>