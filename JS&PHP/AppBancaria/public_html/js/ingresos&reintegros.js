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
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });
});

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        campoCorrecto($("#codigoCuenta"));
        $("#descripcion").removeClass("oculto");
        $("#botonSiguiente").off("click");
        $("#botonSiguiente").on("click", checkDescripcion);
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            campoErroneo($("#codigoCuenta"), "El código no está registrado.");
        } else if (codigoErr === -4) {
            campoErroneo($("#codigoCuenta"), "Error del servidor.");
        }
    }
}
function checkDescripcion() {
    var descripcion = $("#input-descripcion").val();
    if (descripcion.length === 0) {
        campoErroneo($("#descripcion"), "El campo debe contener una descripción.");
    } else {
        campoCorrecto($("#descripcion"));
        $("#importe").removeClass("oculto");
        $("#botonSiguiente").off("click");
        $("#botonSiguiente").on("click", checkImporte);

    }
}
function checkImporte() {
    var importe = parseInt($("#input-importe").val());
    if (importe !== 0) {
        if (importe < 0) {
            importeEsMayorQueSaldo();
        }
        campoCorrecto($("#importe"));
        mandarDatos();
    } else {
        campoErroneo($("#importe"), "El importe tiene que ser distinto de 0.");
    }
}

function mandarDatos() {
    var numCuenta = $("#input-codigoCuenta").val();
    var descripcion = $("#input-descripcion").val();
    var importe = $("#input-importe").val();
    $.ajax({
        // la URL para la peticion
        url: 'php/insertarMovimiento.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {numcuenta: numCuenta, descripcion: descripcion, importe: importe},
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            console.log(resultado);
            alert("llega");
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
            console.log(xhr);
            console.log(status);
        },
        complete: function (xhr, status) {
        alert("complete");
        }
    });
}

function importeEsMayorQueSaldo() {
    var ncuenta = $("#input-codigoCuenta").val();
    var importe = parseInt($("#input-importe").val());
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
                    campoErroneo($("#importe"), "El reintegro supera al saldo total de la cuenta");
                } else {
                    campoCorrecto($("#importe"));
                }
            }
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
        },
        complete: function (xhr, status) {
        }
    });
}



//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro