<?php
    include 'Vehiculo.php';
    session_start();
    if(!isset($_SESSION['marcaDeControl'])){
        session_regenerate_id(true);
        $_SESSION['marcaDeControl'] = true;
    }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flota vehículos</title>
    <style>
        form{
            margin: 0 auto;
            width: 200px;

        }
        #botones{
            display: flex;
            flex-direction: column;
            align-items: center;

        }
        table{
            margin: 0 auto;
            margin-top: 20px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
            text-align: center;

        }

        tr, td{
            border-collapse: collapse;
            border: 1px solid black;
            padding: 5px;
        }

    </style>
</head>
<body>
    <?php
        /**5. Vamos a hacer una página web que nos permita gestionar una flota de vehículos, que iremos guardando en un array y
         * podremos guardar en un fichero empleado serialize.
         * 
         * Define una clase Vehículo.php que tengan como propiedades private la matrícula, modelo, kms. La clase vehículo deberá tener 
         * los siguientes métodos:
         *      - Un constructor que reciba matrícula, modelo y kms como argumentos y guarde esos valores.
         *      - getMatricula(), getModelo(), getKms().
         *      - muestraEnTr(): debe devolver una cadena de texto poniendo cada propiedad dentro de un <td>, formando una fila de tabla en HTML.
         * 
         * En nuestra página tendremos un formulario para introducir vehículos nuevos: matrícula, modelo kms que llamará a la misma página, para crear
         * un vehículo nuevo y mostrará debajo del formulario todos los vehículos del array en una tabla.
         *      - Guardaremos todos los vehículos creados en una variable $_SESSION['flota'] que será un array de vehículos.
         *      - Añadiremos un botón GUARDAR en FICHERO que permita guardar en un fichero flota.txt el array completo.
         *      - Añadiremos un botón RECUPERAR FICHERO que permita recuperar el array de objetos desde el fichero flota.txt.
         *      - Tendremos también un botón Cerrar Sesión que cerrará la sesión y hará que el array, y también la tabla no tenga ningún vehículo.
         */



        //Función para cerrar la sesión activa.
        function cerrarSesion(){
            session_unset();
            session_destroy();
        }

        //Función para guardar los vehículos.
        function guardarVehiculo () {
            $matricula = htmlentities(strtoupper($_POST['matriculaTxt']));
            $modelo = htmlentities($_POST['modeloTxt']);
            $kms = htmlentities($_POST['kmsNb']);

            if(!empty($matricula) || !empty($modelo)){
                $coche = new Vehiculo($matricula, $modelo, $kms);
                array_push($_SESSION['coches'], $coche);
            }
            
        }

        //Función para cargar la tabla con los vehículos.
        function cargarTabla($arrayCoches){
            if(!empty($arrayCoches)){
                echo "<table>
                        <th>Matrícula</th>
                        <th>Modelo</th>
                        <th>Kms</th>";
                foreach ($arrayCoches as $coche) {
                    echo $coche->mostraEnTR();
                }
                echo "</table>";
            }
                    
        }


        function serializar() {
            file_put_contents("flota.txt",serialize($_SESSION['coches']));
            
        }

        
        //Función para recuperar desde el fichero.
        function recuperarDatos() {  
            if(file_exists('flota.txt')){              
                $array = file_get_contents('flota.txt');
                $objetos = unserialize($array);
                $arrayCoches = [];
                    foreach($objetos as $coche){
                        array_push($arrayCoches, $coche);
                    }
                
                //De esta manera no perdemos datos.
                $_SESSION['coches'] = $arrayCoches;
                    
            }else{
                echo "<script>alert('Todavía no se ha creado el fichero');window.location.href='flotaVehiculos.php';</script>";
            }
            cargarTabla($arrayCoches);
        }

    
    ?>
    
    <form action="flotaVehiculos.php" method="POST">
        <fieldset>
            <legend>Datos del vehículo</legend>
            <label for="matricula">Matrícula: </label>
            <input type="text" name="matriculaTxt" pattern="^[\d]{4}[A-z]{3}$" title="formato 0000ABC" placeholder="Introduce la matrícula matrícula"><br>
            <label for="modelo">Modelo: </label>
            <input type="text" name="modeloTxt" pattern="^[\w\s?]{4,30}$" placeholder="Introduce el modelo"><br>
            <label for="kms">Kms: </label>
            <input type="number" name="kmsNb" min="0" max="999999">
        </fieldset>
        <div id="botones">
            <input type="submit" value="Guardar en fichero" name="guardarBtn"><br>
            <input type="submit" value="Recuperar de fichero" name="recuperarBtn"><br>
            <input type="submit" value="Cerrar Sesion" name="cerrarBtn">
        </div>
        
    </form>
    
        <?php
             if(!isset($_SESSION['coches'])){
                $_SESSION['coches'] = [];
            } 
        
            if(isset($_POST['guardarBtn'])){
                guardarVehiculo();
                cargarTabla($_SESSION['coches']);
                serializar();
                
        
            }else if(isset($_POST['recuperarBtn'])){
                recuperarDatos();
        
            }else if(isset($_POST['cerrarBtn'])){
                cerrarSesion();
        
            }
        ?>
</body>
</html>