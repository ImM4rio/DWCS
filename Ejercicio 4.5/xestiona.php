<?php
    session_start();
    if(!isset($_SESSION['marcaDeControl'])){
        session_regenerate_id(true);
        $_SESSION['marcaDeControl'] = true;
    }

    verUsuarios(conexion());
    verProductos(conexion());
    formProducto();

    if(isset($_POST['borrarBtn'])){
        borrarUsuario(conexion(), $_POST['checkbox']);

    }else if(isset($_POST['modificarBtn'])){
        modificarUsuario(conexion());

    }else if(isset($_POST['altaBtn'])){
        altaProducto(conexion());

    }else if(isset($_POST['borrarProdBtn'])){
        borrarProducto(conexion());

    }else if(isset($_POST['modificarProdBtn'])){
        modificarProducto(conexion());
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestiona</title>
    <link rel="stylesheet" href="estilos.css" type="text/css">
</head>
<body>
    <?php
        //Función para la conexión a la base de datos.
        function conexion() {
            $usuario = 'Mario';
            $pass = '1234';
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=tarea4.5;charset=UTF8', $usuario, $pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                } catch (PDOException $ex) {
                    echo "Error en la conexión a la base de datos: " .$ex->getMessage();
                }
            return $pdo;
        }

        //Función para ver los usuarios.
        function verUsuarios($conexion) {
            $stmnt = $conexion->prepare('SELECT * FROM usuarios');
            $stmnt->execute();
            if($stmnt->rowCount() > 0){
                echo "<form action='xestiona.php' method='POST'>
                    <table id='usuarios'>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>Contraseña</th>
                            <th>Mail</th>
                            <th>Rol</th>
                            <th>Fecha última conexión</th>
                        </tr>  ";
                while($fila = $stmnt->fetch()){
                    echo "<tr>
                            <td>".$fila['nome']."</td> 
                            <td>".$fila['nomeCompleto']."</td> 
                            <td>".$fila['contrasinal']."</td> 
                            <td>".$fila['email']."</td>";
                           
                            if($fila['nome'] == 'admin'){
                                echo "<td>".$fila['rol']."</td>"; 
                            
                            }else{
                                echo '<td>
                                        '.$fila['rol'].'
                                        <select name="'.$fila['nome'].'">
                                            <option value="" selected hidden>Escoge una opción</option>
                                            <option value="administrador">Administrador</option>
                                            <option value="usuario">Usuario</option>
                                        </select></td>';
                            }

                            echo "<td>".$fila['data']."</td>";

                            if($fila['nome'] != 'admin'){
                                echo "<td><input type='checkbox' name='checkbox[]' value='".$fila['nome']."'></td>";

                            }
                        echo "</tr>";
                }
                echo "</table>
                        <input type='submit' value='Modificar rol' name='modificarBtn'>
                        <input type='submit' value='Borrar usuario' name='borrarBtn'>
                    </form>";
            }
        }

        //Función que recibe el array de checkbox tras el submit junto con el objeto PDO.
        function borrarUsuario($conexion, $checkbox){
            $lista = implode(",", $checkbox);
            $stmnt = $conexion->prepare("DELETE FROM usuarios WHERE nome IN (:lista)");
            $stmnt->execute(array(
                ':lista' => $lista
            ));
            $rowsAffected = $stmnt->rowCount();
            echo "<script type='text/javascript'>alert('Han sido borradas ".$rowsAffected." fila/s');window.location.href='xestiona.php';</script>";
  
        }

        function modificarUsuario($conexion){
            $rolesCambiados = "";
            $rowsAffected = 0;

            $nombres = $conexion->prepare("SELECT nome, rol FROM usuarios");
            $nombres->execute();

            while($fila = $nombres->fetch()){
                if($fila['nome'] != 'admin' && $_POST[$fila['nome']] != "" && $fila['rol'] != $_POST[$fila['nome']]){
                    $stmnt =  $conexion->prepare("UPDATE usuarios SET rol = :rol WHERE nome = :nome");
                    $stmnt->execute(array(
                        ':rol' => $_POST[$fila['nome']],
                        ':nome' => $fila['nome']
                    ));
                    $rolesCambiados .= $fila['nome']. " ";
                    $rowsAffected = $stmnt->rowCount();
                }
            }
            if($rowsAffected > 0){
                echo "<script type='text/javascript'>alert('Se han cambiado los roles de ".$rolesCambiados."');window.location.href='xestiona.php';</script>";
           
            }

        }

        //Función para ver los productos.
        function verProductos($conexion) {
            $stmnt = $conexion->prepare("SELECT * FROM produto");
            $stmnt->execute();
            if($stmnt->rowCount() > 0){
                echo "<form action='xestiona.php' method='POST'>
                    <table id='productos'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                        </tr>";

                while($fila = $stmnt->fetch()){
                    echo "<tr>
                            <td>".$fila['idProduto']."</td>
                            <td>".$fila['nome']."</td>
                            <td>".$fila['descricion']."</td>
                            <td>".$fila['prezo']."</td>
                            <td><img src='imaxes/".$fila['imaxe']."' alt='imagen de un tomate rojo' width='50px'></td>
                        </tr>";
                    
                }
                echo "</table>";
                
            }
            
            
        }

        //Función para el formulario de alta de producto.
        function formProducto() {
            echo '<fieldset>
                    <legend>Introduzca solamente el nombre si desea borrar un producto</legend>
                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombreTxt" placeholder="Introduce el nombre" required><br>
                </fieldset>
                <fieldset>
                    <legend>Introduzca además el resto de datos para añadir o modificar un producto</legend>
                    <label for="descripcion">Descripción: </label>
                    <input type="text" name="descripcionTxt" placeholder="Introduce la descripción"><br>
                    <label for="prezo">Precio: </label>
                    <input type="number" name="precioNb" min="0" placeholder="Introduce el precio"><br>
                    <label for="imagen">Imagen: </label>
                    <input type="text" name="imagenTxt" placeholder="Introduce el nombre de la imagen"><br>
                </fieldset>
                    <input type="submit" value="Alta" name="altaBtn">
                    <input type="submit" value="Modificar producto" name="modificarProdBtn">
                    <input type="submit" value="Borrar producto" name="borrarProdBtn">
                </form><a href="pechaSesion.php">Cerrar sesión</a>';

        }

        //Función para dar de alta el producto.
        function altaProducto($conexion){
            $id = $conexion->prepare("SELECT max(idProduto) as maximo FROM  produto");
            $id->execute();
            $ultimoID = 0;

            if($id->rowCount() > 0){
                while($fila = $id->fetch()){
                    $ultimoID = $fila['maximo'];
                }
            }

            $stmnt = $conexion->prepare("INSERT INTO produto (idProduto, nome, descricion, prezo, imaxe) VALUES (:id, :nome, :descricion, :prezo, :imaxe)");
            $stmnt->execute(array(
                ':id' => $ultimoID + 1,
                ':nome' => htmlentities($_POST['nombreTxt']),
                ':descricion' => htmlentities($_POST['descripcionTxt']),
                ':prezo' => htmlentities($_POST['precioNb']),
                ':imaxe' => htmlentities($_POST['imagenTxt'])
            ));

            echo "<script type='text/javascript'>alert('El producto ".$_POST['nombreTxt']." se ha añadido');window.location.href='xestiona.php';</script>";

        }

        //Función para borrar productos.
        function borrarProducto($conexion){
            $stmnt = $conexion->prepare("DELETE FROM produto WHERE nome = :nome");
            $stmnt->execute(array(
                ':nome' => htmlentities($_POST['nombreTxt'])
            ));

            if($stmnt->rowCount() > 0){
                echo "<script type='text/javascript'>alert('El producto ".$_POST['nombreTxt']." se ha eliminado');window.location.href='xestiona.php';</script>";
            }
        }

        //Función para modificar un producto.
        function modificarProducto($conexion){
            $stmnt = $conexion->prepare("UPDATE produto SET descricion = :descricion, prezo = :prezo, imaxe = :imaxe WHERE nome = :nome");
            $stmnt->execute(array(
                ':descricion' => htmlentities($_POST['descripcionTxt']),
                ':prezo' => htmlentities($_POST['precioNb']),
                ':imaxe' => htmlentities($_POST['imagenTxt']),
                ':nome' => htmlentities($_POST['nombreTxt'])
            ));

            if($stmnt->rowCount() > 0){
                echo "<script type='text/javascript'>alert('El producto ".$_POST['nombreTxt']." se ha modificado');window.location.href='xestiona.php';</script>";
            }

        }
    ?>
</body>
</html>