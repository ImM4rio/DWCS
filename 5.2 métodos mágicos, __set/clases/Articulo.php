<?php
    include_once 'interfaces/interface.php';
    class Articulo implements Comparar{
        private $id;
        private $nombre;
        private $precio;

            public function __construct($id, $nombre) {
                $this->id = $id;
                $this->nombre = $nombre;
                

            }

            public function __clone() {
                $this->id += 1;
                
            }

            public function __set($atributo, $valor){
                if(property_exists(__CLASS__, $atributo)){
                    $this->$atributo = $valor;

                }else{
                    echo "No existe el atributo de la clase Articulo: ". $atributo;
                }
                
            }

            public function __get($atributo) {
                if(property_exists(__CLASS__, $atributo)){
                    return $this->$atributo;
                
                }else{
                    echo "No existe el atributo de la clase Articulo: ". $atributo;

                }
            }
        
            
            public function __toString() {
                return $this->muestraArticulo();
                
            }
            

            
            public function muestraArticulo(){
                if(isset($this->precio)){
                    return "Artículo con id: " .$this->id. " y nombre: " .$this->nombre.' con precio '.$this->precio;

                }else{
                    return "Artículo con id: " .$this->id. " y nombre: " .$this->nombre;

                }
            
            }

            public function comparar($objeto){
                if($objeto instanceof Articulo){
                    if($this->precio > $objeto->precio){
                        echo "Este artículo tiene un precio mayor a ".$objeto->precio." <br>";
                    
                    }else if($this->precio == $objeto->precio){
                        echo "Este artículo tiene el mismo precio.<br>";
                    
                    }else{
                        echo "Este artículo tiene un precio menor a ". $objeto->precio."<br>";
                    }
                }else{
                    throw new Exception("No existe el objeto de la clase");
                }
            }

}

?>