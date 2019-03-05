
var margenIzq;
var mouseY;
var windowMaxY;
var min, max;
$(function () {
    windowMaxY = $(window).height();
    $("#flecha").css("top", windowMaxY / 100 * 49 + "px");
    min = ((windowMaxY / 100 * 49.5) - 120);
    max = ((windowMaxY / 100 * 49.5) + 120);
    //Pongo focus al input de numero de cuenta
    $("#input-codigoCuenta").focus();

    //Cuando se aprete enter se hará click al botón siguiente
    $(document).keypress(function (event) {
        if (event.key === "Enter") {
            $("#botonSiguiente").click();
        }
    });

    //Cuando se aprieta el enter se quita el focus del input
    $("input").keydown(function (event) {
        if (event.key === "Escape") {
            if ($(this).hasClass("hasDatepicker")) {
                $(this).blur();
            }
        }
    });

    //PONER
    $("#sidenav").mousemove(function (event) {
        var posicionMouseY = event.clientY;
        if (posicionMouseY > min && posicionMouseY < max) {
            //Si se tiene seleccionado un campo y sigue en foco cuando se muestra el menú,
            //el campo aparecerá por encima del menú lateral
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
    if ($(".hasDatepicker").length) {
        $(".hasDatepicker").keydown(function (event) {
            if (event.key !== "Tab") {
                event.preventDefault();
            }
        });
    }
});


function campoCorrecto(campo) {
    //Se recibe un elemento de jQuery
    //Se coge el input de ese elemento y se le quita la clase is-invalid por si han saltado errores antes
    campo.find(":input").removeClass("is-invalid");
    //Se le añade la clase is-valid
    campo.find(":input").addClass("is-valid");
    //Se pone display:none al elemento invalid-feedback para ocultar los errores que hayan salido
    campo.find(".invalid-feedback").css("display", "none");
    //Se pone la propiedad disabled al input para que no se pueda cambiar
    campo.find(":input").prop("disabled", true);
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

function setCarga() {
    $("#carga").css("display", "block");
}

function unsetCarga() {
    $("#carga").css("display", "none");
}