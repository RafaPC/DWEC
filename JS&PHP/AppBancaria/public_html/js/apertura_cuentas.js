'use strict';
var limpiarInputs = true;
var botonSiguiente;
var dni;
var datosCliente;
var formularioDNI;
var inputsCliente;
var segundoTitular = false;
var dniPrimerTitular = null;
var existeCliente1 = false, existeCliente2 = false;
var fechaActual;
var regexps = [];
var letrasDNI = [];
//Array con el número y nombre de cada objetivo a cumplir
//Este array se utiliza en "objetivos.js" para crear la lista de objetivos que aparece a la derecha
var contenidoObjetivos = ["Comienzo", "Número de cuenta", "Primer titular", "Segundo titular", "Importe"];
$(function () {
    //Regexps necesarios para checkear datos
    regexps["telefono"] = /^91\d{7}$/;
    regexps["email"] = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    regexps["fecha"] = /^((0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/([12]\d{3}))$/;
    letrasDNI = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];

    //Define la variable que apunta al botón de siguiente
    botonSiguiente = $("#botonSiguiente");
    //Define el dni como el dni del primer cliente
    dni = $("#dni-1");
    datosCliente = $(".datos-cliente-1");
    formularioDNI = $("#form-dni-1");
    inputsCliente = $("#inputs-cliente-1");
    botonSiguiente.on("click", function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

    //---------------------VENTANAS MODALES--------------------
    //Si se clicka que se quiere incluir segundo titular
    $("#boton-segundoCliente-si").click(function () {
        segundoTitular = true;
        //Cambio las variables para que referencien a los inputs del segundo cliente
        dni = $("#dni-2");
        formularioDNI = $("#form-dni-2");
        datosCliente = $(".datos-cliente-2");
        inputsCliente = $("#inputs-cliente-2");
        botonSiguiente.on("click", checkCliente);

        //Quito los escuchadores puestos para las teclas "Escape" y "Enter" para el modal
        $("#modal-segundoCliente").off("keypress keydown");

        //Desoculto el boton que abre el panel del segundo titular
        $("#lista-segundoCliente").removeClass("oculto");

        //Focus en el dni del segundo cliente
        $("#dni-2").focus();

        //Abro el segundo panel de #tabs
        $('#tabs').tabs("option", "active", 1);

        //Cambio el texto del primer panel de "Titular" a "Primer titular"
        $("#lista-primerCliente span").html("Primer titular");


        //Espera medio segundo, para que el segundo panel ya se haya abierto
        setTimeout(function () {
            //
            dni.focus();
            $('html, body').animate({
                scrollTop: (botonSiguiente.offset().top)
            }, 1200);
        }, 500);
    });

    //Si se clicka que no se quiere añadir segundo titular
    $("#boton-segundoCliente-no").click(function () {
        //Quito los event listener puestos para las teclas "Escape" y "Enter"
        $("#modal-segundoCliente").off("keypress keydown");
        
        //Omito el objetivo porque no se ha puesto segundo titular
        objetivoOmitido();
        descubrirImporte();
    });

    //----------------------FECHAS--------------------
    var fecha = new Date();
    var dia = fecha.getDate();
    var mes = fecha.getMonth() + 1;
    var año = fecha.getFullYear();
    dia += "";
    if (dia.length === 1 && dia !== 0) {
        dia = "0" + dia;
    }
    mes += "";
    if (mes.length === 1 && mes !== 0) {
        mes = "0" + mes;
    }
    fechaActual = dia + "/" + mes + "/" + año;
    //Pongo de forma predeterminada las fechas de registro a la fecha actual
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

    //----------------RELLENAR INPUTS------------------//
    $("#fecha-registro-1").val(fechaActual);
    $("#fecha-registro-2").val(fechaActual);
    $("#num-cuentas-1").val(0);
    $("#saldo-1").val(0);
    $("#saldo-2").val(0);
    //----------------TABS DE JQUERY UI----------------//
    $("#tabs").tabs({
        hide: 'fold',
        show: 'fold'
    });
});

//Maneja el código de error mandado por comprobarCodigoCuenta
function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        campoErroneo($("#form-codigoCuenta"), "El código de cuenta ya está registrado.");
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#form-codigoCuenta"), "El código tiene que tener 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#form-codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            //Completo el primer objetivo
            objetivoCompleto();
            //Quito la clase oculto a #tabs
            $("#tabs").removeClass("oculto");
            //Focus en el dni del primer cliente
            $("#dni-1").focus();
            $('html, body').animate({
                scrollTop: (botonSiguiente.offset().top)
            }, 1200);
            //En este caso, el mensaje de error -3, no existe usuario,
            //es el que da paso a las siguientes fases del formulario
            campoCompleto($("#form-codigoCuenta"));
            //Quito la clase oculto al siguiente input para mostrarlo
            $("#lista-primerCliente").removeClass("oculto");
            //Quito el listener que tenía el botón de Siguiente
            botonSiguiente.off("click");
            //Pongo nuevo listener al botón de siguiente
            botonSiguiente.on("click", checkCliente);
        } else if (codigoErr <= -7) {
            campoErroneo($("#form-codigoCuenta"), codigosErrores[codigoErr]);
            objetivoError();
        }
    }
}

