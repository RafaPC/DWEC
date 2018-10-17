//'use strict';
//var dia = prompt("Mete día: ", 0);
//var mes = prompt("Mete mes: ", 0);
//var año = prompt("Mete año: ", 0);
//var fecha = new Date(año, mes-1, dia, 0, 0, 0, 0);
//var dias = [ 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo', 'Lunes'];
//var meses = [ 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero'];
//document.write(dias[fecha.getDay()] + " " + fecha.getDay() + " de " + meses[fecha.getMonth()] + " de " + fecha.getFullYear());

var intervaloCronometro;
var fechaInicial;

function iniciarCronometro() {
    fechaInicial = new Date();
    intervaloCronometro = setInterval("tituloSegundos()", 1000);
}
function tituloSegundos() {
    var fechaActual = new Date();
    document.title = Math.round(((fechaActual - fechaInicial) / 1000));
}

function pararCronometro() {
    clearInterval(intervaloCronometro);
}

document.write("<a href=\"javascript:iniciarCronometro()\">Iniciar cronometro</a>");
document.write("<a href=\"javascript:pararCronometro()\">Parar cronometro</a>");