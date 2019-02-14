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
        campoCorrecto($("#codigoCuenta"));
        //Quito la clase oculto al siguiente input para mostrarlo
        $("#datos-cuenta").removeClass("oculto");
        //Quito el listener que tenía el botón de Siguiente
        botonSiguiente.off("click");
        //Pongo nuevo listener al botón de siguiente
        //botonSiguiente.on("click", checkCliente);

        //Hacer llamada ajax para coger datos de la cuenta y rellenarlos
        var ncuenta = $("#input-codigoCuenta").val();
        $.ajax({
            url: 'php/getDatos&ClientesFromCuenta.php',
            data: {numCuenta: ncuenta},
            type: 'POST',
            dataType: 'json',
            success: function (respuesta) {
                console.log(respuesta);
                $("#tabs").removeClass("oculto");
                $("#inputs-cuenta").removeClass("oculto");
                var datosCuenta = $(".datos-cuenta");
                for(var i = 0; i < 3; i++){
                    datosCuenta[i].value = respuesta.cuenta[i];
                }
                
                $("#inputs-cliente-1").removeClass("oculto");
                campoCorrecto($(".datos-cliente-1"));
                for (var i = 0; i < 9; i++) {
                    var x = $(".datos-cliente-1");
                    x[i].value = respuesta.cliente1[i];
                }
                if (!(typeof respuesta.cliente2 === 'undefined')) {
                    $("#lista-primerCliente a").html("Primer titular");
                    $("#lista-segundoCliente").removeClass("oculto");
                    $("#inputs-cliente-2").removeClass("oculto");
                    campoCorrecto($(".datos-cliente-2"));
                    for (var i = 0; i < 9; i++) {
                        $(".datos-cliente-2")[i].value = respuesta.cliente2[i];
                    }
                }
            },
            error: function (xhr, status) {
                console.log(xhr);
            },
            complete: function (xhr, status) {

            }
        });
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

function checkCliente() {
    var valorDNI = dni.val();
    if (checkDNI()) {
        if (segundoTitular && dniPrimerTitular === valorDNI) {
            campoErroneo(formularioDNI, "Ese DNI pertenece al primer titular");
//            $("#form-dni-2 .invalid-feedback").css("display", "block");
//            $("#form-dni-2 .invalid-feedback").html("Ese DNI pertenece al primer titular");
//            $("#dni-2").addClass("is-invalid");
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

                        dni.prop("disabled", true);
                        alert("Titular ya registrado, no se necesita completar su información");
                        if (segundoTitular) {
                            existeCliente2 = true;
                            $("#importe").removeClass("oculto");
                            botonSiguiente.off("click");
                            botonSiguiente.on("click", checkImporte);
                        } else {
                            existeCliente1 = true;
                            botonSiguiente.on("click", checkSegundoTitular);
                            $("#radios").removeClass("oculto");
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
    datosCliente.removeClass("is-invalid");
    var error = false;
    for (var i = 0; i < datosCliente.length; i++) {
        if ((datosCliente[i].value).length === 0) {
            datosCliente[i].classList.add("is-invalid");
            error = true;
        }
    }
    if (!error) {
        inputsCliente.find(".invalid-feedback").css("display", "none");
        datosCliente.addClass("is-valid");
        botonSiguiente.off("click");
        datosCliente.prop("disabled", true);
        dni.prop("disabled", true);
        //Ha chequeado los datos del segundo titular
        if (segundoTitular) {
            botonSiguiente.on("click", checkImporte);
            $("#importe").removeClass("oculto");
        } else {
            //Ha chequeado los datos del primer titular
            botonSiguiente.on("click", checkSegundoTitular);
            $("#radios").removeClass("oculto");
        }
    } else {
        inputsCliente.find(".invalid-feedback").css("display", "block");
    }
}

//Que directamente se llame a dni cuando toque, sin pasar por checkCliente
function checkDNI() {
    var letrasDNI = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
    var dniValido;
    var expregDni = new RegExp(/^\d{8}[A-Z]$/i);
    var valorDNI = "" + dni.val();
    if (valorDNI.length === 0) {
        campoErroneo($("#dni"));
    }
    if (expregDni.exec(valorDNI)) {
        var numeros = parseInt(valorDNI.substr(0, 8));
        var resto = numeros % 23;
        var letra = dni.val().substr(8, 1);
        if (letrasDNI[resto] === letra) {
            dniValido = true;
            campoCorrecto(formularioDNI);
        } else {
            campoErroneo(formularioDNI, "Formato de DNI incorrecto.");
        }
    } else {
        dniValido = false;
    }

    return dniValido;
}

function checkImporte() {
    var importe = parseInt($("#input-importe").val());
    if (importe === NaN) {
        campoErroneo($("#importe"), "El importe tiene que ser un valor numérico.");
    } else if (importe <= 0) {
        campoErroneo($("#importe"), "El importe tiene que ser mayor de 0");
    } else {
        campoCorrecto($("#importe"));
        mandarDatos();
    }
}

function mandarDatos() {
    var llamada = new Object();
    var cliente1 = [];
    var cliente2 = [];
    llamada.numCuenta = $("#input-codigoCuenta").val();
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