'use strict';

var datosCorrectos;
do {
    datosCorrectos = true;
    var añoStart = parseInt(prompt("Año comienzo: ", ""));
    var añoEnd = parseInt(prompt("Año final: ", ""));
    if (isNaN(añoStart) || isNaN(añoEnd)) {
        alert("Tienes que introducir números");
        datosCorrectos = false;
    } else if (añoEnd < añoStart) {
        alert("El final tiene que ser igual o mayor que el principio");
        datosCorrectos = false;
    }
} while (!datosCorrectos);

var arrayAños = new Array(añoEnd - añoStart);
for (var i = 0; i < arrayAños.length; i++) {
    arrayAños[i] = [];
    for (var j = 0; j < 12; j++) {
        arrayAños[i][j] = 0;
    }
}

var opcion = 0;
do {
    opcion = parseInt(prompt("1.- Escribir datos\n\
2.- Mostrar nacimientos por año\n\
3.- Mostrar nacimientos por mes\n\
8.- Salir", ""));
    switch (opcion) {
        case 1:
            crearNacimientos();
            break;
        case 2:
            nacimientosPorAño();
            break;
        case 3:
            nacimientosPorMes();
            break;
        case 8:
            break;
        default :
            alert("Introduce un número válido");
    }
} while (opcion !== 8);

function crearNacimientos() {
    var datoCorrecto;
    var año;
    do {
        datoCorrecto = true;
        año = parseInt(prompt("Año: (entre " + añoStart + " y " + añoEnd + ")", añoStart));
        if (isNaN(año)) {
            datoCorrecto = false;
            alert("Introduce un número");
        } else if (año < añoStart || año > añoEnd) {
            datoCorrecto = false;
            alert("El número debe estar entre " + añoStart + " y " + añoEnd);
        }
    } while (!datoCorrecto);

    var mes;
    do {
        datoCorrecto = true;
        mes = parseInt(prompt("Mes: (en número) ", 1));
        if (isNaN(mes)) {
            datoCorrecto = false;
            alert("Introduce un número");
        } else if (mes < 1 || mes > 12) {
            datoCorrecto = false;
            alert("El número debe estar entre 1 y 12");
        }
    } while (!datoCorrecto);

    var numNacimientos;
    do {
        datoCorrecto = true;
        numNacimientos = parseInt(prompt("Número de nacimientos: ", 1));
        if (isNaN(numNacimientos)) {
            datoCorrecto = false;
            alert("Introduce un número");
        }
    } while (!datoCorrecto);
    var indiceAño = año - añoStart;
//    if (año >= 2000 || año <= 2009) {
//        var añoBueno = ('' + año)[3];
//
//    } else {
//        var añoBueno = ('' + año)[2] + ('' + año)[3];
//    }
//    arrayAños.push(añoBueno);
    arrayAños[indiceAño][mes - 1] += numNacimientos;
}

function nacimientosPorAño() {
    var nacimientosAño;
    for (var i = añoStart; i <= añoEnd; i++) {
        nacimientosAño = 0;
        for (var j = 0; j < arrayAños[añoStart].length; j++) {
            nacimientosAño += arrayAños[i][j];
        }
        var año = i + añoStart;
//        if (i <= 9) {
//            año = 200;
//        } else {
//            año = 20;
//        }
        alert("El año " + año + " nacieron " + nacimientosAño + " niños");
    }
}

function nacimientosPorMes() {
    var nacimientosMes;
    for (var i = 0; i < 12; i++) {
        var mesesOrdenados = new Array(12);
        nacimientosMes = 0;
        for (var j = 0; j < arrayAños.length[0]; j++) {
            nacimientosMes += arrayAños[i][j];
        }
        var mes = i + 1;
        alert("El mes " + mes + " nacieron " + nacimientosMes + " niños");
    }
}