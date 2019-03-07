'use strict';
var botonSiguiente;
var primerToast;
var inputCuenta;
var cerrarCuenta = false;
var importeBien = false;
var conceptoBien = false;
$(function () {
    inputCuenta = $("#input-codigoCuenta");
    inputCuenta.focus();

    //Defino variables globales
    botonSiguiente = $("#botonSiguiente");
    primerToast = $("#mensajes .toast").eq(0);
    primerToast.css("display", "none");

    $(document).off("keypress");
    botonSiguiente.click(function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

    $("#input-concepto").autocomplete({
        source: [
            "Comunidad",
            "Factura compañía eléctrica",
            "Factura peaje",
            "Letra hipoteca",
            "Seguro hogar",
            "Seguro moto",
            "Seguro coche",
            "Paga extra"
        ]
    });

    //Coge el evento hidden.bs.toast, que es el evento que lanzal los toasts al desaparecer
    $("#mensajes").on("hidden.bs.toast", function (event) {
        var toasts = $("#mensajes .toast");
        //Coge todos los toasts y lo compara con el target del evento
        for (var i = 0; i < toasts.length; i++) {
            //Cuando lo encuentra lo borra
            if (toasts.get(i) === event.target) {
                //Utilizo remove porque aunque es más lento,
                //quita los eventos y los datos del elemento
                toasts.eq(i).remove();
                i = toasts.length;
            }
        }
    });

    $("#input-codigoCuenta").get(0).addEventListener("blur", function () {
        //Aqui para que compruebe la cuenta cuando haga el blur y asi no tenga que disblearse y eso
        //Importante que esté a true para que se ejecute antes que el botón
        //Como ajax es asincrono a lo mejor tengo que poner en el boton a que espere
        //Al entrar aqui pongo la variable cuenta a false
        //Y dentro del boton espero un tiempo a ver si se pone a true
    }, true);

    //Mira si existe la cookie "codigoCuenta", si existe es que viene de cerrar cuentas
    var codigoCuenta = getCookie("codigoCuenta");
    var saldo = getCookie("saldo");
    if (codigoCuenta !== null && saldo !== null) {
        cerrarCuenta = true;
        inputCuenta.val(codigoCuenta);
        campoCompleto($("#form-codigoCuenta"));

        $("#form-concepto").removeClass("oculto");
        $("#input-concepto").val("Cierre de cuenta");
        campoCompleto($("#form-concepto"));

        $("#form-importe").removeClass("oculto");
        campoCompleto($("#form-importe"));
        $("#input-importe").val(-saldo);

        botonSiguiente.off("click");
        botonSiguiente.click(hacerMovimiento);
    }


    $(".campo").focusin(function () {
        $(this).removeClass("is-valid");
        $(this).removeClass("is-invalid");
        if ($(this) === $("#input-concepto")) {
            conceptoBien = false;
        } else {
            importeBien = false;
        }
    });

    $("#input-concepto").get(0).addEventListener("blur", checkearConcepto, true);
    $("#input-importe").get(0).addEventListener("blur", checkearImporte, true);
});

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        campoCompleto($("#form-codigoCuenta"));
        $("#form-concepto").removeClass("oculto");
        $("#form-importe").removeClass("oculto");
        botonSiguiente.off("click");
        botonSiguiente.click(importeEsMayorQueSaldo);
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#form-codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#form-codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            campoErroneo($("#form-codigoCuenta"), "El código no está registrado.");
        } else if (codigoErr <= -7) {
            campoErroneo($("#form-codigoCuenta"), codigosErrores[codigoErr]);
        }
    }
}

function importeEsMayorQueSaldo() {
    //Antes de entrar aquí ya se han ejecutado las funciones de checkearConcepto y checkearImporte 
    //porque se activan en la primera fase
    if (importeBien && conceptoBien) {
        var ncuenta = $("#input-codigoCuenta").val();
        var importe = parseInt($("#input-importe").val());
        if (importe < 0) {
            setCarga();
            $.ajax({
                // la URL para la peticion
                url: 'php/getSaldoFromCuenta.php',
                // la informacion a enviar
                // (tambien es posible utilizar una cadena de datos)
                data: {cod_cuenta: ncuenta},
                // especifica si sera una peticion POST o GET
                type: 'POST',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (respuesta) {
                    if (typeof (respuesta.cod_err) !== "undefined") {
                        mostrarInfo(true, respuesta.cod_err, " checkear el saldo de la cuenta");
                    } else {
                        if (respuesta.saldo < Math.abs(importe)) {
                            campoErroneo($("#form-importe"), "El reintegro supera al saldo total de la cuenta");
                        } else {
                            campoCorrecto($("#form-importe"));
                            hacerMovimiento();
                        }
                    }
                },
                error: function (xhr, status) {
                    mostrarInfo(true, "-7", " checkear el saldo de la cuenta");
                },
                complete: function (xhr, status) {
                    unsetCarga();
                }
            });
        } else {
            hacerMovimiento();
        }
    } else {
        mostrarError();
    }
}

