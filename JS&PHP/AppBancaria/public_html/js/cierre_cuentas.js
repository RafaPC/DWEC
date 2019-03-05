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
    datosCliente = $(".datos-cliente-1");
    $("#input-codigoCuenta").focus();

    botonSiguiente = $("#botonSiguiente");
    dni = $("#dni-1");
    datosCliente = $(".datos-cliente-1");
    formularioDNI = $("#form-dni-1");
    botonSiguiente.on("click", function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });
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
            $(".invalid-feedback").html("Error del servidor");
        }
    }
}

function buscarCuenta() {
    setCarga();
    //Hacer llamada ajax para coger datos de la cuenta y rellenarlos
    var ncuenta = $("#input-codigoCuenta").val();
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
            $("#saldo").val(respuesta.saldo);

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
    $("#modal-verMovimientos").modal();
    $("#boton-verMovimientos-si").click(function () {
        var codigoCuenta = $("#input-codigoCuenta").val();
        //Doy 8 segundos por si la página tarda en cargar
        var tiempoActual = new Date(Date.now() + 5000);
        //En formato GTM string para que funcione en todos los navegadores
        document.cookie = "codigoCuenta=" + codigoCuenta + "; expires=" + tiempoActual.toGMTString() + "; path=/";
        $(location).attr("href", "movimientos.html");
    });

    $("#boton-verMovimientos-no").click(function () {
        //Quito los event listener puestos para las teclas "Escape" y "Enter"
        $("#modal-segundoCliente").off("keypress keydown");
        //HACER SCROLL O ALGO
    });
}

//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro