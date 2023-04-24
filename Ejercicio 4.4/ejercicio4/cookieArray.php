<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cookieArray</title>
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

        //Función que añade las variables del formulario a la cookie user.
        function anadirCookie(){
            $nombre = $_POST['nombreTxt'];
            $apellido = $_POST['apellidoTxt'];
            $mail = $_POST['mail'];

            setcookie('user[nombre]', ''.$nombre.'', time()+3600);
            setcookie('user[apellido]', ''.$apellido.'',time()+3600);
            setcookie('user[email]', ''.$mail.''. time()+3600);

            
        }


        //Función que muestra la cookie user recorriendo sus valores
        function mostrarCookie(){
            
            if(!empty($_COOKIE['user'] ) ) {
                foreach ($_COOKIE['user'] as $key=>$value){
                echo "$key : $value <br>";
                }
            }
        }


        echo comprobarCookie() ? mostrarCookie() : "";
        if(isset($_POST['aceptarBtn'])){
            anadirCookie();
            header("refresh:0; url=cookieArray.php");
        
        }

    ?>
</body>
</html>