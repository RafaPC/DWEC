'use strict';
window.onload = function () {
    var contador;
    if (window.localStorage.getItem("contador") === null) {
        var duracion = new Date().getTime() + (1000 * 10);
        window.localStorage.setItem("contador", 1 + "-" + duracion);
        contador = 1;
    } else {
        var arrayValores = window.localStorage.getItem("contador");
        arrayValores = arrayValores.split("-");
        var tiempoActual = new Date().getTime();
        if (arrayValores[1] <= tiempoActual) {
            contador = 0;
        } else {
            contador = arrayValores[0];
        }
        window.localStorage.setItem("contador", ++contador + "-" + (tiempoActual + (1000 * 10)));
    }
    document.title = contador;
};

function grabarVariable() {
    var nombre = prompt("Nombre de la variable");
    var valor = prompt("Valor");
    var duracion = prompt("Duracion (segundos)");
    duracion = new Date().getTime() + (duracion * 1000);
    window.localStorage.setItem(nombre, valor + "-" + duracion);
}

function borrarVariable() {
    var nombre = prompt("Nombre de la variable");
    window.localStorage.removeItem(nombre);
}

function leerVariable() {
    var nombre = prompt("Nombre de la variable");
    var variable = window.localStorage.getItem(nombre);
    var arrayValores = variable.split("-");
    var tiempoActual = new Date().getTime();
    if (arrayValores[1] <= tiempoActual) {
        alert("La variable ha caducado");
        window.localStorage.removeItem(nombre);
    } else {
        var tiempoRestante = parseInt(arrayValores[1]) - (tiempoActual);
        tiempoRestante /= 1000;
        alert("Valor: " + arrayValores[0] + " - Tiempo restante(segundos): " + tiempoRestante);
    }

}