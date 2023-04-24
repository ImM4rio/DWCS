<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        form{
            margin: 0 auto;
            width: 20%;
            margin-top: 20px;
        }

        h3{
            margin: 0 auto;
            font-size: large;
            text-align: center;
        }

        .botones{
            display: flex;
            justify-content: flex-end;

        }
        
        .botones > input{
            font-weight: bold;
        }

        .botones > input.aceptar:hover{
            background-color: lawngreen;
            transition: 1s ease-in-out;
            

        }

        .botones > input.borrar:hover{
            background-color: red;
            transition: 1s ease-in-out;
        }

    </style>
    <title>Cookies</title>
</head>
<body>
    <?php

        //Función que comprueba si existe alguna cookie y devuelve true o false.
        function comprobarCookie(){
            if($_COOKIE != null){
                return true;

            }else{
                return false;

            }
        }

        //Función que recoge los datos del formulario y crea una cookie para la siguiente hora.
        function anadirCookie(){
            $nombre = $_POST['nombreTxt'];
            $valor = $_POST['valorTxt'];

            setcookie(''.$nombre.'', ''.$valor.'', time()+3600);
            
        }

        //Función que muestra las cookies añadidas desde el formulario alojadas en la variable $_COOKIE.
        function mostrarCookie() {
            foreach ($_COOKIE as $nombre=>$valor){
                    echo "$nombre : $valor <br>";
                }
        }
        
        
    ?>
</body>
    <form action="cookies.php" method="POST">
        <fieldset>
            <legend><h3>Añade una nueva Cookie</h3></legend>
            <label for="nombre">Nombre de la cookie:</label><br>
            <input type="text" name="nombreTxt" placeholder="Introduce nombre" required pattern="^[\w\dñ]{1,20}$"><br>
            <label for="valor">Valor de la cookie: </label><br>
            <input type="text" name="valorTxt" placeholder="Introduce el valor" pattern="^[\w\d\ñ]{1,20}$"><br>
        </fieldset>
        <label class="botones" for="botones">
            <input class="aceptar" name="aceptarBtn" type="submit" value="Aceptar!">
            <input class="borrar" type="reset" value="Borrar">
        </label>
    </form>

    <?php
        echo comprobarCookie() ? mostrarCookie() : "Todavía no hay ninguna COOKIE";
        
        if(isset($_POST['aceptarBtn'])){
            anadirCookie();
            header("refresh:0;url=cookies.php");
            
        }
    
    ?>

</html>