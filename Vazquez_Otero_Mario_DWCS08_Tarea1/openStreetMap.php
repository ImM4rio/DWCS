<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenStreetMap</title>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css">
    <style>
        div#informacion {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Mapa simple de OpenStreetMap con Open Layers</h1>
    <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <form id="formulario" method="get">
        <label for="busqueda">Término de búsqueda: </label>
        <input type="text" name="terminoTxt" id="terminoTxt">
        <input type="submit" name="buscarBtn" id="buscarBtn" value="Buscar">
        <input type="button" id="info" value="Información">
    </form>

    <div id="map" class="map"></div>

    <?php
        //En caso de que se busque el término.
        if(!empty($_GET['terminoTxt'])){

            $search_url = 'https://nominatim.openstreetmap.org/search?q=';
            //Introducimos en la url el input:text tras la query (?q=)
            $search_url .= $_GET['terminoTxt'];
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
            //echo '<br> json='.$json.'<br>';
    
            $decoded = json_decode($json, true);
            $lat = $decoded[0]['lat'];
            $lng = $decoded[0]['lon'];
    
            echo "<br>";
    
            echo "latitude=".$lat."-----lonxitude=".$lng;


            //Tratamos la consulta a la wikipedia como en el apartado anterior.
            $url = 'http://es.wikipedia.org/w/api.php';
            //Ahora introducimos en la url de la búsqueda en wikipedia el input:text
            $url .= '?action=query&list=search&srlimit=5&format=xml&redirects&srsearch='.urlencode($_GET['terminoTxt']);

            //Creamos una pagina.xml para comprobar de nuevo la jerarquía en el documento xml.
            $lista = file_get_contents($url);
            file_put_contents('pagina.xml', $lista);

            $xml = new SimpleXMLElement($lista);
            echo "<div id='informacion'><ul>";
                foreach($xml->query->search->children() as $pag){
                    $params = '?terminoTxt='.$_GET['terminoTxt'];
                    $params .= '&pax='.urlencode($pag['title']);

                //Por cada objeto dentro de search en el documento XML creamos un item con la dirección correspondiente.
                echo "<li><a href='$params'>".$pag['title']."</a></li>";
                }
            echo "</ul></div>";
                
            //Tratamos el contenido de la página para mostrarlo
            if(!empty($_GET['pax'])){
            $contenido = 'http://es.wikipedia.org/w/api.php?action=parse&prop=text&format=xml&redirects&page='.urlencode($_GET['pax']);
                $pagina = file_get_contents($contenido);
                echo 
                '<hr>
                    <div>
                        <h3>'.$_GET['pax'].'</h3>';

                echo htmlspecialchars_decode($pagina).'</div>';
            }
        }


    ?>

    <script>

        let lat =  "<?php echo $lat?>";
        let lng =  "<?php echo $lng?>";
        
        document.getElementById('map').innerHTML = "";
        
        let map = new ol.Map({
            layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
            target: 'map',
            view: new ol.View({
                projection: 'EPSG:4326',
                center: [lng, lat],
                zoom: 16
            })
        })

        
        $("#info").click(function() {
            $("#informacion").toggle();
        })
        
        
    </script>
</body>
</html>