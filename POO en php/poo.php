<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objetos</title>
</head>
<body>
    <?php

        /**1. Crea una clase Contactyo, con propiedades privadas: nombre, apellidos, tlfno.
         * Define un constructor con 3 argumentos, que asigne los valores a las propiedades */

        include 'Contacto.php';

        $contacto1 = new Contacto('mario', 'vazquez otero', '649963645');
        $contacto2 = new Contacto('yani', 'guerrero sergi', '612123123');
        $contacto3 = new Contacto('elisa', 'valverde pereiro', '623234234');

        echo '<p>Nombre del primer contacto: ' .$contacto1->getNombre(). '<br>';
        echo 'Apellidos del primer contacto: ' .$contacto1->getApellidos(). '<br>';
        echo 'Teléfono del primero contacto:' .$contacto1->getTlfn(). '<br>';
        echo 'Información del primer contacto ' .$contacto1->mostrarInformacion(). '</p>';

        echo '<p>Nombre del segundo contacto: ' .$contacto2->getNombre(). '<br>';
        echo 'Apellidos del segundo contacto: ' .$contacto2->getApellidos(). '<br>';
        echo 'Teléfono del segundo contacto:' .$contacto2->getTlfn(). '<br>';
        echo 'Información del segundo contacto ' .$contacto2->mostrarInformacion(). '</p>';

        echo '<p>Nombre del tercer contacto: ' .$contacto3->getNombre(). '<br>';
        echo 'Apellidos del tercer contacto: ' .$contacto3->getApellidos(). '<br>';
        echo 'Teléfono del tercer contacto:' .$contacto3->getTlfn(). '<br>';
        echo 'Información del tercer contacto ' .$contacto3->mostrarInformacion(). '</p>';
        
        /**3. Define ahora una clase Bombilla que tenga como atributo privado su potencia. Define un constructor que asigne por defecto su potencia a 10.
         * Define ahora 2 métodos setPotencia($valor) que asigne a la variable potencia, ese valor, y getPotencia(), que devuelva la potencia del objeto.
         * Define también 2 métodos más, aumentaPitencia($val) que aumente la potencia en el valor $val y bajaPotencia($val) que baje la potencia en ese valor.
         * Controla:
         *      - Los valores tienen que estar entre 2 y 35W: si nos pasamos, quedará en 35, si bajamos demás la potencia quedará en 2.
         * Crea un objeto y comprueba que todo funciona: asigna 60, sube 50, baja 10, asigna 10 y baja 20, revisando cada vez el valor de la potencia.
         */

        include 'Bombilla.php';

        $bombilla = new Bombilla();
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';
        $bombilla->setPotencia(60);
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';
        $bombilla->aumentarPotencia(50);
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';
        $bombilla->bajaPotencia(10);
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';
        $bombilla->setPotencia(10);
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';
        $bombilla->bajaPotencia(10);
        echo 'La bombilla tiene una potencia de <b>'.$bombilla->getPotencia().'W</b><br>';

        /**4. Modifica la clase bombilla creada en el ejercicio anterior de manera que tenga una variable estática llamada numBombillas,
         * en la que se lleve la cuenta de las bombillas que se van creando. Haz los siguientes pasos:
         *      - Crea una bombilla, aumenta 20 y muestra su potencia.
         *      - Muestra cuantas bombillas hay accediendo a numBombillas.
         *      - Elimina bombilla y muestra cuántas bombillas hay.
         *      - Reduce la potencia de bombilla2 en 10 y muestra su potencia.
         */

        $bombilla1 = new Bombilla();
        $bombilla1->aumentarPotencia(20);
        echo '<p>La potencia de la bombilla1 es de: <b>'.$bombilla1->getPotencia().'W</b> y hay un total de <b>'.Bombilla::$numBombillas.'</b> bombilla/s.</p>';

        $bombilla2 = new Bombilla();
        $bombilla2->aumentarPotencia(30);
        echo '<p>La potencia de la bombilla2 es de: <b>'.$bombilla1->getPotencia().'W</b> y hay un total de <b>'.Bombilla::$numBombillas.'</b> bombilla/s.</p>';

        unset($bombilla1);
        Bombilla::$numBombillas--;
        echo '<p>Hay un total de <b>'.Bombilla::$numBombillas.'</b> bombilla/s.</p>';

        $bombilla2->bajaPotencia(10);
        echo '<p>La potencia de la bombilla2 es de: <b>'.$bombilla2->getPotencia().'W</b> y hay un total de <b>'.Bombilla::$numBombillas.'</b> bombilla/s.</p>';


        
    ?>
</body>
</html>