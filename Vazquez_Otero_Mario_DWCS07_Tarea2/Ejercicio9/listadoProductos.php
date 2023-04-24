<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado productos</title>
    <script src="listarProductos.js"></script>
</head>
<body>
    <table id="tabla">

    </table>
    <form action="">
        <select name="productos" id="productosSl">
            <?php
                require_once('cargarDatos.php');
                cargarSelect(conexion());
            ?>
        </select>
    </form>
</body>
</html>