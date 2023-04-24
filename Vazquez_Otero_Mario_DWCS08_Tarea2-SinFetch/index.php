<?php
    if(isset($_POST['confirmarPedidoBtn'])){
        include_once 'Conexion.php';
        $conexion = new Conexion();
        $stmnt = $conexion->prepare("INSERT INTO pedidos(productos, comprador, fecha, precio) VALUES (:productos, :comprador, :fecha, :precio)");
        $fecha = date("Y/m/d H:i:s");
        $pedidosArray = $_POST['productos'];
        $pedidos = implode(',', $pedidosArray);

        if($stmnt->execute(array(
            ':productos' => $pedidos,
            ':comprador' => $_POST['nombrePedidoTxt'],
            ':fecha' => $fecha,
            ':precio' => $_POST['totalPedidoTxt']
        )) > 0){
            echo "<script>alert('Su pedido se ha procesado');</script>";

        };

        
        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="gestion.js"></script>
    <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css">
</head>
<body>
    <!--Primer formulario, donde cargo los datos directamente desde la base de datos -->
    <form id="productosForm" name="productosForm">
        <?php
            include_once 'Conexion.php';
                $conexion = new Conexion();

                $stmnt = $conexion->query('SELECT * FROM productos');
                $stmnt->execute();

                if($stmnt->rowCount() > 0){
                    echo
                        "<table id='productos'>
                            <tr>
                                <th></th>
                                <th>Nombre</th>  
                                <th>Foto</th>  
                                <th>Precio</th>  
                            </tr>";
                    while($fila = $stmnt->fetch()){
                        echo 
                            "<tr>
                                <td><input type='checkbox' value='".$fila['codProd']."'</td>
                                <td id='nombreProd'>".$fila['nombre']."</td>
                                <td class='tdImagen'><img class='productosImg' src='img/".$fila['foto']."' alt='Imagen del producto ".$fila['nombre']."'></td>
                                <td class='precio'>".$fila['precio']."</td>
                                <td><input placeholder='Introduce un número' type='number' name='cantidadNm' id='cantidadNm'></td>
                            </tr>";

                    }
                    
                    echo "</table>";
                }                
                
        ?>
        <div id="botones">
            <input type="button" id="productosFormBtn" value="Iniciar Pedido">
            <input type="reset" value="Borrar">
        </div>
    </form>
    <div id="pedidoFormDiv">
        <!--Segundo formulario, donde cargo los datos recogidos del primer formulario, datos que comprobaremos en js y más tarde en php -->
        <form id="pedidoForm" action="" method="POST">
            <fieldset id="pedidoFS">
                <legend><h2>Pedido</h2></legend>
                <h6>* Campos obligatorios</h6>
                <label>*Nombre: <input type="text" required name="nombreTxt" id="nombreTxt" placeholder="Introduce tu nombre"></label>
                <label>*CIF: <input type="text" required name="cifNm" id="cifNm" placeholder="CIF" title="12345678W"></label>
                <label>*Dirección: <input type="text" required name="direccionTxt" id="direccionTxt"></label>
                <label>*Teléfono de contacto: <input type="tel" required name="telefonoTel" id="telefonoTel" placeholder="Introduce tu teléfono"></label>
                <label>*Municipio: <select required name="municipioSl" id="municipioSl">
                    <option value="" selected="true" disabled>Escoge un municipio</option>
                    <option value="sdc">Santiago de Compostela</option>
                    <option value="am">Ames</option>
                </select></label>
                <input type="submit" value="Pedir!">
            </fieldset>
        </form>
    </div>
</body>
</html>