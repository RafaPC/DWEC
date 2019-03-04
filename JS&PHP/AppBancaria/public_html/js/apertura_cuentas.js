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
var regexps = [];
var letrasDNI = [];
var contenidoMigas = ["Comienzo", "Número de cuenta", "Primer titular", "Segundo titular", "Importe"];
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
    //Inicializa los numeros de cuentas a 0 para que el navegador no los autocomplete (creo que no hace falta)
    $("#num-cuentas-1").val("0");
    $("#num-cuentas-2").val("0");
    botonSiguiente.on("click", function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

    //---------------------VENTANAS MODALES--------------------
    $("#botonSegundoCliente-si").click(function () {
        cliente = 2;
        $("#lista-segundoCliente").removeClass("oculto");
        //Abro el segundo panel de #tabs
        $('#tabs').tabs("option", "active", 1);
        //span para no borrar el icono
        $("#lista-primerCliente").find("span").html("Primer titular");
        formularioDNI = $("#form-dni-2");
        segundoTitular = true;
        dni = $("#dni-2");
        datosCliente = $(".datos-cliente-2");
        inputsCliente = $("#inputs-cliente-2");
        botonSiguiente.on("click", checkCliente);
    });

    $("#botonSegundoCliente-no").click(function () {
        $("#importe").removeClass("oculto");
        $('html, body').animate({
            scrollTop: ($('#importe').offset().top)
        }, 500);
        botonSiguiente.on("click", checkImporte);
        migaOmitida();
    });


//        $("#fecha1").datepicker($.datepicker.regional["es"]);
//        $("#fecha2").datepicker($.datepicker.regional["es"]);
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
    $("#fecha-registro-1").val(fechaActual);
    $("#fecha-registro-2").val(fechaActual);
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
    //Evita que se pueda escribir en los campos de fecha
    //Así jqueryUI se ocupa de que no se sobrepase de ciertos límites
    // y de que se escriba en buen formato
    $("input[data-type = 'fecha']").keydown(function (event) {
        event.preventDefault();
    });

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
            //Completo la primera miga
            migaCompleta();
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
                    //inputsCliente.prop("disabled", true);
                    //datosCliente.addClass("is-valid");
                    //datosCliente.prop("disabled", true);
                    campoCorrecto(inputsCliente);
                    var cliente = respuesta.cliente;
                    for (var i = 1; i < 9; i++) {
                        datosCliente[i].value = cliente[i];
                    }
                    dni.prop("disabled", true);
                    $("#modal-datosCliente").find(".modal-body").html("El titular ya está registrado.");
                    //alert("Titular ya registrado, no se necesita completar su información");
                    if (segundoTitular) {
                        migaCompleta();
                        $("#lista-segundoCliente").removeClass("oculto");
                        existeCliente2 = true;
                        $("#importe").removeClass("oculto");
                        botonSiguiente.off("click");
                        botonSiguiente.on("click", checkImporte);
                    } else {
                        migaCompleta();
                        existeCliente1 = true;
                        //Listener al modal
                        $("#modal-datosCliente button").one("click", function () {
                            setModal();
                        });
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
                    $("#modal-datosCliente").find(".modal-body").html("El titular no está registrado, se necesitan rellenar su información.");
                }

                $("#modal-datosCliente").modal("show");
            },
            error: function (xhr, status) {
                console.log(xhr);
                alert('Disculpe, existia un problema' + status);
            },
            complete: function (xhr, status) {
                unsetCarga();
            }
        });
    }
}

function checkDatosCliente() {
    datosCliente.removeClass("is-invalid");
    //datosCliente.removeClass("error-input");
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
        //inputsCliente.find(".invalid-feedback")[1].classList.remove("error");
        setTimeout(function () {
            inputsCliente.find(".invalid-feedback").eq(1).removeClass("error-feedback");
        }, 350);
    } else {
        //En este trozillo de código intentaba quitar el estilo
        // que pone por defecto el navegador para los campos autocompletados
        alert($(datosCliente).css("backgroundImage"));
        var atributo = $(datosCliente).css("backgroundImage");
        atributo += "!important";
        atributo = "none";
        $(datosCliente).css("backgroundImage", atributo);
        alert($(datosCliente).css("backgroundImage"));
        //------

        inputsCliente.find(".invalid-feedback").eq(1).css("display", "none");
        datosCliente.prop("disabled", true);
        botonSiguiente.off("click");
        alert("Datos completados");
        //Ha chequeado los datos del segundo titular
        if (segundoTitular) {
            migaCompleta();
            botonSiguiente.on("click", checkImporte);
            $("#importe").removeClass("oculto");
            $('html, body').animate({
                scrollTop: ($('#importe').offset().top)
            }, 800);
        } else {
            migaCompleta();
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
                    campoCorrecto(formularioDNI);
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
            campoCorrecto($("#importe"));
            setCarga();
            mandarDatos();
        }
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
            console.log(resultado);
            migaCompleta();
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema' + status);
            migaError();
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
}

//No poner id a los inputs como tal, solo al div que los rodee y coger ese div por id y luego el input que haya dentro