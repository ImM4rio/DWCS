<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lenguas diferentes</title>
    <style>
        form, h3{
            width: 50%;
            margin: 0 auto;
        }

    </style>

</head>
<body>
    <?php

        //Función que no recibe ningún parámetro y genera la cookie del idioma con el valor descrito por el formulario al aceptar.
        function generarCookie(){        
            $selected = $_POST['lenguaSelect'];
            switch ($selected) {
                case 'Galego':
                    //10 segundos para esta cookie, cuando se vuelva a la página habrá que volver a generarla.
                    setcookie('Lengua','Galego', time()+10);
                    break;
                case 'Castellano':
                    setcookie('Lengua', 'Castellano', time()+10);      
                    break;

                case 'English':
                    //Le he dado una hora y esta cookie, cada vez que se vuelva a la página indicará el párrafo en inglés.
                    setcookie('Lengua', 'English', time()+3600);
                    break;
            }
            
        }

        //Función que comprueba si hay cookie para la lengua o no y dado el caso devuelve true.
        function comprobarCookie() {
            if($_COOKIE != null){
                return true;

            }else{
                return false;
            }
        }

        //Función que muestra con echo el párrafo en función de la cookie.
        function mostrarP() {
            switch ($_COOKIE['Lengua']) {
                case 'Galego':
                    echo "<p><h3>Isto é un exemplo de un parágrafo en galego</h3></p>";
                    break;

                case 'Castellano':
                    echo "<p><h3>Este es un ejemplo de un párrafo en castellano</h3></p>";
                    break;

                case 'English':
                    echo "<p><h3>This is an example of a paragraph in english</h3></p>";
                    break;

            }
        }


        

        if(isset($_POST['aceptarBtn'])){
            generarCookie();
            header("refresh:0;url=lengua.php");
        
        }else{
            echo comprobarCookie() ? mostrarP() :"<p><h3>Seleccione un idioma para visualizar el párrafo</h3></p>";
        }
    ?>

    <form action="lengua.php" method="POST">
        <fieldset>
            <legend><?php $menu ?></legend>
            <label for="lengua"><?php $lengua ?></label>
            <select name="lenguaSelect">
                <option value="" hidden selected disabled>Idioma</option>
                <option value="Galego">Galego</option>
                <option value="Castellano">Castellano</option>
                <option value="English">English</option>
            </select>
        </fieldset>
        <label for="botones">
            <input class="aceptar" name="aceptarBtn" type="submit" value="Aceptar!">
        </label>
    </form>
</body>
</html>