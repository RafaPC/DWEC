/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var intervalGravedad;
var gravedad = 10;
var apertura = 300;

window.onload = function () {
    //Pongo el flappy
    document.getElementById("flappy").style.top = "400px";
    document.getElementById("flappy").style.right = "1400px";
    var intervalCrearTubos = window.setInterval(function () {
        var tuboArriba = document.createElement("div");
        tuboArriba.classList.add("tubarro");
        tuboArriba.style.right = "0px";
        var tuboAbajo = tuboArriba.cloneNode(true);

        tuboArriba.style.top = "0px";
        tuboAbajo.style.bottom = "0px";

        var minimo = random(100, 600);
        tuboAbajo.style.height = minimo + "px";
        //En vez de poner 1000, poner el height de la ventana, o del body
        var maximo = 1000 - minimo - apertura;
        tuboArriba.style.height = maximo + "px";


        document.body.appendChild(tuboArriba);
        document.body.appendChild(tuboAbajo);
        //Crea intervalo
        var intervalMoverTubos = window.setInterval(function () {
            tuboX = parseInt((tuboArriba.style.right).replace("px", ""));
            //Aqui coger el width de la ventana y ya esta
            if (tuboX > 1900) {
                tuboArriba.outerHTML = "";
                tuboAbajo.outerHTML = "";
            } else {
                tuboX += 5;
                tuboArriba.style.right = tuboX + "px";
                tuboAbajo.style.right = tuboX + "px";
            }
        }, "10");

        var intervalComprobarColision = window.setInterval(function () {
            
            var topeArriba = parseInt((tuboArriba.style.height).replace("px", ""));
            var topeAbajo = 1000 - parseInt((tuboArriba.style.height).replace("px", ""));

            tuboX = parseInt((tuboArriba.style.right).replace("px", ""));
            
            //Los tubos estan en la misma posicion horizontal que el flappy
            if (tuboX > 1390 && tuboX < 1410) {
                var flappy = document.getElementById("flappy");
                flappyY = parseInt((flappy.style.top).replace("px", ""));
                //Flappy se encuentra entre los dos tubos
                if (flappyY > topeArriba && flappyY < topeAbajo) {
                    var puntuacion = parseInt(document.getElementById("puntuacion").innerHTML);
                    puntuacion++;
                    document.getElementById("puntuacion").innerHTML = puntuacion;
                }else{
                    document.getElementById("puntuacion").innerHTML = 0;
                }
            }
        }, "30");

        //Cada vez el hueco entre cada par de tubos es mas pequeño
        apertura -= 1;
    }, "1000");



//Gravedad del flappy
    intervalGravedad = window.setInterval(function () {
        var top = document.getElementById("flappy").style.top;
        var valorTop = parseInt(top.replace("px", ""));
        if (valorTop > 850) {
            window.clearInterval(intervalGravedad);
        }
        var caida = gravedad * 1;
        gravedad += 2;
        var topActualizado = valorTop + caida;
        document.getElementById("flappy").style.top = topActualizado + "px";
    }, "30");

//Saltos del flappy
    document.addEventListener("keypress", function (event) {
        var tecla = event.key;
        if (tecla == " ") {
            gravedad = -20;
        }
    });


    window.setInterval(detectarColision, "50");
};

function random(min, max) {

    return Math.floor(Math.random() * (max - min + 1) + min);
}