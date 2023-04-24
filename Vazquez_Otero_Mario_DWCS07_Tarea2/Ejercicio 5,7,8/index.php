<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch</title>
    <style>
        table#tabla{
            margin: 0 auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #botones{
            margin: 0 auto;
            width: 100%;
            text-align: center;

        }

    </style>
</head>
<body>
    <table id="tabla"></table>
    <div id="botones">
        
    <button id="btn">Hacer conexión con Ajax</button>
    <button id="ordenadoMailBtn" name="ordenadoMailBtn">Listado ordenado por email</button><br>
    <button id="ordenarNombreBtn" name="ordenarNombreBtn">Listado ordenado por nombre</button><br>

    
    <form id="formulario" action="insertarVendedor.php">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombreTxt" id="nombreTxt"><br>
            <label for="email">Email</label>
            <input type="email" name="emailEm" id="emailEm"><br>
        </form>
        <button name="insertarBtn" id="insertarBtn">Insertar datos</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', configureAjaxCalls);

        function configureAjaxCalls() {
            document.getElementById('btn').addEventListener('click', function () {
                fetch('test.txt')
                    .then(ajaxPositive)
                    .catch(showError);

            });

            document.getElementById('insertarBtn').addEventListener('click', insertar);
            document.getElementById('ordenadoMailBtn').addEventListener('click', listaOrdenadaOpciones);
            document.getElementById('ordenarNombreBtn').addEventListener('click', listaOrdenadaOpciones);
        }

        function ajaxPositive(response) {
            console.log('response.ok: ', response.ok);

            if(response.ok) {
                response.text().then(showResult);

            }else{
                showError('status code: ' + response.status);
            }
        }

        function showResult(txt) {
            console.log('Mostrar respuesta: ', txt);

        }

        function showError(err) {
            console.log('Muestro error', err);
        
        }

        //Apartado 5.
        function listaOrdenado() {
            fetch("listaOrdenadoEmail.php")
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    let tabla = `<tr><th>Nombre</th><th>Email</th></tr>`;
                    for (let vendedor of data) {
                        tabla += "<tr><td>"+vendedor.nome+"</td><td>"+vendedor.email+"</td></tr>";
                    }
                document.getElementById("tabla").innerHTML = tabla;
                })
                .catch(error => {
                    alert("Error al crear el listado.");
                    
                });
        }


        function listaOrdenadaOpciones() {
            let data = new FormData();
            data.append('boton', this.id);
            
            fetch('listaOrdenadoEmail.php', {
                method: "POST",
                body: data
            })

            .then(response => response.json())
            .then(data => {
                console.log(data);
                let tabla = `<tr><th>Nombre</th><th>Email</th></tr>`;
                for (let vendedor of data) {
                    tabla += "<tr><td>"+vendedor.nome+"</td><td>"+vendedor.email+"</td></tr>";

                }
                document.getElementById("tabla").innerHTML = tabla;
            })
            .catch(error => {
                alert("Error al traer las tablas de la base de datos.");
                 
            })

        }



        function insertar() {
            let datos = new URLSearchParams(new FormData(document.getElementById('formulario')));
            fetch('insertarVendedor.php', {
                method: "POST",
                body: datos
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data.resultado == 'OK'){
                    alert("Registro añadido");
                
                }else if(data.resultado){
                        alert(data.resultado);
            
                }else{
                    alert(data.resultado);
                    alert("Problema al insertar el registro");
                }
            })

            .catch(error => {
                alert("Error al insertar los datos"+error);
            });
        }

    </script>
</body>
</html>