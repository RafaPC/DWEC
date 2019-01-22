'use strict';
var dni;
var datosCliente;
var inputsCliente;
var segundoTitular;

dni = $("#dni-1");
datosCliente = "datos-cliente-1";
inputsCliente = $("#inputs-cliente-1");
segundoTitular = false;

$("#botonSiguiente").on("click", function () {
    var codCuenta = "" + $("#ncuenta").val();
    comprobarCodigoCuenta(codCuenta);
});

$(function () {
    dni = $("#dni-1");
    datosCliente = "datos-cliente-1";
    inputsCliente = $("#inputs-cliente-1");
    segundoTitular = false;

    $("#botonSiguiente").on("click", function () {
        var codCuenta = "" + $("#ncuenta").val();
        comprobarCodigoCuenta(codCuenta);
    });

//        $("#fecha1").datepicker($.datepicker.regional["es"]);
//        $("#fecha2").datepicker($.datepicker.regional["es"]);
    var dateFormat = "dd/mm/yy";
    var nacimiento = $("#fecha-nacimiento").datepicker({
        defaultDate: "+1m +7d",
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        maxDate: "-18y"
    });
    var registro = $("#fecha-registro").datepicker({
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
            $("#botonSiguiente").off("click");
            //Pongo nuevo listener al botón de siguiente
            $("#botonSiguiente").on("click", checkCliente);
        } else if (codigoErr === -4) {
            $(".invalid-feedback").html("Error del servidor");
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
    $.ajax({
        // la URL para la peticion
        url: 'php/getMovimientos.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {numcuenta: ncuenta, fecha1: fecha1, fecha2: fecha2},
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            printMovimientos(resultado.resultado);
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },
        complete: function (xhr, status) {
        }
    });
}

function printMovimientos(movimientos) {
    if (movimientos.length === 0) {
        alert("No hay ningún movimiento entre esas dos fechas");
    } else {
        $(".table").removeClass("oculto");
        var tbody = document.getElementById("movimientos");
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

function checkCliente() {
    var valorDNI = dni.val();
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
            $("#botonSiguiente").off("click");
            if (resultado.cliente[0] !== undefined) {
                inputsCliente.prop("disabled", true);
                $("." + datosCliente).addClass("is-valid");
                var cliente = resultado.cliente;
                for (var i = 0; i < 9; i++) {
                    document.getElementsByClassName(datosCliente)[i].value = cliente[i];
                    document.getElementsByClassName(datosCliente)[i].disabled = true;
                }
                $("#dni-1").prop("disabled", true);
                $("#radios").removeClass("oculto");
                $("#botonSiguiente").on("click", function () {
                    if ($("#segundo-titular-1").prop("checked")) {
                        segundoTitular = true;
                        $("#form-dni-2").removeClass("oculto");
                        $("#botonSiguiente").on("click", checkCliente);
                        dni = $("#dni-2");
                        datosCliente = "datos-cliente-2";
                        inputsCliente = $("#inputs-cliente-2");
                    } else {
                        //Mostrar input para meter el importe o algo as�, es el siguiente paso
                    }
                });
                alert("Titular ya registrado, no se necesita completar su información");
            } else {
                //Como antes del if ya se muestra el formulario no habría que hacer nada aquí aparentemente
                $("#botonSiguiente").on("click", "checkDatosCliente");
                $("." + datosCliente).val("");
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

function checkDatosCliente() {

}

function checkCliente2() {
    //Comprobar primero que el dni no es el de antes
    checkCliente();
}