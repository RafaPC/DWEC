'use strict';
var filtrarPorImporte = false;
var botonSiguiente;
var inputFechaInicio, inputFechaFin;
//Configuro los datepickers
$(function () {
    inputFechaInicio = $("#input-fecha1");
    inputFechaFin = $("#input-fecha2");

    botonSiguiente = $("#botonSiguiente");
    //Pongo focus al primer input
    $("#input-codigoCuenta").focus();

    //Guardo la tabla
    $("#tabla").hide({duration: 0});

    //------------DATEPICKERS DE JQUERY UI---------------//
    var dateFormat = "dd/mm/yy";
    var fechaInicio = $("#input-fecha1").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    })
            .on("change", function () {
                fechaFin.datepicker("option", "minDate", getDate(this));
            });
    var fechaFin = $("#input-fecha2").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    })
            .on("change", function () {
                fechaInicio.datepicker("option", "maxDate", getDate(this));
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

    //------------SLIDER RANGE DE JQUERY UI------------------//
    $("#checkBox-importe").prop("checked", false);
    $("#slider-range").slider({
        range: true,
        min: -1000,
        max: 1000,
        values: [0, 100],
        slide: function (event, ui) {
            $("#amount").val("Entre " + ui.values[0] + "€ y " + ui.values[1] + "€");
        }
    });
    $("#amount").val("Entre " + $("#slider-range").slider("values", 0) +
            "€ y " + $("#slider-range").slider("values", 1) + "€");

    //Añado listener al checkbox, al cambiar mostrará el rango de dinero
    //Cuando cambia, cambio la variable global filtrarPorImporte y hago toggle al slider
    //Si está oculto toggle lo hace aparecer y si ya aparecía lo oculta
    $("#checkBox-importe").change(function () {
        filtrarPorImporte = $("#checkBox-importe").checked;
        $("#sliderRangePrecio").toggleClass("oculto");
    });

    //Pongo evento al botón de Siguiente
    botonSiguiente.on("click", function () {
        var codigoCuenta = $("#input-codigoCuenta").val();
        comprobarCodigoCuenta(codigoCuenta);
    });

    //Mira si existe la cookie "codigoCuenta", si existe es que viene de cerrar cuentas
    var codigoCuenta = getCookie("codigoCuenta");
    if (codigoCuenta !== null) {
        $("#input-codigoCuenta").val(codigoCuenta);
        codigoCuentaCorrecto();
        fechaInicio.datepicker("setDate", "-1m");
        fechaFin.datepicker("setDate", "0d");
        checkFechas();
    }
});

//Para inicializar el slider
$(function () {

});

function checkFechas() {
    var faltanDatos;

    var codCuenta = $("#input-codigoCuenta").val();
    var fecha1 = inputFechaInicio.val();
    var fecha2 = inputFechaFin.val();
    if (fecha1 === "") {
        inputFechaInicio.addClass("is-invalid");
        faltanDatos = true;
    } else {
        inputFechaInicio.removeClass("is-invalid");
    }
    if (fecha2 === "") {
        inputFechaFin.addClass("is-invalid");
        faltanDatos = true;
    } else {
        inputFechaFin.removeClass("is-invalid");
    }
    if (!faltanDatos) {
        setCarga();
        $("caption").eq(0).html("Lista de movimientos del " + fecha1 + " al " + fecha2 + ".");
        var llamada = {cod_cuenta: codCuenta, fecha1: fecha1, fecha2: fecha2};
        if ($("#checkBox-importe").prop("checked")) {
            llamada.importeMinimo = $("#slider-range").slider("values", 0);
            llamada.importeMaximo = $("#slider-range").slider("values", 1);
        }

        $.ajax({
            // la URL para la peticion
            url: 'php/getMovimientos.php',
            // la informacion a enviar
            data: llamada,
            // especifica si sera una peticion POST o GET
            type: 'POST',
            // el tipo de informacion que se espera de respuesta
            dataType: 'json',
            success: function (respuesta) {
                //Checkea si ha habido algún error en el servidor
                if (typeof (respuesta.cod_err) === "undefined") {
                    $("#tabla").hide("blind", {easing: "easeOutExpo"}, 500);
                    if (respuesta.movimientos.length === 0) {
                        alert("No hay ningún movimiento entre esas dos fechas");
                    } else {
                        printMovimientos(respuesta.movimientos);
                    }
                } else {
                    mostrarErrorAjax(respuesta.cod_err, "coger los movimientos de la cuenta");
                }

            },
            error: function () {
                mostrarErrorAjax("-7", "coger los movimientos de la cuenta");
            },
            complete: function (xhr, status) {
                unsetCarga();
            }
        });
    }
}

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        codigoCuentaCorrecto();
    } else {
        if (codigoErr === -1) {
            campoErroneo($("#codigoCuenta"), "El código tiene que tener al menos 10 números.");
        } else if (codigoErr === -2) {
            campoErroneo($("#codigoCuenta"), "El código no cumple el formato.");
        } else if (codigoErr === -3) {
            campoErroneo($("#codigoCuenta"), "El código no está registrado.");
        } else if (codigoErr <= 7) {
            campoErroneo($("#codigoCuenta"), codigosErrores[codigoErr]);
        }
    }
}

function printMovimientos(movimientos) {
    var tbody = $("#movimientos")[0];
    //Si el tbody ya tiene elementos dentro los borra todos antes de escribir más
    if (tbody.childElementCount > 0) {
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
    }

    for (var i = 0; i < movimientos.length; i++) {
        var tr = document.createElement("tr");
        if (movimientos[i]['importe'] > 0) {
            tr.classList = "table-success";
        } else {
            tr.classList = "table-danger";
        }

        for (var clave in movimientos[i]) {
            var td = document.createElement("td");
            var txt = movimientos[i][clave];
            if ("fecha" === clave) {
                txt = convertirFecha(txt);
            } else if ("importe" === clave) {
                txt += "€";
            } else if ("hora" === clave) {
                //Le añade los dos (dos) puntos a la hora
                txt = txt.substr(0, 2) + ":" + txt.substr(2, 2) + ":" + txt.substr(4, 2);
            }
            var txtNode = document.createTextNode(txt);
            td.appendChild(txtNode);
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }

    $("#tabla").show("fold", {easing: "easeOutExpo"}, 1000);
    setTimeout(function () {
        //var x = $("#tabla :last-child");
        $('html, body').animate({
            scrollTop: ($("#tabla :last-child").offset().top)
        }, 1100);
    }, 1000);
}

function codigoCuentaCorrecto() {
    campoCompleto($("#codigoCuenta"));
    $("#fechas").removeClass("oculto");
    $("#check").removeClass("oculto");
    $("#botonSiguiente").off("click");
    $("#botonSiguiente").on("click", checkFechas);
}