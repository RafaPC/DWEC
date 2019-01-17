'use strict';
function checkCuenta() {
    var ncuenta = "" + document.getElementById('ncuenta').value;
    if (ncuenta.length !== 10) {
        $("#ncuenta_err").html("10 carácteres mínimo");
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
                data: {numcuenta: ncuenta},
                // especifica si sera una peticion POST o GET
                type: 'POST',
                // el tipo de informaciÃƒÂ³n que se espera de respuesta
                dataType: 'json',
                success: function (resultado) {
                    if (resultado.existe === true) {
                        $("#ncuenta").prop("disabled", true);
                        $("#fecha1").toggleClass("oculto");
                        $("#fecha2").toggleClass("oculto");
                        $("#botonSiguiente").off("click");
                        $("#botonSiguiente").on("click", checkFechas);
                    } else {
                        $("#ncuenta_err").html("No existe el número de cuenta");
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
    if (new Date(fecha1).getTime() > new Date(fecha2).getTime()) {
        var x = fecha2;
        fecha2 = fecha1;
        fecha1 = x;
    }
    $.ajax({
        // la URL para la peticion
        url: 'php/getMovimientos.php',
        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {numcuenta: ncuenta, fecha1: fecha1, fecha2: fecha2},
        // especifica si sera una peticion POST o GET
        type: 'POST',
        // el tipo de informaciÃƒÂ³n que se espera de respuesta
        dataType: 'json',
        success: function (resultado) {
            printMovimientos(resultado.resultado);
        },
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },
        complete: function (xhr, status) {
            alert('completada');
        }
    });
}

function printMovimientos(movimientos) {
    var table = document.createElement("table");
    document.body.appendChild(table);
    var primeraVez = true;
    for (var i = 0; i < movimientos.length; i++) {
        var tr = document.createElement("tr");
        if (primeraVez) {
            var thead = table.appendChild(document.createElement("thead"));
            table.appendChild(thead);
            thead.appendChild(tr);
        } else if (i === 1) {
            var tbody = table.appendChild(document.createElement("tbody"));
            table.appendChild(tbody);
            tbody.appendChild(tr);
        } else {
            table.appendChild(tr);
        }
        for (var clave in movimientos[i]) {
            var td = document.createElement("td");
            var txt = document.createTextNode(movimientos[i][clave]);
            if (primeraVez) {
                td = document.createElement("th");
                txt = document.createTextNode(clave);
            }

            td.appendChild(txt);
            tr.appendChild(td);
        }
        if(primeraVez){
            primeraVez = false;
            i--;
        }
    }
}

