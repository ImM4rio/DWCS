<?php
    include_once 'traits/DatosPersona.php';
    class Cliente{
        use DatosPersona;

        public function __toString(){
            $this->mostrarValores();
            
        }

    }


?>