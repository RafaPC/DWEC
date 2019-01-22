'use strict';
var filtrarPorImporte = false;

//Configuro los datepickers
$(function () {
//        $("#fecha1").datepicker($.datepicker.regional["es"]);
//        $("#fecha2").datepicker($.datepicker.regional["es"]);
    var dateFormat = "dd/mm/yy";
    var from = $("#fecha1").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            });
    var to = $("#fecha2").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        firstDay: 1
    })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
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
});

$(function () {
//A�ado listener al checkbox, al cambiar mostrar� el rango de dinero
    $("#checkBox-importe").on("change", function () {
        filtrarPorImporte = $("#checkBox-importe").checked;
        $("#sliderRangePrecio").toggleClass("oculto");
    });

//Pongo evento al bot�n de Siguiente
    $("#botonSiguiente").on("click", function () {
        var codCuenta = "" + $("#ncuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });
});

//Para inicializar el slider
$(function () {
    //ESTO NO FUNCIONA
    $("#checkBox-importe").prop("checked", false);
    $("#slider-range").slider({
        range: true,
        min: -2000,
        max: 2000,
        values: [0, 100],
        slide: function (event, ui) {
            $("#amount").val("Entre " + ui.values[ 0 ] + "€ y " + ui.values[ 1 ] + "€");
        }
    });
    $("#amount").val("Entre " + $("#slider-range").slider("values", 0) +
            "€ y " + $("#slider-range").slider("values", 1) + "€");
});

function checkCuenta() {
    var ncuenta = "" + document.getElementById('ncuenta').value;
    if (ncuenta.length !== 10) {
        $(".invalid-feedback").html("Por favor introduce in código de cuenta válido");
        $(".invalid-feedback").css("display", "block");
        $("#ncuenta").addClass("is-invalid");
    } else {
        var ultimoNumero = parseInt(ncuenta.substr(9, 1));
        for (var i = 0, acum = 0; i < ncuenta.length - 1; i++) {
            acum += parseInt(ncuenta[i]);
        }
        if (acum % 9 === ultimoNumero) {
            $.ajax({
                // la URL para la peticion
                url: 'php/comprobarCodigoCuenta.php',
                // la informacion a enviar
                // (tambien es posible utilizar una cadena de datos)
                data: {cod_cuenta: ncuenta},
                // especifica si sera una peticion POST o GET
                type: 'POST',
                // el tipo de informaciÃ³n que se espera de respuesta
                dataType: 'json',
                success: function (resultado) {
                    if (resultado.existe === true) {
                        $("#ncuenta").prop("disabled", true);
                        $("#fechas").removeClass("oculto");
                        $("#cosa").removeClass("oculto");
                        $("#botonSiguiente").off("click");
                        $("#botonSiguiente").on("click", checkFechas);
                        $(".invalid-feedback").css("display", "none");
                        $("#ncuenta").removeClass("is-invalid");
                        $("#ncuenta").addClass("is-valid");
                    } else {
                        $(".invalid-feedback").html("No existe ese código de cuenta.");
                        $(".invalid-feedback").css("display", "block");
                        $("#ncuenta").addClass("is-invalid");
                    }
                },
                error: function (xhr, status) {
                    alert('Disculpe, existia un problema' + status);
                },
                complete: function (xhr, status) {
                }
            });
        } else {
            $("#ncuenta_err").html("Ese codigo no vale");
        }
    }
}

function checkFechas() {
    var ncuenta = $("#ncuenta").val();
    var fecha1 = $("#fecha1").datepicker("getDate");
    var fecha2 = $("#fecha2").datepicker("getDate");
    document.getElementsByTagName("caption")[0].innerHTML = "Lista de movimientos de " + fecha1.getDate() + "/" + (fecha1.getMonth() + 1) + "/" + fecha1.getFullYear() + " a " + fecha2.getDate() + "/" + (fecha2.getMonth() + 1) + "/" + fecha2.getFullYear();
    fecha1 = fecha1.getFullYear() + "/" + (fecha1.getMonth() + 1) + "/" + fecha1.getDate();
    fecha2 = fecha2.getFullYear() + "/" + (fecha2.getMonth() + 1) + "/" + fecha2.getDate();
    var llamada = {numcuenta: ncuenta, fecha1: fecha1, fecha2: fecha2};
    if ($("#checkBox-importe").prop("checked")) {
        llamada.importeMinimo = $("#slider-range").slider("values", 0);
        llamada.importeMaximo = $("#slider-range").slider("values", 1);
    }

    $.ajax({
        // la URL para la peticion
        url: 'php/getMovimientos.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: llamada,
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            printMovimientos(resultado.movimientos);
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },
        complete: function (xhr, status) {
        }
    });
}

function handleCodCuenta(codigoErr) {
    if (codigoErr === 1) {
        $(".invalid-feedback").css("display", "none");
        $("#ncuenta").removeClass("is-invalid");
        $("#ncuenta").addClass("is-valid");
        $("#ncuenta").prop("disabled", true);
        $("#fechas").removeClass("oculto");
        $("#check").removeClass("oculto");
        $("#botonSiguiente").off("click");
        $("#botonSiguiente").on("click", checkFechas);
    } else {
        $(".invalid-feedback").css("display", "block");
        $("#ncuenta").addClass("is-invalid");
        if (codigoErr === -1) {
            $(".invalid-feedback").html("El codigo tiene que tener al menos 10 números");
        } else if (codigoErr === -2) {
            $(".invalid-feedback").html("El código no cumple el formato");
        } else if (codigoErr === -3) {
            $(".invalid-feedback").html("El código no está registrado");
        } else if (codigoErr === -4) {
            $(".invalid-feedback").html("Error del servidor");
        }
    }
}

function printMovimientos(movimientos) {
    //Si no se ha devuelto ning�n movimiento
    if (movimientos.length === 0) {
        alert("No hay ningún movimiento entre esas dos fechas");
    } else {
        $(".table").removeClass("oculto");
        var tbody = document.getElementById("movimientos");

        //Si el tbody ya tiene elementos dentro los borra todos antes de escribir m�s
        if (tbody.childElementCount > 0) {
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
        }


        for (var i = 0; i < movimientos.length; i++) {
            var tr = document.createElement("tr");
            tbody.appendChild(tr);
            var ultimo_tr = tbody.lastChild;
            if (movimientos[i]['importe'] > 0) {
                ultimo_tr.classList = "table-success";
            } else {
                ultimo_tr.classList = "table-danger";
            }

            for (var clave in movimientos[i]) {
                var td = document.createElement("td");
                var txt = movimientos[i][clave];
                if (clave === "importe") {
                    txt += "€";
                }
                var txtNode = document.createTextNode(txt);
                td.appendChild(txtNode);
                tr.appendChild(td);
            }
        }
    }
}

