'use strict';
//alert(Math.floor(Math.random() * (25 - 7 + 1) + 7));

alert(random(200, 300));

//var grados = 180;
//var variable = setInterval("funcion()",200);
//var cambio = 1;
function funcion(){
    var sombra = Math.sin(grados/60);
    document.title = sombra;
    grados += cambio;
    if(grados===360){
        cambio = -1;
    }else if(grados===180){
        cambio = 1;
    }

}


function random(min, max) {

    return Math.floor(Math.random() * (max - min + 1) + min);
}