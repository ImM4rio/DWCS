<?php
    class Resta extends Calculo{
        //Constructor vacío que nos permite realizar la llamada sin necesidad de incorporar los argumentos.
        public function __construct(){
            
        }

        public function calcular() {
            if(isset($this->operando1) && isset($this->operando2)){
                $this->resultado = $this->operando1 - $this->operando2;
                         
            }
        }
    }
?>