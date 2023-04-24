<?php
    class Vehiculo {
        private $matricula;
        private $modelo;
        private $kms;
    
        //Constructor.
        public function __construct($matricula, $modelo, $kms) {
            
            $this->matricula = $matricula;
            $this->modelo = $modelo;
            $this->kms = $kms;
                   
            }
    
        //Getters y Setters.
        public function getMatricula() {
            return $this->matricula;
    
        }
    
        public function setMatricula($matricula) {
            if(preg_match("^[\d]{4}[A-Z]{3}$^", strtoupper($matricula))){
                $this->matricula = $matricula;
            }else{
                echo 'La matrícula debe tener un formato 0000AAA';
            }
        }
    
        public function getModelo() {
            return $this->modelo;
        }
    
        public function setModelo($modelo) {
            $this->modelo = $modelo;
        }
    
        public function setKms($kms) {
            if(is_numeric($kms)){
                $this->kms = $kms;
            }else{
                echo 'Los kms tienen que ser un número';
            }
        }

        public function getKms() {
            return $this->kms;
    
        }
    
        //Métodos
        public function mostraEnTR() {
            return '<tr>
                <td>'.$this->matricula.'</td>
                <td>'.$this->modelo.'</td>
                <td>'.$this->kms.'</td>
            </tr>';
        }
    }
?>