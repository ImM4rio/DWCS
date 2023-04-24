<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vistaCliente</title>
</head>
<style>
    td, th{
        border: solid 1px black;

    }
    table{
        border-collapse: collapse;

    }

    form#modificarForm>[type="submit"]{
        border: 2px solid green;

    }

</style>
<body>
    <?php
        function mostrarTablaClientes($array) {
            echo "<table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                </tr>";

            foreach ($array as $value) {
                echo "<tr>
                        <td>{$value['nome']}</td>
                        <td>{$value['apelidos']}</td>
                        <td>{$value['email']}</td>
                    </tr>";
            }
            echo "</table>";
        }

        function modificarCliente() {
            echo '<form id="modificarForm" action="../controlador/clienteControlador.php" method="post">
                <input type="text" required pattern="[a-zA-Z\s]+" name="modificarNombreTxt" placeholder="Modificar nombre">
                <input type="text" required pattern="[a-zA-Z\s]+" name="modificarApellidosTxt" placeholder="Modificar apellidos">
                <input type="text" required name="modificarEmailEm" placeholder="Modificar por email">
                <input type="submit" name="modificarBtnForm" value="Modificar">
            </form>';
        }

    ?>

    <form action="../controlador/clienteControlador.php" method="post">
        <input type="submit" value="Listar todo" name="listarBtn"><br>
        <input type="text" name="nombreTxt" placeholder="Introduce el nombre">
        <input type="text" name="apellidosTxt" placeholder="Introduce los apellidos">
        <input type="email" name="emailEm" placeholder="Introduce el email">
        <input type="submit" value="Insertar registro" name="insertarBtn"><br>
        <input type="email" name="buscarEmailEm" placeholder="Introduce email para buscar registro">
        <input type="submit" name="buscarBtn" value="Buscar"><br>
        <input type="email" name="borrarEmailEm" placeholder="Introduce email para borrar registro">
        <input type="submit" name="borrarBtn" value="Borrar"><br>
        <input type="submit" name="modificarBtn" value="Modificar por email">

    </form>
</body>
</html>