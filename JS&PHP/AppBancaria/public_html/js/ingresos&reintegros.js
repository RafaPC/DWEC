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
var primerToast;

$(function () {
    $("#input-codigoCuenta").focus();

    //Defino variables globales
    botonSiguiente = $("#botonSiguiente");
    dni = $("#dni-1");
    datosCliente = $(".datos-cliente-1");
    formularioDNI = $("#form-dni-1");
    inputsCliente = $("#inputs-cliente-1");
    primerToast = $("#mensajes .toast").eq(0);
    primerToast.css("display", "none");
    //Por si lo rellena automáticamente el navegador
    $("#num-cuentas-1").val("0");
    $("#num-cuentas-2").val("0");

    botonSiguiente.on("click", function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

    //Autocomplete de jQuery UI
    var conceptos = [
        "Comunidad",
        "Factura compañía eléctrica",
        "Letra hipoteca",
        "Seguro hogar",
        "Seguro moto",
        "Seguro coche",
        "Wallapop"
    ];

    $("#input-descripcion").autocomplete({
        source: conceptos
    });

    $("#mensajes").on("hidden.bs.toast", function (event) {
        var toasts = $("#mensajes .toast");
        for (var i = 0; i < toasts.length; i++) {
            if (toasts.get(i) === event.target) {
                //Utilizo remove porque aunque es más lento,
                //quita los eventos y los datos del elemento
                toasts.eq(i).remove();
                i = toasts.length;
            }
        }
    });

    $("#input-codigoCuenta").get(0).addEventListener("blur", function () {

    }, true);


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
        //utilizar .text()
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
        //campoCorrecto($("#importe"));
        hacerMovimiento();
    } else {
        campoErroneo($("#importe"), "El importe tiene que ser distinto de 0.");
    }
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

function hacerMovimiento() {
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
            if (importe > 0) {
                crearToast("añadido");
            } else {
                crearToast("retirado");
            }
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
            console.log(xhr);
        },
        complete: function (xhr, status) {
        }
    });
}

function crearToast(tipoMovimiento) {
    var nuevoToast = primerToast.clone().css("display", "block");
    nuevoToast.find("#toast-titulo").html("Cuenta: " + $("#input-codigoCuenta").val() + "");
    var mensaje = "Se han " + tipoMovimiento + " ";
    nuevoToast.addClass("toast-" + tipoMovimiento);
    mensaje += $("#input-importe").val() + " euros.";
    nuevoToast.find("#toast-cuerpo").html(mensaje);
    nuevoToast.css("marginTop", "100%");
    $("#mensajes").append(nuevoToast);
    nuevoToast.toast("show");
    nuevoToast.css("marginTop", "0");
}


//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro