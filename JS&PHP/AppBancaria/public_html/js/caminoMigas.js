/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var lineaTop = 55;
var numeroMiga = 1;
var migaTop = 20;
$(function () {
    //Crear migas como tal
    var caminoMigas = $("#caminoMigas div");
    for (var i = 0; i < contenidoMigas.length; i++) {
        caminoMigas.eq(i).attr("data-before", contenidoMigas[i]);
    }
    //Pone la primera miga con color
    $("#caminoMigas").children().eq(0).css("background", "radial-gradient(circle, blue, lightskyblue)");

    //TENGO QUE MIRAR SI PONER LAS MIGAS (DIVS) EN HTML DIRECTAMENTE (Y ASI SOLO TENDRIAN QUE COLOCARSE) 
    //O SOLAMENTE EL ARRAY DE MIGAS EN JS Y QUE SE HAGAN LOS DIVS Y SE COLOQUEN
    //
    //creo que estaría mejor dejarlo todo con js, no se
    //
    //Pone todas las migas en su posición (dando por hecho que ya están colocadas en html)   
    var migas = $("#caminoMigas").children();
    for (var i = 0; i < migas.length; i++) {
        var posicionTop = migaTop + (i * 180);
        migas.eq(i).css("top", posicionTop);
    }
});

function migaCompleta() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 2.3;
    $("#linea").css("backgroundPositionY", lineaTop + "%");
    setTimeout(function () {
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundImage", "radial-gradient(circle, rgba(255,255,255,0.3) 0.1%, rgba(173,255,47,0.3), rgba(0,128,0))");
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundSize", "100% 100%");
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundSize", "100% 100%");
        numeroMiga++;
    }, 380);
}

function migaError() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 3;
    $("#linea").css("backgroundPositionY", lineaTop + "%");
    setTimeout(function () {
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundImage", "radial-gradient(circle, white 0.1%, red, crimson)");
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundSize", "100% 100%");
        numeroMiga++;
    }, 380);
}

function migaOmitida() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 3;
    $("#linea").css("backgroundPositionY", lineaTop + "%");
    setTimeout(function () {
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundImage", "radial-gradient(circle, white 0.1%, grey, black)");
        $("#caminoMigas").children().eq(numeroMiga).css("backgroundSize", "100% 100%");
        numeroMiga++;
    }, 380);
}