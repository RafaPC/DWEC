'use strict';
var cliente = 1;
var botonSiguiente;
var dni;
var datosCliente;
var formularioDNI;
var inputsCliente;
var segundoTitular;
var dniPrimerTitular = null;
var letrasDNI = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
segundoTitular = false;

$(function () {
    botonSiguiente = $("#botonSiguiente");
    dni = $("#dni-1");
    datosCliente = $(".datos-cliente-1");
    formularioDNI = $("#form-dni-1");
    inputsCliente = $("#inputs-cliente-1");

    botonSiguiente.on("click", function () {
        var codCuenta = "" + $("#ncuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });
//        $("#fecha1").datepicker($.datepicker.regional["es"]);
//        $("#fecha2").datepicker($.datepicker.regional["es"]);
    var dateFormat = "dd/mm/yy";
    var nacimiento = $("#fecha-nacimiento").datepicker({
        defaultDate: "+1m +7d",
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        maxDate: "-18y"
    });
    var registro = $("#fecha-registro").datepicker({
        defaultDate: null,
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    });
    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
});

function handleCodCuenta(codigoErr) {
    $(".invalid-feedback").css("display", "block");
    $("#ncuenta").addClass("is-invalid");
    if (codigoErr === 1) {
        $(".invalid-feedback").css("display", "block");
        $("#ncuenta").addClass("is-invalid");
        $(".invalid-feedback").html("El código de cuenta ya está registrado");
    } else {
        if (codigoErr === -1) {
            $(".invalid-feedback").html("El codigo tiene que tener al menos 10 números");
        } else if (codigoErr === -2) {
            $(".invalid-feedback").html("El código no cumple el formato");
        } else if (codigoErr === -3) {
            //Quito mensaje de error (por si se habia fallado antes)
            $(".invalid-feedback").css("display", "none");
            //Quito la clase de error al input(por si se habia fallado antes)
            $("#ncuenta").removeClass("is-invalid");
            //Añado la clase de éxito
            $("#ncuenta").addClass("is-valid");
            //Añado propiedad de "discapacitado" para que no se pueda cambiar
            $("#ncuenta").prop("disabled", true);
            //Quito la clase oculto al siguiente input para mostrarlo
            $("#form-dni-1").removeClass("oculto");
            //Quito el listener que tenía el botón de Siguiente
            botonSiguiente.off("click");
            //Pongo nuevo listener al botón de siguiente
            botonSiguiente.on("click", checkCliente);
        } else if (codigoErr === -4) {
            $(".invalid-feedback").html("Error del servidor");
        }
    }
}

function checkCliente() {
    var valorDNI = dni.val();
    if (checkDNI()) {
        if (dniPrimerTitular === valorDNI) {
            $("#form-dni-2 .invalid-feedback").css("display", "block");
            $("#form-dni-2 .invalid-feedback").html("Ese DNI pertenece al primer titular");
            //document.getElementById("form-dni-2").getElementsByClassName("invalid-feedback")[0].style.display = "block";
            //document.getElementById("form-dni-2").getElementsByClassName("invalid-feedback")[0].innerHTML = "Ese DNI pertenece al primer titular";
            $("#dni-2").addClass("is-invalid");
        } else {
            $.ajax({
                // la URL para la peticion
                url: 'php/comprobarCliente.php',
                // la informacion a enviar
                // (tambien es posible utilizar una cadena de datos)
                data: {dni: valorDNI},
                // especifica si sera una peticion POST o GET
                type: 'POST',
                // el tipo de informaciÃ³n que se espera de respuesta
                dataType: 'json',
                success: function (resultado) {
                    inputsCliente.removeClass("oculto");
                    //Si me ha devuelto un cliente
                    botonSiguiente.off("click");
                    if (resultado.cliente[0] !== undefined) {
                        dniPrimerTitular = valorDNI;
                        //inputsCliente.prop("disabled", true);
                        datosCliente.addClass("is-valid");
                        datosCliente.prop("disabled", true);

                        var cliente = resultado.cliente;

                        for (var i = 0; i < 9; i++) {
                            datosCliente[i].value = cliente[i];
                        }

                        $("#dni-1").prop("disabled", true);
                        $("#radios").removeClass("oculto");
                        alert("Titular ya registrado, no se necesita completar su información");

                        botonSiguiente.on("click", checkSegundoTitular);
                        if (segundoTitular) {
                            $("#importe").removeClass("oculto");
                            botonSiguiente.off("click");
                            botonSiguiente.on("click", checkImporte);
                        }
                    } else {
                        //Como antes del if ya se muestra el formulario no habría que hacer nada aquí aparentemente
                        botonSiguiente.off("click");
                        botonSiguiente.on("click", checkDatosCliente);
                        alert("Titular no registrado, se necesita rellenar los campos.");
                    }
                },
                error: function (xhr, status) {
                    alert('Disculpe, existia un problema' + status);
                },
                complete: function (xhr, status) {
                }
            });
        }
    }
}

function checkDatosCliente() {

}

function checkSegundoTitular() {
    botonSiguiente.off("click");
    botonSiguiente.on("click", checkCliente);

    if ($("#segundo-titular-si").prop("checked")) {
        formularioDNI = $("#form-dni-2");
        segundoTitular = true;
        formularioDNI.removeClass("oculto");
        botonSiguiente.off("click");
        botonSiguiente.on("click", checkCliente);
        dni = $("#dni-2");
        datosCliente = $(".datos-cliente-2");
        inputsCliente = $("#inputs-cliente-2");
    } else {
        $("#importe").removeClass("oculto");
        botonSiguiente.off("click");
        botonSiguiente.on("click", checkImporte);
    }
    $(".radio-titular").prop("disabled", true);
}

//Que directamente se llame a dni cuando toque, sin pasar por checkCliente
function checkDNI() {
    var valorDNI = "" + dni.val();
    var dniValido = false;
    var numeros = parseInt(valorDNI.substr(0, 8));
    var resto = numeros % 23;
    var letra = dni.val().substr(8, 1);
    if (letrasDNI[resto] === letra) {
        dniValido = true;
        dni.removeClass("is-invalid");
        dni.addClass("is-valid");
        //document.getElementById(formularioDNI).getElementsByClassName("invalid-feedback")[0].style.display = "none";
        formularioDNI.find(".invalid-feedback").css("display", "none");
    } else {
        //document.getElementById(formularioDNI).getElementsByClassName("invalid-feedback")[0].style.display = "block";
        formularioDNI.find(".invalid-feedback").css("display", "block");
        dni.addClass("is-invalid");
    }
    return dniValido;
}

function checkImporte() {
    var importe = parseInt($("#input-importe").val());
    if (importe > 0) {
        $("#input-importe").removeClass("is-invalid");
        $("#input-importe").addClass("is-valid");
        $("#importe .invalid-feedback").css("display", "none");
        mandarDatos();
    } else {
        $("#input-importe").addClass("is-invalid");
        $("#importe .invalid-feedback").css("display", "block");
    }
}

function mandarDatos() {

}


//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro