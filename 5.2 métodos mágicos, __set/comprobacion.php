<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Comprobación</title>
    <style>
        div#parte{
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            text-align: center;
            width: 50%;
            margin: auto;
        }

    </style>
</head>
<body>
    <div id="parte">
        <?php
            foreach(glob("clases/*.php") as $archivo){
                include_once $archivo;
            }

            $pantalla = new Articulo(1, 'Pantalla');
            $pantalla2 = clone $pantalla;

            echo "<h4>Métodos mágicos</h4><p>__get para el nombre: $pantalla->nombre </p>";

            $pantalla->nombre = 'Gato';

            echo "<p>__get tras modificar el nombre con __set: $pantalla->nombre<br>$pantalla->apellido</p>";

            $pantalla2->nombre = 'Rato';
            
            echo "<p>Método __toString = $pantalla2</p>";
            echo "<p>Método __toString = $pantalla</p>";

        ?>
    </div>
    <div id="parte">
        <?php

            $multiplicacion = new Multiplicacion();
            $multiplicacion->setOperando1(5);
            $multiplicacion->setOperando2(7);
            $multiplicacion->calcular();
            echo "<h4>Métodos y clases abstractas</h4><p>El resultado de la multiplicación es: ".$multiplicacion->getResultado(). "<br>";

            $suma = new Suma();
            $suma->setOperando1(5);
            $suma->setOperando2(7);
            $suma->calcular();
            echo "El resultado de la suma es: ".$suma->getResultado(). "<br>";

            $resta = new Resta();
            $resta->setOperando1(5);
            $resta->setOperando2(7);
            $resta->calcular();
            echo "El resultado de la resta es: ".$resta->getResultado(). "<br></p>";
        ?>
    </div>
    <div id="parte">
        <?php 
            
            function mostrar(Coche $coche){
                echo $coche->consumir(). "<br>";
            }

            $cochegasolina = new CocheGasolina();
            $cocheelectrico = new CocheElectrico();
            $cochehidrogeno = new CocheHidrogeno();

            echo "<h4>Polimorfismo</h4>";
            mostrar($cochegasolina);
            mostrar($cocheelectrico);
            mostrar($cochehidrogeno);

        ?>
    </div>
    <div id="parte">
        <h4>Traits</h4>
        <?php
            foreach(glob('traits/*.php') as $archivo){
                include_once $archivo;
            }

            $cliente = new Cliente();
            $cliente->setNombre('nombreCliente');
            $cliente->setApellidos('apellidosCliente');
            $cliente->setEdad(99);
            $cliente->mostrarValores();

            echo "<br>";

            $vendedor = new Vendedor();
            $vendedor->setNombre('nombreVendedor');
            $vendedor->setApellidos('apellidosVendedor');
            $vendedor->setEdad(99);
            $vendedor->mostrarValores();
        ?>

    </div>
    <div id="parte">
            <h4>Interfaces</h4> 
            <?php
                $pantalla->precio = 2;  
                $pantalla2->precio = 4;
                $pantalla->comparar($pantalla2);
                $pantalla->comparar(2);

            ?>
    </div>
</body>
</html>