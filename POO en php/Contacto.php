<?php
    class Contacto {
        //propiedades
        private $nombre;
        private $apellidos;
        private $tlfno;


        //constructor
        public function __construct($nombre, $apellidos, $tlfno) {
            $this->nombre = ucwords($nombre);
            $this->apellidos = ucwords($apellidos);

            if(strlen(substr($tlfno, 3)) == 6 && is_numeric($tlfno) == true) {
            $this->tlfno = $tlfno;
            }

        }
            
        //métodos getter y setter
        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre($nombre) {
            $this->nombre = ucwords($nombre);
        }

        public function getApellidos() {
            return $this->apellidos;
        }

        public function setApellidos($apellidos) {
            $this->apellidos = ucwords($apellidos);
        }

        public function getTlfn() {
            return $this->tlfno;
        }

        public function setTlfno($tlfno) {
            if(strlen(substr($tlfno, 3)) == 6 && is_numeric($tlfno) == true) {
                $this->tlfno = $tlfno;

            }                
        }

        //métodos
        public function mostrarInformacion() {
            return 'Nombre: ' .$this->nombre. ' Apellidos: ' .$this->apellidos. ' Teléfono: ' .$this->tlfno;
        }


        /**2. Añade un método __destruct(), que muestre por pantalla que cada objeto está siendo destruído */
        public function __destruct() {
            echo '<p>El contacto con nombre '.$this->nombre.' está siendo destruído.</p>';
        }
    }
?>