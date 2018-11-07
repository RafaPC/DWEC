'use strict';
//setTimeout("cambiarPagina()", 3000);
//function cambiarPagina() {
//    location.href = 'https://www.google.es';
//}

var opcion = 0;
var arrayCosas = [];

do {
    opcion = parseInt(prompt("1.-Introducir variable/valor\n\
2.-Salir", 1));
    if (opcion === 1) {

        var clave;
        var valor;

        clave = prompt("Clave:", "");
        valor = prompt("Valor:", "");

        arrayCosas[clave] = valor;
    }
} while (opcion !== 2);
//for (var clave in arrayCosas) {
//    document.write("Clave: " + clave + "-Valor: " + arrayCosas[clave]);
//}
var cadena = "http://localhost/archivo.php?";
for (var clave in arrayCosas) {
    cadena += "&" + clave + "=" + arrayCosas[clave];
}

var index = cadena.indexOf("&");
if (index !== -1) {
    var nuevaCadena = cadena.slice(0, index) + cadena.slice(index + 1);
}

index = nuevaCadena.indexOf("?");

var valores = nuevaCadena.slice(index + 1);

document.writeln(valores);
var arrayClavesValor = valores.split("&");

var arrayFinal = [];
for (var i = 0; i < arrayClavesValor.length; i++) {
    document.writeln(clave + arrayClavesValor[clave]);
    var claveValor = arrayClavesValor[0];

}
