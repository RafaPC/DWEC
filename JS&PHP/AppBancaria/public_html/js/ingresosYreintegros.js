'use strict';
//Si se entra desde cerrar_cuenta se cambiará a false para que no limpie los
//campos rellenados automáticamente
var limpiarInputs = true;
var botonSiguiente;
var primerToast;
var inputCuenta;
//Si se pone a true es porque se ha redirigido desde cerrar_cuenta
var cerrarCuenta = false;
var importeBien = false;
var conceptoBien = false;
$(function () {
    inputCuenta = $("#input-codigoCuenta");
    //Pone el foco en el input del codigo de cuenta
    inputCuenta.focus();

    //Defino variables globales
    botonSiguiente = $("#botonSiguiente");
    
    //Toast oculto del que hago una copia cada vez que se hace un movimientos
    primerToast = $("#mensajes .toast").eq(0);

    //Escondo el primer toast, por eso luego cada vez que hago una copia
    //tengo que poner display block
    primerToast.css("display", "none");

    //Quita el escuchador definido en "funciones.js" que clicka el botón
    //al presionar el enter
    $(document).off("keypress");

    //Define la primera acción del botón Siguiente
    //Si se entra redirigido desde cerrar_cuenta, se cambiará luego el click
    botonSiguiente.click(function () {
        var codCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

    //Defino el input de concepto como un autocomplete de jQuery UI
    $("#input-concepto").autocomplete({
        //Palabras a autocompletar
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

    //Coge el evento hidden.bs.toast, que es el evento que lanza cada toasts al desaparecer
    //y lo borra del dom, para que no se acumulen
    $("#mensajes").on("hidden.bs.toast", function (event) {
        //Todos los toasts
        var toasts = $("#mensajes .toast");
        //Coge todos los toasts y lo compara con el target del evento
        //que es el toast que se quiere borrar
        for (var i = 0; i < toasts.length; i++) {
            //Cuando lo encuentra lo borra
            if (toasts.get(i) === event.target) {
                //Utilizo remove porque aunque es más lento,
                //quita los escuchadores y los datos del elemento
                toasts.eq(i).remove();
                i = toasts.length;
            }
        }
    });

    //Mira si existe la cookie "codigoCuenta", si existe es que viene de cerrar cuentas
    var codigoCuenta = getCookie("codigoCuenta");
    var saldo = getCookie("saldo");
    if (codigoCuenta !== null && saldo !== null) {
        limpiarInputs = false;
        cerrarCuenta = true;
        //Relleno el campo del codigo de cuenta
        inputCuenta.val(codigoCuenta);
        campoCompleto($("#form-codigoCuenta"));

        //Revelo el campo de concepto y le pongo "Cierre de cuenta" como valor
        $("#form-concepto").removeClass("oculto");
        $("#input-concepto").val("Cierre de cuenta");
        campoCompleto($("#form-concepto"));

        //Revelo el campo de importe y le pongo el saldo de la cuenta (que se ha recibido por la cookie) 
        $("#form-importe").removeClass("oculto");
        campoCompleto($("#form-importe"));
        $("#input-importe").val(-saldo);

        //Pone el botón listo para que se haga el movimiento
        botonSiguiente.off("click");
        botonSiguiente.click(hacerMovimiento);
    }

    //Cuando se hace focus en un campo (concepto o importe) se quitan las clases is-valid e is-invalid
    //Así se espera a salir del campo para ver si es correcto o no
    //Como un borron y cuenta nueva cada vez que se hace focus
    $(".campo").focusin(function () {
        $(this).removeClass("is-valid");
        $(this).removeClass("is-invalid");
        if ($(this) === $("#input-concepto")) {
            conceptoBien = false;
        } else {
            importeBien = false;
        }
    });

    //Estos escuchadores están hechos con javascript normal porque jQuery no permite
    //declarar escuchadores que se ejecuten en la primera fase del evento
    $("#input-concepto").get(0).addEventListener("blur", checkearConcepto, true);
    $("#input-importe").get(0).addEventListener("blur", checkearImporte, true);
});

//Maneja el código de error mandado por comprobarCodigoCuenta
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

//Mira si concepto e importe son correctos, si es así
//mira si el importe es menor de 0, y si es así mira si el saldo es menor
function importeEsMayorQueSaldo() {
    //Antes de entrar aquí ya se han ejecutado las funciones de checkearConcepto y checkearImporte 
    //porque se activan en la primera fase
    if (importeBien && conceptoBien) {
        var ncuenta = $("#input-codigoCuenta").val();
        var importe = parseInt($("#input-importe").val());
        //Solo tiene que checkear el saldo de la cuenta si el importe es negativo
        //ya que la cuenta no debe quedar en negativo
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

//Hace un movimiento
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

            //cerrarCuenta solo está activo si se ha entrado aquí 
            //redirigido por cerrar_cuenta.html
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

//Muestra una ventana modal que pregunta si se quieren ver
//los movimientos del último mes o ir a reintegros para quitar todo el saldo
function mostrarModalCerrarCuenta() {
    //Abro el modal y creo el escuchador de click para el botón de sí 
    $("#modal-cierreCuenta").modal();
    $("#boton-cerrarCuenta-si").click(function () {
        //Escribo cookie con el numero de cuenta para que se reciba en movimientos
        setCookie("codigoCuenta", inputCuenta.val(), 5);
        //Redirijo a movimientos
        $(location).attr("href", "cierre_cuentas.html");
    });
}

//Crea un toast
function crearToast(tipoMovimiento) {
    //Hago una copia del que está en #mensajes
    var nuevoToast = primerToast.clone().css("display", "block");
    //Escribo el concepto como título
    nuevoToast.find("#toast-titulo").html($("#input-concepto").val());
    var mensaje = "Se han " + tipoMovimiento + " ";
    nuevoToast.addClass("toast-" + tipoMovimiento);
    mensaje += $("#input-importe").val() + " euros.";
    nuevoToast.find("#toast-cuerpo").html(mensaje);
    //Lo pone abajo
    nuevoToast.css("marginTop", "100%");
    //Mete el toast en #mensajes, hasta ahora solo era un objeto jQuery y no estaba dentro del dom
    $("#mensajes").append(nuevoToast);
    //Hace aparecer el toast
    nuevoToast.toast("show");
    //Hace que suba
    nuevoToast.css("marginTop", "0");
}

//Mira si el concepto o el importe están mal
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
    //A los 3 segundos y medio la opacidad le cambia a 0 y como tiene puesta
    //una transición en css, cambiará la opacidad lentamente
    setTimeout(function () {
        $("#errorAlert").css("opacity", "0");
    }, 3500);
}

//Mira que el concepto sea correcto
function checkearConcepto() {
    var valor = $("#input-concepto").val();
    if (valor === undefined || valor === "") {
        campoErroneo($("#form-concepto"), "Tienes que escribir un concepto.");
    } else {
        conceptoBien = true;
        campoCorrecto($("#form-concepto"));
    }
}

//Checkea que el importe sea correcto
function checkearImporte() {
    var formImporte = $("#form-importe");
    var importe = $("#input-importe").val();
    //No se ha escrito nada
    if (importe === undefined) {
        campoErroneo(formImporte, "Introduce el importe");
    } else {
        importe = parseInt(importe);
        //Solo se han introducido caracteres no númericos
        if (isNaN(importe)) {
            campoErroneo(formImporte, "Tienes que introducir un número");
            //Se ha introducido un 0
        } else if (importe === 0) {
            $("#input-importe").val(importe);
            campoErroneo(formImporte, "El importe tiene que ser distinto de 0");
        } else {
            importeBien = true;
            //Le vuelvo a poner el valor porque si se escriben numeros y letras, por ejemplo "127aea",
            //al hacer el parseInt() devuelve el valor de los números
            //Así que si se introduce "127eaea" en el campo, al checkearImporte
            //cambiará el valor a 127
            $("#input-importe").val(importe);
            campoCorrecto(formImporte);
        }
    }
}