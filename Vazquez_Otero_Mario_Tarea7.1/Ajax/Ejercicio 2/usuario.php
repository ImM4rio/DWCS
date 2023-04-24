<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación Email</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function validarEmail() {
            valor = document.getElementById("email").value;
            posArroba = valor.indexOf("@");
            posPunto = valor.lastIndexOf(".");

            if(posArroba < 1 || posPunto < posArroba + 2 || posPunto + 2 >= valor.length) {
                alert('Dirección de correo no válida');
                return false;

           
            } 



            //return true; //En este ejemplo no enviamos los valores con el action del form

            $.ajax({
                type: "POST", url: "email.php", data: "email=" + valor,
                statusCode: {
                    404: function() {
                        alert("Página no encontrada.");
                    }},
                success: function(resultado) {
                    alert("Resultado: " + resultado);
                }
                
            });
            return false;

        }

        function validarEmailNombre() {
            let nombre = document.getElementById('usuario').value;
            let email = document.getElementById('email').value;
            posArroba = email.indexOf("@");
            posPunto = email.lastIndexOf(".");

            if(posArroba < 1 || posPunto < posArroba + 2 || posPunto + 2 >= email.length) {
                alert('Dirección de correo no válida');
                return false;
            }
            
            if(nombre != 'Ana' && nombre != 'Xan') {
                alert('Nombre no válido');
                return false;
            } 

            $.ajax({
                type: "POST", url: "email.php", data: "email=" + email + "&nombre=" + nombre + "&psw=" + password,
                statusCode: {
                    404: function () {
                        alert("Página no encontrada");
                    }
                },
                success: function(resultado) {
                    alert("Resultado = " + resultado);
                }
            });
            return false;
        }

    </script>
</head>
<body>
    <form action='' method='GET' name='datos_usuario' onsubmit='return validarEmailNombre()'>
        <input type='text' id='email' name='email' placeholder="Introduce email"/>
        <input type='text' id='usuario' name='usuario' placeholder="Introduce nombre"/>
        <input type='submit' name='enviar' value='Enviar'/>
    </form>
</body>
</html>