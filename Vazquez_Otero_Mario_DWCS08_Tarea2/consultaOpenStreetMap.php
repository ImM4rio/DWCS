<?php
    //Declaramos todas las variables por comodidad.
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $municipio = $_POST['municipio'];
    $productosArray = $_POST['productosArray'];

    //Verificación de los datos como se pide en el enunciado.
    if(preg_match("/^[\d]{8}[A-Z]{1}$/", $dni) != 1){
        echo "<h1>Error en la inserción del DNI</h1>";
        header("refresh:4; url=index.php");

    }else if(preg_match("/^[9,6,8]{1}[\d]{8}$/", $telefono) != 1){
        echo "<h1>Error en la inserción del teléfono</h1>";
        header("refresh:4; url=index.php");
    }

    $search_url = 'https://nominatim.openstreetmap.org/search?q=';  
    //Introducimos en la url el input:text tras la query (?q=)
    $search_url .= $_POST['municipio'];
    $search_url .= '&format=json';

    $httpOptions = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Nominatim-Test"
        ]
    ];

    $streamContext = stream_context_create($httpOptions);
    $json = file_get_contents($search_url, false, $streamContext);
    //print_r($json);

    $decoded = json_decode($json, true);
    $lat = $decoded[0]['lat'];
    $lng = $decoded[0]['lon'];

    //Creamos el array que más tarde codificaremos en json y devolveremos al cliente.
    $jsonData = array();

    $jsonData['lat'] = $lat;
    $jsonData['lng'] = $lng;
    $jsonData['nombre'] = $nombre;
    $jsonData['dni'] = $dni;
    $jsonData['direccion'] = $direccion;
    $jsonData['telefono'] = $telefono;
    $jsonData['productosArray'] = $productosArray;

    echo json_encode($jsonData);
    
?> 
