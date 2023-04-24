<?php

use clienteModelo as GlobalClienteModelo;

    include_once('Conexion.php');
    include_once('Cliente.php');

    class clienteModelo extends Cliente{

        public function __construct($nombre, $apellidos, $email){
            parent::__construct($nombre, $apellidos, $email);

        }


        //Insertar.
        public function guardar(){
            $conexion = new Conexion();

            try{
                $stmnt = $conexion->prepare('INSERT INTO clientes(nome, apelidos, email) VALUES (:nombre, :apellidos, :email)');
                if($stmnt->execute(array(
                    ':nombre' => $this->nombre,
                    ':apellidos' => $this->apellidos,
                    ':email' => $this->email
                ))){
                    echo "<script>alert('Se ha guardado un nuevo cliente en la tabla.');window.location.href='../vista/vistaCliente.php';</script>";

                }

            }catch(PDOException $e){
                die("Error en la inserción: " .$e->getMessage());
            }
            $conexion = null;
        }


        //Devuelve registros que retorna un objeto del tipo PDOStatement.
        public static function getRegistros() : PDOStatement {
            $conexion = new Conexion();
            try{
                $query = "SELECT * FROM clientes";
                $stmnt = $conexion->query($query);

            }catch (PDOException $e){
                die("Error al rescatar los registros de la base da datos: " .$e->getMessage());
            }
            return $stmnt;
        }

        //Buscar por el email
        public static function buscar($email) : PDOStatement{
            $conexion = new Conexion();
            try{
                $stmnt = $conexion->prepare('SELECT * FROM clientes WHERE email = :email');
                $stmnt->execute(array(
                    ':email' => $email
                ));

            }catch(PDOException $ex) {
                die('Error al buscar el registro para el email ' .$email. ': ' .$ex->getMessage());

            }
            return $stmnt;

        }
        
        //Borrar por el email
        public static function borrar($email) : PDOStatement {
            $conexion = new Conexion();
            try{
                $stmnt = $conexion->prepare('DELETE FROM clientes WHERE email = :email');
                $stmnt->execute(array(
                    ':email' => $email
                ));

            }catch(PDOException $ex) {
                die('Error al borrar el registro para el email ' .$email. ': ' .$ex->getMessage());

            }
            return $stmnt;
        }

        //Actualizar cliente identificado por su email.
        public static function modificar($nombre, $apellidos, $email) : PDOStatement {
            $conexion = new Conexion();

            $stmnt = $conexion->prepare('UPDATE clientes SET nome = :nombre, apelidos = :apellidos WHERE email = :email');
            $stmnt->execute(array(
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':email' => $email
            ));

            return $stmnt;         
        }
    }
?>
