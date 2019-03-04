
var margenIzq;
$(document).ready(function () {
//    margenIzq = $(".container").css("marginLeft");
    $("#sidenav").hover(function () {
        $("#sidenav").css("width", "250px");
//        $(".container").css("marginLeft", "250px");
    }, function () {
        $("#sidenav").css("width", "0.1px");
//        $(".container").css("marginLeft", margenIzq);
    });
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