function hacerMovimiento() {
    setCarga();
    var codCuenta = $("#input-codigoCuenta").val();
    var concepto = $("#input-concepto").val();
    var importe = $("#input-importe").val();
    $.ajax({
        // la URL para la peticion
        url: 'php/insertarMovimiento.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {cod_cuenta: codCuenta, concepto: concepto, importe: importe},
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.cod_err === 1) {
                if (importe > 0) {
                    crearToast("añadido");
                } else {
                    crearToast("retirado");
                }
            } else {
                mostrarInfo(true, respuesta.cod_err, " hacer un movimiento");
            }

            if (cerrarCuenta) {
                mostrarModalCerrarCuenta();
            }
        },
        error: function (xhr, status) {
            mostrarInfo(true, -7, " insertar un movimiento");
        },
        complete: function (xhr, status) {
            unsetCarga();
        }
    });
}

function mostrarModalCerrarCuenta() {
    console.log($("#boton-cerrarCuenta-si"));
    $("#modal-cierreCuenta").modal();
    $("#boton-cerrarCuenta-si").click(function () {
        //Escribo cookie con el numero de cuenta para que se reciba en movimientos
        setCookie("codigoCuenta", inputCuenta.val(), 5);
        //Redirijo a movimientos
        $(location).attr("href", "cierre_cuentas.html");
    });

    $("#boton-cerrarCuenta-no").click(function () {
        //Liberar numero de cuenta y eso para seguir haciendo cosillas
    });
}

function crearToast(tipoMovimiento) {
    var nuevoToast = primerToast.clone().css("display", "block");
    nuevoToast.find("#toast-titulo").html($("#input-concepto").val());
    var mensaje = "Se han " + tipoMovimiento + " ";
    nuevoToast.addClass("toast-" + tipoMovimiento);
    mensaje += $("#input-importe").val() + " euros.";
    nuevoToast.find("#toast-cuerpo").html(mensaje);
    nuevoToast.css("marginTop", "100%");
    $("#mensajes").append(nuevoToast);
    nuevoToast.toast("show");
    nuevoToast.css("marginTop", "0");
}

function mostrarError() {
    var mensaje = "";
    if (!(conceptoBien || importeBien)) {
        mensaje = "El concepto y el importe tienen que ser correctos";
    } else if (!conceptoBien) {
        mensaje = "El concepto tiene ser correcto";
    } else if (!importeBien) {
        mensaje = "El importe tiene que ser correcto";
    }
    $("#errorAlert").html(mensaje);
    $("#errorAlert").css("display", "block");
    $("#errorAlert").css("opacity", "1");
    setTimeout(function () {
        $("#errorAlert").css("opacity", "0");
    }, 3500);
}

function checkearImporte() {
    var formImporte = $("#form-importe");
    var importe = $("#input-importe").val();
    if (importe === undefined) {
        campoErroneo(formImporte, "Introduce el importe");
    } else {
        importe = parseInt(importe);
        if (isNaN(importe)) {
            campoErroneo(formImporte, "Tienes que introducir un número");
        } else if (importe === 0) {
            $("#input-importe").val(importe);
            campoErroneo(formImporte, "El importe tiene que ser distinto de 0");
        } else {
            importeBien = true;
            $("#input-importe").val(importe);
            campoCorrecto(formImporte);
        }
    }
}

function checkearConcepto() {
    var valor = $("#input-concepto").val();
    if (valor === undefined || valor === "") {
        campoErroneo($("#form-concepto"), "Tienes que escribir un concepto.");
    } else {
        conceptoBien = true;
        campoCorrecto($("#form-concepto"));
    }
}