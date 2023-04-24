<?php
    require_once('../modelo/clienteModelo.php');
    require_once('../vista/vistaCliente.php');

    if(isset($_POST['listarBtn'])){
        $clientes = clienteModelo::getRegistros();

        while($fila = $clientes->fetch()){
            $clienteArray[] = $fila;
        }
        mostrarTablaClientes($clienteArray);

    }else if(isset($_POST['insertarBtn'])){
        $cliente = new clienteModelo($_POST['nombreTxt'], $_POST['apellidosTxt'], $_POST['emailEm']);
        $cliente->guardar();

    }else if(isset($_POST['buscarBtn'])){
        $cliente = clienteModelo::buscar($_POST['buscarEmailEm']);
        while($fila = $cliente->fetch()){
            $clienteArray[] = $fila;
        }
        mostrarTablaClientes($clienteArray);
    
    }else if(isset($_POST['borrarBtn'])){
        $cliente = clienteModelo::borrar($_POST['borrarEmailEm']);

        if($cliente){
            echo "<script>alert('Se ha borrado el cliente con el mail {$_POST['borrarEmailEm']}.');window.location.href='../vista/vistaCliente.php';</script>";

        }else{
            echo "<script>alert('Error al borrar el cliente con el mail {$_POST['borrarEmailEm']}.');window.location.href='../vista/vistaCliente.php';</script>";

        }

    }else if(isset($_POST['modificarBtn'])){
        modificarCliente();

    }else if(isset($_POST['modificarBtnForm'])){
        $borrar = clienteModelo::modificar($_POST['modificarNombreTxt'], $_POST['modificarApellidosTxt'], $_POST['modificarEmailEm']);
        if($borrar->rowCount() > 0){
            echo "<script>alert('Se ha modificado el registro con el mail {$_POST['modificarEmailEm']}');window.location.href='';</script>";
        }else{
            echo "<script>alert('No se ha modificado el registro con el mail \"{$_POST['modificarEmailEm']}\", por favor, verifique el email e inténtelo de nuevo.');window.location.href='';</script>";

        }
    }
?>