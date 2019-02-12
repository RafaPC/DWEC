'use strict';
var cliente = 1;
var botonSiguiente;
var dni;
var datosCliente;
var formularioDNI;
var inputsCliente;
var segundoTitular = false;
var dniPrimerTitular = null;
var existeCliente1 = false, existeCliente2 = false;

$(function () {
    botonSiguiente = $("#botonSiguiente");
    dni = $("#dni-1");
    datosCliente = $(".datos-cliente-1");
    formularioDNI = $("#form-dni-1");
    inputsCliente = $("#inputs-cliente-1");

    $("#num-cuentas-1").val("0");
    $("#num-cuentas-2").val("0");
    botonSiguiente.on("click", function () {
        var codCuenta = "" + $("#ncuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });
});

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        $(".invalid-feedback").css("display", "none");
        $("#ncuenta").removeClass("is-invalid");
        $("#ncuenta").addClass("is-valid");
        $("#ncuenta").prop("disabled", true);
        $("#descripcion").removeClass("oculto");
        $("#botonSiguiente").off("click");
        $("#botonSiguiente").on("click", checkDescripcion);
    } else {
        $(".invalid-feedback").css("display", "block");
        $("#ncuenta").addClass("is-invalid");
        if (codigoErr === -1) {
            $(".invalid-feedback").html("El codigo tiene que tener al menos 10 números");
        } else if (codigoErr === -2) {
            $(".invalid-feedback").html("El código no cumple el formato");
        } else if (codigoErr === -3) {
            $(".invalid-feedback").html("El código no está registrado");
        } else if (codigoErr === -4) {
            $(".invalid-feedback").html("Error del servidor");
        }
    }
}
function checkDescripcion() {
    var descripcion = $("#input-descripcion").val();
    if (descripcion.length === 0) {
        $("#input-descripcion").addClass("is-invalid");
        $("#descripcion .invalid-feedback").html("El campo debe contener una descripción.");
        $("#descripcion .invalid-feedback").css("display", "block");
    } else {
        $("#input-descripcion").removeClass("is-invalid");
        $("#input-descripcion").addClass("is-valid");
        $("#input-descripcion").prop("disabled", true);
        $("#descripcion .invalid-feedback").css("display", "none");
        $("#importe").removeClass("oculto");
        $("#botonSiguiente").off("click");
        $("#botonSiguiente").on("click", checkImporte);

    }
}
function checkImporte() {
    var importe = parseInt($("#input-importe").val());
    if (importe !== 0) {
        if (importe < 0) {
            var x = importeEsMayorQueSaldo();
            if (x == true) {
                alert("deberia entrar aqui");
                $("#input-importe").addClass("is-invalid");
                $("#importe .invalid-feedback").css("display", "block");
                $("#importe .invalid-feedback").html("El reintegro supera al saldo total de la cuenta");
            } else {
                alert("entra aqui");
            }
        }
        $("#input-importe").removeClass("is-invalid");
        $("#input-importe").addClass("is-valid");
        $("#importe .invalid-feedback").css("display", "none");
        $("#input-importe").prop("disabled", true);
        //mandarDatos();
    } else {
        $("#input-importe").addClass("is-invalid");
        $("#importe .invalid-feedback").css("display", "block");
    }
}

function mandarDatos() {
    var llamada = new Object();
    var cliente1 = [];
    var cliente2 = [];
    llamada.numCuenta = $("#ncuenta").val();
    llamada.existeCliente1 = existeCliente1;
    llamada.existeCliente2 = existeCliente2;

    for (var i = 0; i < $(".datos-cliente-1").length; i++) {
        cliente1.push($(".datos-cliente-1")[i].value);
    }
    llamada.cliente1 = cliente1;
    if (segundoTitular) {
        for (var i = 0; i < $(".datos-cliente-2").length; i++) {
            cliente2.push($(".datos-cliente-2")[i].value);
        }
        llamada.cliente2 = cliente2;
    }
    llamada.saldo = $("#input-importe").val();
    console.log(llamada);
    $.ajax({
        // la URL para la peticion
        url: 'php/aperturaCuenta.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: llamada,
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            alert(resultado.mensaje);
            console.log(resultado);
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
        },
        complete: function (xhr, status) {
        }
    });
}

function importeEsMayorQueSaldo() {
    var ncuenta = $("#ncuenta").val();
    var importe = parseInt($("#input-importe").val());
    var importeEsMayorQueSaldo;
    $.ajax({
        // la URL para la peticion
        url: 'php/getSaldoFromCuenta.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {cod_cuenta: ncuenta},
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            if (typeof resultado.cod_err !== 'undefined') {
                console.log("hacer algo");
            } else {
                if (resultado.saldo < Math.abs(importe)) {
                    importeEsMayorQueSaldo = true;
                } else {
                    importeEsMayorQueSaldo = false;
                }
            }
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
        },
        complete: function (xhr, status) {
        }
    });
    return importeEsMayorQueSaldo;
}

//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro