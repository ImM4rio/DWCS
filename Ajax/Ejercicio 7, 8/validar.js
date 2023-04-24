//validar.js
//Capturamos o submit. Se non cumple validar non se fai o submit
$("#rexistro").submit(function (event) {

    
    if (!validar()) {
        event.preventDefault();
        return false;

    }else{
   
        let usuario = $('#usuario').val();
        let mail = $('#mail').val();
        let pass = $('#pass').val();
        let pass2 = $('#pass2').val();

        $.ajax({
            type: "POST", url: "registro.php", data: "usuario= " + usuario + "&mail= " + mail + "&pass= " + pass + "&pass2=" + pass2,
            statusCode: {
                404: function () {
                    alert("Página no encontrada.");
                }
            },
            success: function (result) {
                alert(result);
                
                
            }
        })
        
        //return false;  //Descomenta/comenta para comprobar ajax
        return true;
    }

});
    
    function validarNome() {
        let usu = $("#usuario");
        let errUsu = $("#errUsuario");

        if (usu.val().length < 4) {
            errUsu.removeClass("oculta");
            return false;
        }
    
        errUsu.addClass("oculta");
        return true;
        
    }
    
    function validarPass() {
        let pass1 = $("#pass");
        let pass2 = $('#pass2');
        let errPass = $("#errPassword");
        let regex = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,64})/;

        if (pass1.val().length < 6 ) {
            errPass.html("");
            errPass.append("La contraseña debe tener más de 5 dígitos");
            errPass.removeClass("oculta");
            return false;
    
        }else if(pass1.val() != pass2.val()){
            errPass.html("");
            errPass.append("<br>Las contraseñas no coinciden");
            errPass.removeClass("oculta");
            return false;

        }else if(!pass1.val().match(regex)){
            errPass.html("");
            errPass.append("La contraseña debe mantener al menos una mayúscula, un número y un signo de puntuación");
            errPass.removeClass('oculta');
            return false;
        }
    
        errPass.addClass("oculta");
        return true;
    }

    function validarMail() {
        var mail = $("#mail")
        var errMail = $("#errMail");
        
        if (!mail.val().match("^[a-zA-Z0-9]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$")) {
            errMail.removeClass("oculta");
            return false;
        }
    
        errMail.addClass("oculta");
        return true;
    
    }
    
    function validar() {
        return validarNome() & validarMail() & validarPass()

    }