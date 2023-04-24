<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api wikipedia</title>
    <style>
        img#newTab {
            width: 20px;
            height: 15px;
            background-color: lightgray;
            border:solid black 0.5px;
            margin-bottom: -0.5px;
            margin-left: 5px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div>
        <form method="get">
            <label for="termo">Termo de busca: </label>
            <input type="text" name="termo" id="termo" />
            <label for="idioma">Idioma: </label>
            <select name="idioma" id="idioma">
                <option value="en">Inglés</option>
                <option value="es">Español</option>
                <option value="gl">Gallego</option>
            </select>
            <label for="Páxinas a visualizar: "></label>
            <input type="number" name="paxinasNum" id="paxinasNum">
            <input type="submit" value="Busca"/>
            
        </form>
    </div>

    <?php
        if(!empty($_GET['termo']) && !empty($_GET['idioma']) && !empty($_GET['paxinasNum'])) {
            if($_GET['idioma'] == 'en'){
                $url = 'http://en.wikipedia.org/w/api.php';
    
            }else if($_GET['idioma'] == 'es'){
                 $url = 'http://es.wikipedia.org/w/api.php';

            }else if($_GET['idioma'] == 'gl'){
                 $url = 'http://gl.wikipedia.org/w/api.php';

            }

            $url .= '?action=query';
            $url .= '&list=search';
            $url .= '&srlimit='.$_GET['paxinasNum'];
            $url .= '&format=xml';
            $url .= '&redirects';
            $url .= '&srsearch=' . urlencode($_GET['termo']);
            $lista_paxinas = file_get_contents($url);
            file_put_contents('paxina.xml', $lista_paxinas);

            echo
                '<hr>
                    <div>
                        <h3>Listado de páxinas co termo '.$_GET['termo'].'</h3>
                        <ul>';
            
            $xml = new SimpleXMLElement($lista_paxinas);
                foreach($xml->query->search->children() as $pax){
                    $params = 'termo='. $_GET['termo'].'&idioma='.$_GET['idioma'];
                    $params .= '&pax='. urlencode($pax['title']);

                    $curid = 'http://'.$_GET['idioma'].'.wikipedia.org/?curid='.$pax['pageid'];
    
                    echo "<li><a href='?$params'>" .$pax['title']."</a><a href='$curid' target='_blank'><img id='newTab' src='newTab.png' alt='Imaxe nova lapela' title='Abrir en nova lapela'></a></li>";
                    
                }
            
        }

            echo
                '</ul></div>';

        if(!empty($_GET['pax']) && $_GET['idioma']) {
            if($_GET['idioma'] == 'en'){
                $url = 'http://en.wikipedia.org/w/api.php';
    
            }else if($_GET['idioma'] == 'es'){
                 $url = 'http://es.wikipedia.org/w/api.php';

            }else if($_GET['idioma'] == 'gl'){
                 $url = 'http://gl.wikipedia.org/w/api.php';

            }
            $url .= '?action=parse';
            $url .= '&prop=text';
            $url .= '&format=xml';
            $url .= '&redirects';
            $url .= '&page=' .urlencode($_GET['pax']);

            $paxina = file_get_contents($url);
            echo 
                '<hr>
                    <div>
                        <h3>Contido da páxina '.$_GET['pax'].'</h3>';

            echo htmlspecialchars_decode($paxina).'</div>';
        }
        ?>
        
</body>
</html>