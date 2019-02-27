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
var fechaActual;
$(function () {
    $("#prueba").click(function () {
        alert("pene");
    });
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
//        $("#fecha1").datepicker($.datepicker.regional["es"]);
//        $("#fecha2").datepicker($.datepicker.regional["es"]);
    var fecha = new Date();
    var dia = fecha.getDate();
    var mes = fecha.getMonth() + 1;
    var año = fecha.getFullYear();
    mes += "";
    if (mes.length === 1 && mes !== 0) {
        mes = "0" + mes;
    }
    fechaActual = dia + "/" + mes + "/" + año;
    var dateFormat = "dd/mm/yy";
    var nacimiento1 = $("#fecha-nacimiento-1").datepicker({
        defaultDate: null,
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        maxDate: "-18y"
    });
    var nacimiento2 = $("#fecha-nacimiento-2").datepicker({
        defaultDate: null,
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        maxDate: "-18y"
    });
    var registro1 = $("#fecha-registro-1").datepicker({
        defaultDate: null,
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    });
    var registro2 = $("#fecha-registro-2").datepicker({
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
    $("#tabs").tabs({
        collapsible: true,
        hide: 'fold',
        show: 'fold'
    });
});
function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        campoErroneo($("#codigoCuenta"), "El código de cuenta ya está registrado.");
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            //Quito la clase oculto a #tabs
            $("#tabs").removeClass("oculto");
            //En este caso, el mensaje de error -3, no existe usuario,
            //es el que da paso a las siguientes fases del formulario
            campoCorrecto($("#codigoCuenta"));
            //Quito la clase oculto al siguiente input para mostrarlo
            $("#lista-primerCliente").removeClass("oculto");
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
        $.ajax({
            // la URL para la peticion
            url: 'php/comprobarCliente.php',
            // la informacion a enviar
            data: {dni: valorDNI},
            // especifica si sera una peticion POST o GET
            type: 'POST',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (respuesta) {
                //Si me ha devuelto un cliente
                botonSiguiente.off("click");
                //Si existe el cliente
                if (respuesta.cliente[0] !== undefined) {
                    dniPrimerTitular = valorDNI;
                    //inputsCliente.prop("disabled", true);
                    //datosCliente.addClass("is-valid");
                    //datosCliente.prop("disabled", true);
                    campoCorrecto(inputsCliente);
                    var cliente = respuesta.cliente;
                    for (var i = 1; i < 9; i++) {
                        datosCliente[i].value = cliente[i];
                    }
                    dni.prop("disabled", true);
                    alert("Titular ya registrado, no se necesita completar su información");
                    if (segundoTitular) {
                        $("#lista-segundoCliente").removeClass("oculto");
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
                    //Quito la propiedad disabled a todos los inputs
                    datosCliente.slice(1).prop("disabled", false);
                    //Pongo al input de fecha de registro la fecha actual
                    console.log(datosCliente);
                    datosCliente[6].value = fechaActual;
                    datosCliente.slice(6).prop("disabled", true);
                    datosCliente.slice(6).addClass("is-valid");
                    //Como antes del if ya se muestra el formulario no habría que hacer nada aquí aparentemente
                    botonSiguiente.off("click");
                    botonSiguiente.on("click", checkDatosCliente);
                    alert("Titular no registrado, se necesita rellenar los campos.");
                }
            },
            error: function (xhr, status) {
                console.log(xhr);
                alert('Disculpe, existia un problema' + status);
            },
            complete: function (xhr, status) {
            }
        });
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

function checkSegundoTitular() {
    botonSiguiente.off("click");
    if ($("#segundo-titular-si").prop("checked")) {

        $("#lista-segundoCliente").removeClass("oculto");
        //Abro el segundo panel de #tabs
        $('#tabs').tabs("option", "active", 1);
        $("#lista-primerCliente").find("span").html("Primer titular");
        formularioDNI = $("#form-dni-2");
        segundoTitular = true;
        dni = $("#dni-2");
        datosCliente = $(".datos-cliente-2");
        inputsCliente = $("#inputs-cliente-2");
        botonSiguiente.on("click", checkCliente);
    } else {
        $("#importe").removeClass("oculto");
        botonSiguiente.on("click", checkImporte);
    }
    $("#radios").addClass("oculto");
}

//Que directamente se llame a dni cuando toque, sin pasar por checkCliente
function checkDNI() {
    var letrasDNI = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
    var dniValido = false;
    var expregDni = new RegExp(/^\d{8}[A-Z]$/i);
    var valorDNI = "" + dni.val();
    //Si es el dni del segundo titular y es igual al del primer
    if (segundoTitular && dniPrimerTitular === valorDNI) {
        campoErroneo(formularioDNI, "Ese DNI pertenece al primer titular");
    } else {
        if (valorDNI.length === 0) {
            campoErroneo(formularioDNI, "Hay que rellenar este campo.");
        } else if (valorDNI.length < 9) {
            campoErroneo(formularioDNI, "El DNI tiene que constar de 8 números y una letra.");
        } else {
            if (expregDni.exec(valorDNI)) {
                var numeros = parseInt(valorDNI.substr(0, 8));
                var resto = numeros % 23;
                var letra = dni.val().substr(8, 1);
                if (letrasDNI[resto] === letra) {
                    dniValido = true;
                    campoCorrecto(formularioDNI);
                } else {
                    campoErroneo(formularioDNI, "La cifra de control del DNI es errónea.");
                }
            } else {
                campoErroneo(formularioDNI, "Formato de DNI incorrecto.");
            }
        }
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