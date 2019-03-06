'use strict';
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
        collapsible: true,
        hide: 'fold',
        show: 'fold'
    });
});

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        //En este caso, el mensaje de error -3, no existe usuario,
        //es el que da paso a las siguientes fases del formulario
        campoCompleto($("#codigoCuenta"));
        //Quito la clase oculto al siguiente input para mostrarlo
        $("#datos-cuenta").removeClass("oculto");
        //Quito el listener que tenía el botón de Siguiente
        botonSiguiente.off("click");
        //Pongo nuevo listener al botón de siguiente
        //botonSiguiente.on("click", checkCliente);
        buscarCuenta();
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            campoErroneo($("#codigoCuenta"), "El código de cuenta no está registrado.");
        } else if (codigoErr === -4) {
            campoErroneo($("#codigoCuenta"), "Error del servidor.");
        }
    }
}

function buscarCuenta() {
    setCarga();
    //Hacer llamada ajax para coger datos de la cuenta y rellenarlos
    var ncuenta = inputCuenta.val();
    $.ajax({
        url: 'php/getDatos&ClientesFromCuenta.php',
        data: {numCuenta: ncuenta},
        type: 'POST',
        dataType: 'json',
        success: function (respuesta) {
            //AQUI MIRAR SI ESTA MOSTRADO, HACER OTRO CLONANDO Y METERLO EN #MENSAJES

            $("#tabs").removeClass("oculto");
            //Mirar esto del parent parent que queda feo
            $("#saldo").parent().parent().removeClass("oculto");
            saldo = respuesta.saldo;
            $("#saldo").val(saldo);
            campoCompleto($(".datos-cliente-1"));
            for (var i = 0; i < 9; i++) {
                var valor = respuesta.cliente1[i];
                if (i === 5 | i === 6) {
                    valor = convertirFecha(valor);
                }
                datosCliente[i].value = valor;
            }
            if (!(typeof respuesta.cliente2 === 'undefined')) {
                datosCliente = $(".datos-cliente-2");
                //MIRAR ESTO APUNTADO EN WHATSAPP
                $("#lista-primerCliente a").html("Primer titular");
                //$("#lista-primerCliente span").html("Primer titular");
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
                setModal();
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
        setCookie("codigoCuenta", inputCuenta.val(), 60);
        setCookie("saldo", saldo, 60);

        $(location).attr("href", "ingresosYreintegros.html");

        //Quito los event listener puestos para las teclas "Escape" y "Enter"
        $("#modal-segundoCliente").off("keypress keydown");
        //HACER SCROLL O ALGO
    });
}

//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro