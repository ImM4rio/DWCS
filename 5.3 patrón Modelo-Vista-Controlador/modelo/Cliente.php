<?php
    class Cliente{
        protected $nombre;
        protected $apellidos;
        protected $email;

        public function __construct($nombre, $apellidos, $email){
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->email = $email;
        }

        //Getters y setters.
        public function getNombre(){
            return $this->nombre;
        }
        public function getApellidos(){
            return $this->apellidos;
        }
        public function getEmail(){
            return $this->email;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function setApellidos($apellidos){
            $this->apellidos = $apellidos;
        }
        public function setEmail($email){
            $this->email = $email;
        }

        public function mostrarCliente(){
            echo "Nombre: $this->nombre, Apellidos: $this->apellidos, email: $this->email <br>";
        }
        
    }
?>