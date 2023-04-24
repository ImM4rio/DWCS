<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmosaDatos</title>
</head>
<body>
    <form id="formulario">
        <label for="selectGroup">Indica una medición:</label>
        <select name="select" id="select">
            <option value="8">Temperatura</option>
            <option value="9">Presión</option>
            <option value="10">Humedad</option>
        </select><br>
        <label for="mediciones">Indica el número de mediciones: </label>
        <input type="number" name="numMed" id="numMed" placeholder="Número de mediciones" title="Número de mediciones">
        <button id="buscarBtn" onclick="return cargar()">Buscar mediciones</button>
        <button id="guardarBtn" onclick="return guardar()">Guardar datos</button>
    </form>
    <div id="lista"></div>
</body>

    <script>

        function listar(datos){
            let lista= `<h1>Tabla de mediciones</h1>`;
            lista = `<table><tr><th>IDMedición</th><th>Fecha / hora</th><th>Valor</th></tr>`;

            datos.datos.forEach(element => {
                lista += `<tr>
                            <td>${element.idmedicion}</td>
                            <td>${element.fechahora}</td>
                            <td>${element.valor}</td>
                        </tr>`;

            });
            lista += `</ul>`;

            document.getElementById('lista').innerHTML = lista;
        }

        function guardar() {
            let datos = new FormData(document.getElementById('formulario'));
            datos.append('boton', this.id);

            fetch('gardaDatos.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(err => {
                alert(err);
            })

            return false;
        
        }

        function cargar() {
            let datos = new FormData(document.getElementById('formulario'));
            datos.append('boton', this.id);

            fetch('colleDatos.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                listar(data);
            })
            .catch(err => {
                alert(err);
            })

            return false;
        }

        
    </script>
</html>