function checkCliente() {
    var valorDNI = dni.val();
    if (checkDNI()) {
        setCarga();
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
                    campoCompleto(inputsCliente);
                    var cliente = respuesta.cliente;
                    for (var i = 1; i < 9; i++) {
                        var valor = cliente[i];
                        if (i === 5 || i === 6) {
                            valor = convertirFecha(valor);
                        }
                        datosCliente[i].value = valor;
                    }
                    dni.prop("disabled", true);
                    $("#modal-datosCliente").find(".modal-body").html("El titular ya está registrado.");
                    //alert("Titular ya registrado, no se necesita completar su información");
                    if (segundoTitular) {
                        objetivoCompleto();
                        $("#lista-segundoCliente").removeClass("oculto");
                        existeCliente2 = true;
                        $("#importe").removeClass("oculto");
                        botonSiguiente.off("click");
                        botonSiguiente.on("click", checkImporte);
                    } else {
                        //Completo el objetivo
                        objetivoCompleto();
                        existeCliente1 = true;
                        //Listener al modal que informa de que el usuario ya existe
                        // para que cuando se cierre abra el siguiente modal
                        //Pongo el evento una sola vez
                        $("#modal-datosCliente").one("hidden.bs.modal", function () {
                            setModal();
                        });
                    }
                } else {
                    //Quito la propiedad disabled a todos los inputs
                    datosCliente.slice(1).prop("disabled", false);
                    //Pongo al input de fecha de registro la fecha actual
                    datosCliente.slice(6).prop("disabled", true);
                    datosCliente.slice(6).addClass("is-valid");
                    //Como antes del if ya se muestra el formulario no habría que hacer nada aquí aparentemente
                    botonSiguiente.off("click");
                    botonSiguiente.on("click", checkDatosCliente);
                    $("#modal-datosCliente").find(".modal-body").html("El titular no está registrado, se necesitan rellenar su información.");

                    $("#modal-datosCliente").one("hidden.bs.modal", function () {
                        datosCliente.eq(1).focus();
                    });
                }

                $("#modal-datosCliente").modal("show");
            },
            error: function (xhr, status) {
                mostrarInfo(true, "-7", "comprobar si existía un cliente en la base de datos");
                objetivoError();
            },
            complete: function (xhr, status) {
                unsetCarga();
            }
        });
    }
}

