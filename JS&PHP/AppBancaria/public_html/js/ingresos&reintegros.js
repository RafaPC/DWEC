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


//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro