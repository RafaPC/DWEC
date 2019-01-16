'use strict';


function checkCuenta() {
    var ncuenta = "" + document.getElementById('ncuenta').value;
    if (ncuenta.length !== 10) {
        $("#ncuenta_err").html("10 car�cteres m�nimo");
    } else {
        var ultimoNumero = parseInt(ncuenta.substr(9, 1));
        for (var i = 0, acum = 0; i < ncuenta.length - 1; i++) {
            acum += parseInt(ncuenta[i]);
        }
        if (acum % 9 === ultimoNumero) {
            $.ajax({
                // la URL para la peticion
                url: 'php/comprobarNcuenta.php',

                // la informacion a enviar
                // (tambien es posible utilizar una cadena de datos)
                data: {numCuenta: ncuenta},

                // especifica si sera una peticion POST o GET
                type: 'POST',

                // el tipo de informaciÃ³n que se espera de respuesta
                dataType: 'json',

                success: function (resultado) {
                    if (resultado.existe === true) {
                        $("#ncuenta").prop("disabled", true);
                        $("#fecha1").toggleClass("oculto");
                        $("#fecha2").toggleClass("oculto");
                        $("#botonSiguiente").off("click");
                        $("#botonSiguiente").on("click", checkFechas);
                    } else {
                        $("#ncuenta_err").html("No existe el n�mero de cuenta");
                    }
                },

                error: function (xhr, status) {
                    alert('Disculpe, existia un problema');
                },

                complete: function (xhr, status) {
                    alert('completada');
                }
            });
        }
    }
}

function checkFechas() {
    var ncuenta = $("#ncuenta").val();
    var fecha1 = $("#fecha1").val();
    var fecha2 = $("#fecha2").val();
    if(fecha1 > fecha2){
        var x = fecha2;
        fecha2 = fecha1;
        fecha1 = x;
    }
    $.ajax({
        // la URL para la peticion
        url: 'php/getMovimientos.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {numCuenta: ncuenta, fecha1: fecha1, fecha2: fecha2},

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        success: function (resultado) {
            printMovimientos(resultado);
        },

        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },

        complete: function (xhr, status) {
            alert('completada');
        }
    });
}

function printMovimientos($movimientos){
    
}

function llamada() {
    var ncuenta = "" + document.getElementById('ncuenta').value;
    $.ajax({
        // la URL para la peticion
        url: 'php/comprobarNcuenta.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {numCuenta: ncuenta},

        // especifica si sera una peticion POST o GET
        type: 'GET',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            checkCuenta2(resultado);
            if (resultado.existe === true) {
                alert("siguiente paso");
            } else {
                alert("repite");
            }
        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema: ' + status);
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
            alert('completada');
        }
    });
}