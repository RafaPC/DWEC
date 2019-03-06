
var margenIzq;
var mouseY;
var windowMaxY;
var min, max;
$(function () {
    //Para limpiar el valor de todos los inputs, ya que "autocomplete=off" hace lo que quiere
    $("input").val("");

    //Pongo focus al input de numero de cuenta
    $("#input-codigoCuenta").focus();

    //Cuando se aprete enter se hará click al botón siguiente
    //Funciona siempre
    $(document).keypress(function (event) {
        if (event.key === "Enter") {
            //var cosa = $("button");
            var elem = document.activeElement;
            if (elem !== botonSiguiente[0]) {
                $("#botonSiguiente").click();
            }
        }
    });

    //Cuando se aprieta el enter se quita el focus del input
    //Solo funciona en los inputs de fecha
//    $("input .hasDatepicker").keydown(function (event) {
//        if (event.key === "Escape") {
//            $(this).blur();
//        }
//    });

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
            } else if (event.key !== "Tab") {
                event.preventDefault();
            }
        });
    }
});


function campoCompleto(campo) {
    campoCorrecto(campo);
    //Se pone la propiedad disabled al input para que no se pueda cambiar
    campo.find(":input").prop("disabled", true);
}

function campoCorrecto(campo) {
    //Se recibe un elemento de jQuery
    //Se coge el input de ese elemento y se le quita la clase is-invalid por si han saltado errores antes
    campo.find(":input").removeClass("is-invalid");
    //Se le añade la clase is-valid
    campo.find(":input").addClass("is-valid");
}

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

function setCarga() {
    $("#carga").css("display", "block");
}

function unsetCarga() {
    $("#carga").css("display", "none");
}


function setCookie(cname, cvalue, segundos) {
    var d = new Date();
    d.setTime(Date.now() + (segundos * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

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

