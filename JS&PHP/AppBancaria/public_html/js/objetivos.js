/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var lineaTop = 55;
var numeroMiga = 1;
var migaTop = 120;
var objetivos, linea;
$(function () {
    if (typeof (contenidoObjetivos) === "undefined" || contenidoObjetivos.length === 0) {
        $("#lineaObjetivos").css("display", "none");
    } else {
        objetivos = $("#objetivos div");
        linea = $("#lineaObjetivos");
        //Pone el atributo "data-before" y coloca a cada miga
        for (var i = 0; i < objetivos.length; i++) {
            var posicionTop = migaTop + (i * 160);
            objetivos.eq(i).css("top", posicionTop);
            objetivos.eq(i).attr("data-before", contenidoObjetivos[i]);
            if (i > 0) {
                objetivos.eq(i).addClass("objetivoVacio");
            }
        }
        //Pone la primera miga con color
        $("#objetivos").children().eq(0).css("background", "radial-gradient(circle, greenyellow, #01B001)");
    }
});

function migaCompleta() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 2.3;
    linea.css("backgroundPositionY", lineaTop + "%");
    setTimeout(function () {
        objetivos.eq(numeroMiga).removeClass("objetivoFallido");
        objetivos.eq(numeroMiga).removeClass("objetivoVacio");
        objetivos.eq(numeroMiga).addClass("objetivoCompleto");
        numeroMiga++;
    }, 600);
}

function migaError() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 3;
    linea.css("backgroundPositionY", lineaTop + "%");
    lineaTop += 3;
    setTimeout(function () {
        objetivos.eq(numeroMiga).removeClass("objetivoVacio");
        objetivos.eq(numeroMiga).addClass("objetivoFallido");
    }, 600);
}

function migaOmitida() {
    //Cada vez se baja un 3 porciento el background
    lineaTop -= 3;
    linea.css("backgroundPositionY", lineaTop + "%");
    setTimeout(function () {
        objetivos.eq(numeroMiga).removeClass("objetivoFallido");
        objetivos.eq(numeroMiga).removeClass("objetivoVacio");
        objetivos.eq(numeroMiga).addClass("objetivoOmitido");
        numeroMiga++;
    }, 600);
}