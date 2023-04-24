<?php
    trait DatosPersona{
        private $nombre;
        private $apellidos;
        private $edad;


        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setApellidos($apellidos){
            $this->apellidos = $apellidos;
        }

        public function getApellidos(){
            return $this->apellidos;
        }

        public function setEdad($edad){
            $this->edad = $edad;
        }

        public function getEdad(){
            return $this->edad;
        }

        public function mostrarValores(){
            echo 'Esta persona es un ' .__CLASS__. ' con nombre ' .$this->getNombre().' '.$this->getApellidos().' con '.$this->getEdad().' años.';
        }
    }

?>