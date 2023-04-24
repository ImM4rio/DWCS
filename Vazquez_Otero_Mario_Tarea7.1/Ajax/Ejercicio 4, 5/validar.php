<?php
    function validarNome($nome){
        return (strlen($nome) > 4);

    }
    
    function validarEmail($email){
        return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
    
    }
    
    function validarPasswords($pass1, $pass2) {
        if($pass1 != $pass2){
            echo "Las contraseñas no coinciden";
            return false;

        }else if(strlen($pass1) < 5){
            echo "Debe tener más de 5 caracteres";
            return false;

        }else if(preg_match('@[A-Z]@', $pass1) == 0){
            echo "La contraseña debe tener una mayúscula";
            return false;
        
        }else{
            return true;
        };
    
    }

?>