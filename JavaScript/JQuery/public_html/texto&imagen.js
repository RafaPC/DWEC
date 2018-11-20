'use strict';
$(document).ready(function () {
    //código a ejecutar cuando el DOM está listo para recibir instrucciones.
    $("#parrafo1").mouseover(function (evento) {
        //alert($("#parrafo2").css("visibility"));
        if ($("#parrafo2").css("visibility") === "hidden") {
            $("#parrafo2").removeClass("desaparece");
        } else if ($("#parrafo2").css("visibility") === "visible") {
            $("#parrafo2").addClass("desaparece");
        }
        //alert($("#parrafo2").css("visibility"));

    });
    $("#parrafo2").mouseover(function (evento) {
        //alert($("#parrafo2").css("visibility"));
        if ($("#parrafo1").css("visibility") === "hidden") {
            $("#parrafo1").removeClass("desaparece");
        } else if ($("#parrafo1").css("visibility") === "visible") {
            $("#parrafo1").addClass("desaparece");
        }
        //alert($("#parrafo2").css("visibility"));

    });

    $('#botonDuplicar').click(function () {
        duplicar();
    });

    function duplicar() {
        var height = parseInt($("#imagen").css("height"));
        var width = parseInt($("#imagen").css("width"));
        height = height * 2;
        width = width * 2;
        $("#imagen").css("height",height);
        $("#imagen").css("width",width);
    }

    $('#botonReducir').click(function () {
        reducir();
    });

    function reducir() {
        var height = parseInt($("#imagen").css("height"));
        var width = parseInt($("#imagen").css("width"));
        height = height / 2;
        width = width / 2;
        $("#imagen").css("height",height);
        $("#imagen").css("width",width);
    }
}); 