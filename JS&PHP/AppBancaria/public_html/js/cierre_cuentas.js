'use strict';
//Si se entra por cookie se cambiará a false
var limpiarInputs = true;
var botonSiguiente;
var inputCuenta;
var saldo;
var datosCliente;
$(function () {
    inputCuenta = $("#input-codigoCuenta");
    inputCuenta.focus();
    botonSiguiente = $("#botonSiguiente");
    botonSiguiente.on("click", function () {
        comprobarCodigoCuenta(inputCuenta.val());
    });

    datosCliente = $(".datos-cliente-1");
    $("#tabs").tabs({
        hide: 'fold',
        show: 'fold'
    });

    var codigoCuenta = getCookie("codigoCuenta");
    if (codigoCuenta !== null) {
        limpiarInputs = false;
        inputCuenta.val(codigoCuenta);
        campoCompleto($("#form-codigoCuenta"));
        buscarCuenta();
    }
});

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        //En este caso, el mensaje de error -3, no existe usuario,
        //es el que da paso a las siguientes fases del formulario
        campoCompleto($("#form-codigoCuenta"));
        //Quito la clase oculto al siguiente input para mostrarlo
        $("#datos-cuenta").removeClass("oculto");
        //Quito el listener que tenía el botón de Siguiente
        botonSiguiente.off("click");
        //Pongo nuevo listener al botón de siguiente
        //botonSiguiente.on("click", checkCliente);
        buscarCuenta();
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#form-codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#form-codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            campoErroneo($("#form-codigoCuenta"), "El código de cuenta no está registrado.");
        } else if (codigoErr <= 7) {
            campoErroneo($("#form-codigoCuenta"), codigosErrores[codigoErr]);
        }
    }
}

function buscarCuenta() {
    setCarga();
    //Hacer llamada ajax para coger datos de la cuenta y rellenarlos
    var ncuenta = inputCuenta.val();
    $.ajax({
        url: 'php/getDatos&ClientesFromCuenta.php',
        data: {cod_cuenta: ncuenta},
        type: 'POST',
        dataType: 'json',
        success: function (respuesta) {
            if (typeof (respuesta.cod_err) === "undefined") {
                $("#tabs").removeClass("oculto");
                $("#form-saldo").removeClass("oculto");
                saldo = respuesta.saldo;
                $("#input-saldo").val(saldo);
                campoCompleto($(".datos-cliente-1"));
                for (var i = 0; i < 9; i++) {
                    var valor = respuesta.cliente1[i];
                    if (i === 5 | i === 6) {
                        valor = convertirFecha(valor);
                    }
                    datosCliente[i].value = valor;
                }
                if (typeof (respuesta.cliente2) !== 'undefined') {
                    datosCliente = $(".datos-cliente-2");
                    $("#lista-primerCliente a").html("Primer titular");
                    $("#lista-segundoCliente").removeClass("oculto");
                    campoCompleto($(".datos-cliente-2"));
                    for (var i = 0; i < 9; i++) {
                        var valor = respuesta.cliente2[i];
                        if (i === 5 | i === 6) {
                            valor = convertirFecha(valor);
                        }
                        datosCliente[i].value = valor;
                    }
                }

                if (respuesta.saldo > 0) {
                    botonSiguiente.click(setModal);
                } else {
                    botonSiguiente.off();
                    botonSiguiente.click(borrarCuenta);
                }

                $('html, body').animate({
                    scrollTop: (botonSiguiente.offset().top)
                }, 800);
            } else {
                mostrarInfo(true, respuesta.cod_err, "buscando los datos de la cuenta");
            }

        },
        error: function (xhr, status) {
            console.log(xhr);
        },
        complete: function (xhr, status) {
            unsetCarga();
        }
    });
}

function setModal() {
    $("#modal-cierreCuenta").modal();
    $("#boton-verMovimientos").click(function () {
        //Escribo cookie con el numero de cuenta para que se reciba en movimientos
        setCookie("codigoCuenta", inputCuenta.val(), 5);
        //Redirijo a movimientos
        $(location).attr("href", "movimientos.html");
    });

    $("#boton-sacarSaldo").click(function () {
        setCookie("codigoCuenta", inputCuenta.val(), 5);
        setCookie("saldo", saldo, 5);

        $(location).attr("href", "ingresosYreintegros.html");
    });
}

function borrarCuenta() {
    var codCuenta = $("#input-codigoCuenta").val();
    $.ajax({
        url: 'php/cierreCuenta.php',
        data: {cod_cuenta: codCuenta},
        type: 'POST',
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.cod_err === 1) {
                mostrarInfo(false, 0, "Se ha cerrado la cuenta correctamente");
                botonSiguiente.off();
            } else if (respuesta.cod_err === -1) {
                mostrarInfo(true, "fallo de la base de datos", "borrar una cuenta");
            } else {
                mostrarInfo(true, respuesta.cod_err, "borrar una cuenta");
            }
        },
        error: function (xhr) {
            mostrarInfo(true, "-7", "borrar una cuenta");
        },
        complete: function () {
            unsetCarga();
        }
    });
}