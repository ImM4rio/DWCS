<?php
namespace Clases;
use PDO;
class Operacions {
    /**
    * @soap
    * @param integer $id
    * @return string
    */
	public function nomeBici(float $id) :string { 
		$host = "dbex3";
          $baseDatos = "proba";
          $usuarioBD = "root";
          $contrasinalBD = "root";
          $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8";
           
          try{
             
              $conexion = new PDO($dsn, $usuarioBD, $contrasinalBD);
              
              $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $pdoStatement = $conexion->prepare("select nomeBici from bicicletas where id = :id");
              $pdoStatement->bindParam(':id',$id);
              $pdoStatement->execute();
              $primeiro = $pdoStatement->fetch(PDO::FETCH_ASSOC);
               $nome = $primeiro['nomeBici'];
          } catch(PDOException $error){
              return("Erro co nome da bici: mensaxe " . $error->getMessage());
          }
		return $nome;
	}
	/**
     * @soap
     * @param integer $id
     * @return float
     */
	public function prezo($id) {
		$host = "dbex3";
          $baseDatos = "proba";
          $usuarioBD = "root";
          $contrasinalBD = "root";
          $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8";
          try{
             
              $conexion = new PDO($dsn, $usuarioBD, $contrasinalBD);
              $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $pdoStatement = $conexion->prepare("select prezo from bicicletas where id = :id");
              $pdoStatement->bindParam(':id',$id);
              $pdoStatement->execute();
              $primeiro = $pdoStatement->fetch(PDO::FETCH_ASSOC);
               $prezo = $primeiro['prezo'];
          } catch(PDOException $error){
              return("Erro co prezo: mensaxe " . $error->getMessage());
          }

		return $prezo;
	}
     /**
     * @soap
     * @param  integer $id
     * @return string
     */
	public function rexistroCompleto($id)	{ 
          $host = "dbex3";
          $baseDatos = "proba";
          $usuarioBD = "root";
          $contrasinalBD = "root";
          $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8";
          try{
             
              $conexion = new PDO($dsn, $usuarioBD, $contrasinalBD);
              $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $pdoStatement = $conexion->prepare("select * from bicicletas where id = :id");
              $pdoStatement->bindParam(':id',$id);
              $pdoStatement->execute();
              $primeiro = $pdoStatement->fetch(PDO::FETCH_ASSOC);
               $rexistroCompleto = $primeiro['ID']." ".$primeiro['nomeBici']." ".$primeiro['prezo']." ".$primeiro['imaxe'];
          } catch(PDOException $error){
              return("Erro co prezo: mensaxe " . $error->getMessage());
          }

		return $rexistroCompleto;
	}

}