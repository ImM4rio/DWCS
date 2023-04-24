document.addEventListener('DOMContentLoaded', function() {

    //Gestión de eventos.
    $('#productosFormBtn').click(showForm);
    $('#productosFormBtn').click(mostrarPedido);
    $('input[type=checkbox]').change(comprobarMinimo);




    /**
     * Método que muestra y quita el formulario de pedido.
     * Si el display de este formulario no está en "none" el valor del submit es distinto.
     * Si el display está en "none" el valor se setea al valor inicial.
     */
    function showForm() {
        $('#pedidoForm').toggle();
       if($('#pedidoForm').css('display') != 'none'){
           $('#productosFormBtn').attr('value', 'Atrás');

       }else if($('#pedidoForm').css('display') == 'none'){
        $('#productosFormBtn').attr('value', 'Iniciar pedido');
       }


    }

    /**
     * Función para la comprobación de los datos que además comprueba si se ha seleccionado algún objeto
     * @returns boolean
     */
    function comprobar() {
        let DNI = $('#cifNm').val();
        let tlfn = $('#telefonoTel').val();
        

        let cifRegex = /^[\d]{8}[A-Z]{1}$/;
        let telRegex = /^[9,6,8]{1}[\d]{8}$/;

        if(!cifRegex.test(DNI)) {
            alert("Ajústese al formato delimitado para el DNI");
            return false;

        }else if(!telRegex.test(tlfn)) {
           alert("Ajústese al formato solicitado para el teléfono");
            return false;

        }else if($('input[type=checkbox]:checked').length == 0){
            alert('Escoja algún producto');
            return false;

        }else{
            return true;
            
        }

    }


    /**
     * Función que tras checkear un ítem, setea el valor del número de ítems para esa fila a 1
     * Por el contrario, si se deschecka setea el valor a 0
     */
    function comprobarMinimo () {
        if($(this).closest('tr').find(':input[type="number"]').val() == 0) {
            $(this).closest('tr').find(':input[type="number"]').val(1);
        
        }else if($(this).closest('tr').find(':input[type="number"]').val() > 0 && !$(this).is(':checked')) {
            $(this).closest('tr').find(':input[type="number"]').val(0);
        }
    }

    /**
     * Función que muestra en el formulario un resumen del pedido completo.
     * @returns Array de productos.
     */
    function mostrarPedido() {
        let productosArray = [];

        $('input[type=checkbox]:checked').each(function () {
            producto = {nombre: $(this).closest('tr').find('#nombreProd').text(), cantidad: $(this).closest('tr').find(':input[type="number"]').val(), imagen: $(this).closest('tr').find('.tdImagen img').attr('src'), precio: $(this).closest('tr').find('.precio').text()};
            productosArray.push(producto);
        });
        $('#resumenFs').remove();

        let pedido = `<fieldset id="resumenFs"><legend>Resumen de pedido</legend>`;

        if(productosArray.length == 0){
            pedido += `<h3>Ningún producto seleccionado</h3>`;
        }


        productosArray.forEach(producto => {
            if(producto['cantidad'] == 0){
                alert(`Añada una cantidad para el producto ${producto['nombre']}`);
            }else{
                pedido += `<div id="resumenPed"><img class="imgPedido" src="${producto['imagen']}" alt="Imagen del producto"/> - ${producto['nombre']} - ${producto['cantidad']} uds - Total = ${producto['precio'] * producto['cantidad']}€</div>`;

            }
        });

        pedido += `</fieldset>`;

        
        $('#pedidoFS').append(pedido);

        return productosArray;
        
    }


    /**
     * Función para la impresión del mapa con los valores devueltos por el servidor.
     * @param {json} data 
     */
    function resumenMapa(data) {
        
        $('body').empty();
        $('body').append('<div id="map"></div>');
        let map = new ol.Map({
            layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
            target: 'map',
            view: new ol.View({
                projection: 'EPSG:4326',
                center: [data.lng, data.lat],
                zoom: 16
            })
        })
        

        $("#map").append(map);

        
    }

    /**
     * Función para impresión del resumen del pedido debajo del mapa junto con el formulario de confirmación con los datos devueltos por el servidor.
     * @param {json} data 
     */
    function resumenPedido(data) {
        let pedido =`<form action="index.php" method="POST">
                <fieldset><legend><h3>Resumen del pedido: </h3><legend>
                    <table id="resumen">
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="nombrePedidoTxt" readonly value="${data.nombre}"></td>
                            <td><input type="text" name="dniPedidoTxt" readonly value="${data.dni}"></td>
                            <td><input type="text" name="direccionPedidoTxt" readonly value="${data.direccion}"></td>
                            <td><input type="text" name="telefonoPedidoTxt" readonly value="${data.telefono}"></td>
                        </tr>`;
                            
        let total = 0;
        //Parseamos el JSON con el array de los productos para poder iterar sobre él.
        let productosArray = JSON.parse(data.productosArray);
        productosArray.forEach(producto => {
            pedido += `
                <tr>
                    <td colspan=4><input type="text" name="productos[]" readonly value="${producto['nombre']}"> <input type="text" readonly value="${producto['cantidad']}"> uds`;
            
                total += producto.cantidad * producto.precio;
            pedido +=`
                    </td>
                </tr>`;
        });

        pedido += `<tr>
                    <td colspan="4"><input type="text" name="totalPedidoTxt" readonly value="${total}">€</td>
                    </tr>
                    </table>
                    <input type="submit" name="confirmarPedidoBtn" value="Aceptar">
                    <input type="submit" name="cancelarPedidoBtn" value="Cancelar">
                </fieldset>
                </form>`;
                
        $('#map').append(pedido);

    
    }


    /**
     * Handler para el evento submit del formulario #pedidoForm que lanza la función datos()
     */
    $('#pedidoForm').submit(function (event) {     
        event.preventDefault();
        datos();
    })

    /**
     * Función que mediante un fetch con un formulario enviado a consultaOpenMap.php envía los datos al servidor
     * para su revisión (no se revisan todos) y una vez comprueba que la respuesta es json, lanza resumenMapa() y resumenPedido() 
     */
    function datos() {
        let nombre = $('#nombreTxt').val();
        let direccion = $('#direccionTxt').val();
        let municipio = $('#municipioSl option:selected').text();
        let DNI = $('#cifNm').val();
        let tlfn = $('#telefonoTel').val();
        let productosArray = mostrarPedido();

        let datos = new FormData();
        datos.append('nombre', nombre),
        datos.append('direccion', direccion),
        datos.append('municipio', municipio),
        datos.append('dni', DNI),
        datos.append('telefono', tlfn),
        //Para poder enviar el array lo convertimos a JSON
        datos.append('productosArray', JSON.stringify(productosArray));

        fetch("consultaOpenStreetMap.php", {
            method: "POST",
            body: datos,
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                resumenMapa(data);
                resumenPedido(data);

            })
            .catch(error => {
                alert("error al crear el listado");
            });
    }

})


