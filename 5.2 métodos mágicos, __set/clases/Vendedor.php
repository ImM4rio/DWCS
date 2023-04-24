<?php
    include_once 'traits/DatosPersona.php';
    class Vendedor{
        use DatosPersona;

        public function __toString(){
            $this->mostrarValores();
        }
    }
?>