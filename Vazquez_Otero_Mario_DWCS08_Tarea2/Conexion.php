<?php
    class Conexion extends PDO {
        private $host = 'localhost';
        private $db = 'tarea8.4';
        private $user = 'proba';
        private $pass = 'abc123.';
        private $dsn;

        public function __construct() {
            $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=UTF8";

            try{
                parent::__construct($this->dsn, $this->user, $this->pass);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch (PDOException $ex) {
                die("Se ha producido un error en la conexión con la base de datos; " .$ex->getMessage());
            }
        }
    }

?>