<?php
    class Bombilla {
        //propiedades
        private $potencia;
        public static $numBombillas = 0;

        public function __construct(){
            $this->potencia = 10;

            //Ejercicio 4.
            self::$numBombillas++;

        }

        //Setter y getters
        public function setPotencia($valor) {
            if($valor > 35){
                $this->potencia = 35;

            }else if($valor < 2){
                $this->potencia = 2;

            }else{
                $this->potencia = $valor;
            }
        }

        public function getPotencia() {
            return $this->potencia;
        }

        //métodos
        public function aumentarPotencia($val) {
            //Previene la entrada de números negativos, aunque también podríamos haciendo verificando la entrada con (> 0)
            $this->potencia + $val > 35 ? $this->potencia = 35 : ($this->potencia + $val < 2 ? $this->potencia = 2 : $this->potencia = $this->potencia + $val);

        }

        public function bajaPotencia($val) {
            $this->potencia - $val < 2 ? $this->potencia = 2 : ($this->potencia - $val > 35 ? $this->potencia = 35 : $this->potencia = $this->potencia - $val);

        }
    }
?>