document.addEventListener('DOMContentLoaded', configureAjaxCalls);

function configureAjaxCalls() {
    document.getElementById('productosSl').addEventListener('change', listarProductos);

}

    function listarProductos() {
        let data = new FormData();
        data.append('valor', this.value);

        fetch('cargarDatos.php', {
            method: 'POST',
            body: data
        })

        .then(response => response.json())
        .then(data => {
            if(data.error){
                alert(data.error);
            }else{
                let tabla = `<tr><th>ID</th><th>Nombre</th><th>Nombre Corto</th><th>Descripción</th><th>PVP</th></tr>`;
                for(item of data) {
                    tabla += "<tr><td>"+item.id+"</td><td>"+item.nombre+"</td><td>"+item.nombre_corto+"</td><td>"+item.descripcion+"</td><td>"+item.pvp+"€</td></tr>";
                }

                document.getElementById("tabla").innerHTML = tabla;
            }
        })
        .catch(error => {
            alert("Error al cargar los datos.");
        })
    }