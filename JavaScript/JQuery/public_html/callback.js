'use strict';
//function moverCuadro() {
//                $("#prueba").fadeOut(2000, function () {
//                    $("#prueba").css({'top': 300, 'left': 200});
//                    $("#prueba").fadeIn(2000);
//                });
//            }

//function moverCuadro() {
//    $("#prueba").fadeOut(2000, function () {
//        $("#prueba").css({'top': 300, 'left': 200}, function () {
//            $("#prueba").fadeIn(2000);
//        });
//    });
//}

function moverCuadro() {
    $("#prueba").fadeOut(2000, function () {
        $("#prueba").css({'top': 300, 'left': 200});
    });
    $("#prueba").fadeIn(2000, function () {
        $("#prueba").fadeOut(2000, function () {
            $("#prueba").css({'top': 0, 'left': 50});
        });
        $("#prueba").fadeIn(2000);
    });
}

//function moverCuadro() {
//    $("#prueba").fadeOut(2000, function () {
//        $("#prueba").css({'top': 300, 'left': 200});
//    });
//
//    $("#prueba").fadeIn(2000);
//}