<?php
    abstract class Calculo{
        //Declaramos los atributos de clase con protected para que sean accesibles desde las clases hijas
        protected $operando1;
        protected $operando2;
        protected $resultado;

        /**Debido a que los constructores no son llamados implícitamente por las clases
        * hijas podemos declarar unos nuevos constructores para estas.*/
        public function __construct($operando1, $operando2){
            $this->operando1 = $operando1;
            $this->operando2 = $operando2;
        }

        public function setOperando1($operando1){
            $this->operando1 = $operando1;

        }

        public function setOperando2($operando2){
            $this->operando2 = $operando2;

        }

        public function getResultado(){
            return $this->resultado;


        }

        /**Declaramos el método mágico __isset para la comprobación de los atributos
         * en las clases heredadas  */
        public function __isset($atributo){
            return isset($this->$atributo);
        }

        public abstract function calcular();

    }



?>