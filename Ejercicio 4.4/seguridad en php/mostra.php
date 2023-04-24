<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Cross Site Scripting</title>
</head>
<body>
    <?php

    echo "<h3>Lo siguiente es el resultado de XSS</h3>";
        
        $nombre = $_POST['nombreTxt'];
        $comentario = $_POST['comentarioTxtA'];
        $comentarioSinEtiquetas = strip_tags($comentario);
        
        echo 'Hola ', $nombre, htmlentities($comentario), '<br>';
        echo 'Hola ', $nombre, $comentarioSinEtiquetas;
    ?>
</body>
</html>