function checkDatosCliente() {
    datosCliente.removeClass("is-invalid");
    var error, errorInput;
    for (var i = 1; i <= 5; i++) {
        errorInput = false;
        if ((datosCliente[i].value).length === 0) {
            errorInput = true;
        } else {
            var tipoDato = datosCliente.eq(i).attr("data-type");
            if (typeof tipoDato !== "undefined") {
                if (!regexps[tipoDato].test(datosCliente[i].value)) {
                    //Si no cumple la expresion regular
                    errorInput = true;
                }
            }
        }
        if (errorInput) {
            error = true;
            datosCliente.eq(i).addClass("is-invalid");
            datosCliente.eq(i).addClass("error-input");
        } else {
            datosCliente.eq(i).addClass("is-valid");
        }
    }
    setTimeout(function () {
        datosCliente.removeClass("error-input");
    }, 350);

    if (error) {
        inputsCliente.find(".invalid-feedback").eq(1).css("display", "block");
        inputsCliente.find(".invalid-feedback").eq(1).addClass("error-feedback");
        setTimeout(function () {
            inputsCliente.find(".invalid-feedback").eq(1).removeClass("error-feedback");
        }, 350);
    } else {
        //Deshabilito todos los campos del cliente actual (puede ser el primero )
        datosCliente.prop("disabled", true);
        botonSiguiente.off("click");
        alert("Datos completados");
        //Ha chequeado los datos del segundo titular
        if (segundoTitular) {
            objetivoCompleto();
            descubrirImporte();
        } else {
            objetivoCompleto();
            //El primer titular no existía, pero ya se han checkeado sus datos y son correctos
            //Por lo tanto el siguiente paso es preguntar si se quiere añadir un segundo titular
            setModal();
        }
    }
}

//Que directamente se llame a dni cuando toque, sin pasar por checkCliente
function checkDNI() {
    var dniValido = false;
    var expregDni = new RegExp(/^\d{8}[A-Z]$/);
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
                    campoCompleto(formularioDNI);
                } else {
                    campoErroneo(formularioDNI, "La letra del DNI es errónea.");
                }
            } else {
                campoErroneo(formularioDNI, "Formato de DNI incorrecto.");
            }
        }
    }

    return dniValido;
}

function checkImporte() {
    var importe = $("#input-importe").val();
    if (importe === "") {
        campoErroneo($("#importe"), "Hay que introducir el importe.");
    } else {
        importe = parseInt(importe);
        if (importe !== importe) {
            campoErroneo($("#importe"), "El importe tiene que ser un valor numérico.");
        } else if (importe <= 0) {
            campoErroneo($("#importe"), "El importe tiene que ser mayor de 0");
        } else {
            campoCompleto($("#importe"));
            setCarga();
            mandarDatos();
        }
    }
}

function mandarDatos() {
    var llamada = new Object();
    var cliente1 = [];
    var cliente2 = [];
    llamada.cod_cuenta = $("#input-codigoCuenta").val();
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
        success: function (respuesta) {
            if (respuesta.cod_err === 1) {
                objetivoCompleto();
                mostrarInfo(false, 0, "Se ha creado la cuenta correctamente");
                botonSiguiente.off();
            } else {
                mostrarInfo(true, respuesta.cod_err, "intentar abrir una cuenta");
            }
        },
        error: function (xhr, status) {
            mostrarInfo(true, "-7", "introducir datos de la cuenta");
            objetivoError();
        },
        complete: function (xhr, status) {
            unsetCarga();
        }
    });
}

function setModal() {
    $("#modal-segundoCliente").modal({
        //Pone el fondo oscuro pero no cierra el modal al hacer click fuera
        backdrop: 'static',
        //No cierra el modal al presionar Esc
        keyboard: false
    });

    //Hay otro evento para que cuando se presione "Enter" haga click en botonSiguiente
    //Para evitar que se llame a ese evento en este caso, creo un escuchador
    // que salta en la primera fase del evento y para su propagación, así 
    // el otro escuchador no llega a cogerlo
    $("#modal-segundoCliente").get(0).addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            $("#boton-segundoCliente-si").click();
            event.stopPropagation();
        }
    }, true);
    $("#modal-segundoCliente").keydown(function (event) {
        if (event.key === "Escape") {
            $("#boton-segundoCliente-no").click();
        }
    });

}

function descubrirImporte() {
    botonSiguiente.on("click", checkImporte);
    $("#importe").removeClass("oculto");
    $('html, body').animate({
        scrollTop: (botonSiguiente.offset().top)
    }, 800);
    setTimeout(function () {
        $("#input-importe").focus();
    }, 100);

}