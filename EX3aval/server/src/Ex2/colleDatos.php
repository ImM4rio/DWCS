<?php
    $api = 'https://sensoralia.iessanclemente.net/api/v1/';
    $mediciones = $_POST['numMed'];
    if(isset($_POST['boton']) && $_POST['boton'] = 'buscarBtn'){

        switch ($_POST['select']) {
            case 8:
                $api .= 'sensores/8/mediciones?limit='.$mediciones;
                echo file_get_contents($api);
                break;

            case 9:
                $api .= 'sensores/9/mediciones?limit='.$mediciones;
                echo file_get_contents($api);
                break;

            case 10:
                $api .= 'sensores/10/mediciones?limit='.$mediciones;
                echo file_get_contents($api);
                break;

            default:
                echo json_encode("Error en el servidor");
                break;
        }
    
    }


?>
