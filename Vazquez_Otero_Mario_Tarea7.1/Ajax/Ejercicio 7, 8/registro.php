<?php
   
    function validarNome($nome){
        return (strlen($nome) > 4);
    }
    
    function validarEmail($email){
        return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
    
    }
    
    function validarPasswords($pass1, $pass2) {
        if(trim($pass1) != trim($pass2)){
            return false;

        }else if(strlen($pass1) < 5){
            return false;

        }else if(preg_match('/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,64})/i', $pass1) == 0){
            return false;
        
        }else{
            return true;
        };
    
    }



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <?php
        $email = $_POST['mail'];
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];

        if(!validarNome($_POST['usuario'])){
            echo "<h1>El nombre debe tener más de 4 caracteres, reenviando a registro.php...</h1>";
            header("refresh:5; url= validacion.php");

        }else if(validarEmail($email != 1)){
            echo "<h1>El e-Mail no tiene un formato válido, reenviando a registro.php...</h1>";
            header("refresh: 4; url=validacion.php");

        }else if(!validarPasswords($pass, $pass2)){
            echo "<h1>Los passwords no coinciden, reenviando a registro.php...</h1>";
            header("refresh: 4; url=validacion.php");
        
        }else{
            echo
                "<p>
                    Nombre de usuario: ".$_POST['usuario']."<br>
                    Contraseña: ".$_POST['pass']."<br>
                    e-Mail: ".$_POST['mail']."<br>
                </p>";
        }


    ?>
</body>
</html>