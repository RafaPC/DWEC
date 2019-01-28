'use strict';
var rgbActual;
var aceleracionX = 0.01;
var aceleracionY = 0;
var top, left;
var valorTop, valorLeft;
var intervalW;
var keyPressed;
window.onload = function () {
    rgbActual = "rgb(70,70,70)";
    document.getElementById("abuelo").addEventListener("click", function (event) {
    }, false);
    document.getElementById("padre").addEventListener("click", function (event) {
    }, false);
    document.getElementById("hijo").addEventListener("click", function (event) {
    }, false);
    document.getElementsByTagName("a")[0].addEventListener("click", function (event) {
        alert("entra");
        event.preventDefault();
    });

    document.getElementById("moñeco").style.top = "500px";
    document.getElementById("moñeco").style.left = "500px";


    //Creo los distintos colores
    for (var i = 0; i < 10; i++) {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        var color = document.createElement("div");
        color.classList.add("color");
        color.style.backgroundColor = "rgb(" + r + "," + g + "," + b + ")";
        color.id = "rgb(" + r + "," + g + "," + b + ")";
        document.getElementById("colorPicker").appendChild(color);
    }

    //Añado elemento en el click
    document.body.addEventListener("click", function (event) {
        var elem = document.createElement("div");
        elem.classList.add("flota");
        //alert("Y:" + event.clientY);
        //alert("X:" + event.clientX);
        elem.style.backgroundColor = rgbActual;
        elem.style.top = event.clientY + "px";
        elem.style.left = event.clientX + "px";
        //Muevo elemento al mover el raton
        elem.addEventListener("mousemove", function (event) {
            var posicionX = event.clientX - 10;
            var posicionY = event.clientY - 10;
            elem.style.left = posicionX + "px";
            elem.style.top = posicionY + "px";
        });
        document.body.appendChild(elem);
    });


    //Cambio el color al elegir un color del colorPicker
    document.getElementById("colorPicker").addEventListener("click", function (event) {
        rgbActual = event.target.id;
    });


    document.addEventListener("keypress", function (event) {
        var tecla = event.key;
        if (tecla === "w" || tecla === "W") {
            //document.getElementById("moñeco").style.top = document.getElementById("moñeco").style.top;
            aceleracionY -= 0.1;
        } else if (tecla === "a" || tecla === "A") {
            aceleracionX -= 1;
        } else if (tecla === "s" || tecla === "S") {
            aceleracionY += 1;
        } else if (tecla === "d" || tecla === "D") {
            aceleracionX += 1;
        }
    });

    document.addEventListener("keydown", function (event) {
        var tecla = event.key;
        if (tecla === "w" || tecla === "W") {
            keyPressed = "w";
                intervalW = window.setInterval(function () {
                    if(aceleracionY > -1){
                       aceleracionY -= 0.01; 
                    }else{
                        
                    }  
                }, 200);    
        }
    });
    document.addEventListener("keyup", function (event) {
        if (event.key === "w" || event.key === "W") {
            clearInterval(intervalW);
            aceleracionY = 0;
        }
    });

    var movimiento = window.setInterval(function () {
        var top = document.getElementById("moñeco").style.top;
        var left = document.getElementById("moñeco").style.left;
        var valorTop = parseInt(top.replace("px", ""));
        var valorLeft = parseInt(left.replace("px", ""));

        var movimientoY = aceleracionY * 1;
        var movimientoX = aceleracionX * 1;
        
        //Para escribir el valor de la aceleracion
        document.getElementById("padre").innerHTML = movimientoY;
        
        valorTop += movimientoY;
        valorLeft += movimientoX;
        document.getElementById("moñeco").style.left = valorLeft + "px";
        document.getElementById("moñeco").style.top = valorTop + "px";

        if (document.getElementById("moñeco").getBoundingClientRect() === document.getElementById("colorPicker").getBoundingClientRect()) {
            document.getElementById("colorPicker").style.display = "none";
        }
    }, 10);


};