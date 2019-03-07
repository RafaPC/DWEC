
var margenIzq;
var mouseY;
var windowMaxY;
var min, max;
var codigosErrores = {"-7": "Error en la conexión con el servidor.",
    "-8": "Error del servidor.",
    "-9": "Error en la conexión a la base de datos."
};
$(function () {
    //Para limpiar el valor de todos los inputs, ya que "autocomplete=off" hace lo que quiere
    if (limpiarInputs) {
        $("input").val("");
    }
    
    //Pongo focus al input de numero de cuenta
    $("#input-codigoCuenta").focus();

    //Cuando se aprete enter se hará click al botón siguiente
    //Funciona siempre
    $(document).keypress(function (event) {
        if (event.key === "Enter") {
            //activeElement es el elemento activo o focuseado
            var elem = document.activeElement;
            //Si se ha presionado Enter teniendo seleccionado el botón
            // ya cuenta como un click así que no se manda otro
            //Se compara elemento de DOM con elemento de DOM
            if (elem !== botonSiguiente.get(0)) {
                $("#botonSiguiente").click();
            }
        }
    });
    //----------------PANEL LATERAL-------------------//
    //Si el cursor está tocando el panel lateral y está a una altura 
    //por la mitad de la ventana (aproximadamente), abrirá el panel cambiando su anchura  
    $("#sidenav").mousemove(function (event) {
        //Al coger la altura de la ventana, funciona si cambia
        // el tamaño de la página después de la carga
        var windowMaxY = $(window).height();
        var min = (windowMaxY / 100 * 40);
        var max = (windowMaxY / 100 * 63);
        //Coge altura de la ventana
        var posicionMouseY = event.clientY;
        if (posicionMouseY > min && posicionMouseY < max) {
            //Si se tiene seleccionado un campo y sigue en foco cuando se muestra el menú lateral,
            //se quita el focus del campo para que no aparezca por encima del panel lateral
            $(":focus").blur();
            $("#sidenav a").css("cursor", "pointer");
            $("#sidenav").css("width", "250px");
        }
    });
    //Cierra el panel lateral al sacar el cursor de él
    $("#sidenav").mouseleave(function () {
        $("#sidenav").css("width", "0.1px");
        $("#sidenav a").css("cursor", "default");
    });

    //Si hay datepickers evita que se pueda escribir en ellos
    //Detecta si existen datepickers en el DOM
    if ($(".hasDatepicker").length) {
        $(".hasDatepicker").keydown(function (event) {
            //Deja apretar el escape para salir del campo
            if (event.key === "Escape") {
                $(this).blur();
                //Deja apretar el Tabulador para pasar al siguiente campo
                // para cualquier otra tecla detiene la acción predeterminada
            } else if (event.key !== "Tab") {
                event.preventDefault();
            }
        });
    }
});

//Recibe un form-group, le pone is-valid al input de dentro y también lo deshabilita
function campoCompleto(campo) {
    campoCorrecto(campo);
    //Se pone la propiedad disabled al input para que no se pueda cambiar
    campo.find(":input").prop("disabled", true);
}

//Recibe un form-group y le pone is-valid al input de dentro
function campoCorrecto(campo) {
    //Se recibe un elemento de jQuery
    //Se coge el input de ese elemento y se le quita la clase is-invalid por si han saltado errores antes
    campo.find(":input").removeClass("is-invalid");
    //Se le añade la clase is-valid
    campo.find(":input").addClass("is-valid");
}

//Recibe un form-group, le pone is-invalid al input de dentro e introduce un mensaje de error
//Si el campo ya estaba puesto como erróneo, le pone una animación para
// que el usuario vea que se ha vuelto a checkear
function campoErroneo(campo, textoError) {
    //Introduce el texto del error correspondiente
    campo.find(".invalid-feedback").html(textoError);

    //Si ya se estaba mostrando el error
    if (campo.find("input").hasClass("is-invalid")) {
        campo.find(".invalid-feedback").addClass("error-feedback");
        campo.find("input").addClass("error-input");
        setTimeout(function () {
            campo.find(".invalid-feedback").removeClass("error-feedback");
            campo.find("input").removeClass("error-input");
        }, 350);
    } else {
        //Añade al input la clase "is-invalid" para resaltar el cuadro en rojo y muestra ".invalid-feedback"
        campo.find("input").addClass("is-invalid");
    }
}


//Convierte fecha de yyyy-mm-dd a dd/mm/yyyy
function convertirFecha(fecha) {
    var año = fecha.substr(0, 4);
    var mes = fecha.substr(5, 2);
    var dia = fecha.substr(8, 2);
    var nuevaFecha = dia + "/" + mes + "/" + año;

    return nuevaFecha;
}

//Hace aparecer la animación de carga
function setCarga() {
    $("#carga").css("display", "block");
}

//Hace desaparecer la animación de carga
function unsetCarga() {
    $("#carga").css("display", "none");
}

//Crea cookie
function setCookie(cname, cvalue, segundos) {
    var d = new Date();
    d.setTime(Date.now() + (segundos * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//Coge cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}

//Muestra un mensaje de información en el modal-info del html
//Si de primer parámetro se pone true, cogerá el segundo parámetro 
//como un codigo de error de ajax
function mostrarInfo(error = true, codigoError, textoAccion) {
    if (error) {
        //Si se introduce un mensaje
        if (isNaN(parseInt(codigoError))) {
            error = codigoError;
        } else {
            var error = codigosErrores[codigoError];
            error = error.charAt(0).toLowerCase() + error.substring(1, error.length - 1);
        }
        $("#moda-info-titulo").html("Error en el servidor.");
        var mensaje = "Ha ocurrido un " + error + " al intentar " + textoAccion + ". Vuelve a intentarlo en unos minutos o contacta con tu administrador.";
    } else {
        $("#moda-info-titulo").html("Información.");
        var mensaje = textoAccion;
    }
    $("#modal-body-info").html(mensaje);
    $("#modal-info").modal();
}