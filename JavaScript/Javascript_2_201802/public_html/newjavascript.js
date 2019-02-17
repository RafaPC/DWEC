/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

document.addEventListener("readystatechange", function () {
    if (document.readyState === 'complete') {
        //Listener a la imagen
        document.getElementsByTagName("img")[0].addEventListener("click", mandarDatos);

        //Escuchar cuando se clickea un input
        var inputs = document.getElementsByName("regalo");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener("change", function () {
                var inputs = document.getElementsByName("regalo");
                var contador = 0;
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].checked) {
                        contador++;
                    }
                }
                if (contador > 0) {
                    document.getElementsByTagName("img")[0].style.display = "block";
                } else {
                    document.getElementsByTagName("img")[0].style.display = "none";
                }
            });
        }
        window.setInterval(function () {
            //local storage
            setCookie("fecha", new Date().toUTCString());
            navigator.geolocation.getCurrentPosition(function (position) {
                var coords = position.coords;
                setCookie("posicion", coords.latitude + "/" + coords.longitude, 150);
            });
            var opciones = document.getElementsByName("regalo");
            var carrito = "";
            for (var i = 0; i < opciones.length; i++) {
                if (opciones[i].checked) {
                    carrito += "1";
                } else {
                    carrito += "0";
                }
            }
            localStorage.setItem("carrito", carrito);
        }, "3000");

        cargarDatos();
    }
});

function cargarDatos() {
    if (getCookie("fecha") === "" && getCookie("location") === "") {
        document.getElementsByTagName("p")[2].style.display = "block";
    } else {
        var fecha = getCookie('fecha');
        var x = getCookie("posicion");
        var posicion = x.split("/");
        document.getElementById("fecha").innerHTML = "Fecha: " + fecha;
        document.getElementById("location").innerHTML = "Latitud: " + posicion[0] + " - Longitud: " + posicion[1];
        var carrito = localStorage.getItem("carrito");
        var inputs = document.getElementsByName("regalo");
        for (var i = 0; i < inputs.length; i++) {
            if (carrito.charAt(i) === "1") {
                inputs[i].checked = true;
            } else {
                inputs[i].checked = false;
            }
        }
    }
}

function mandarDatos() {
    var opciones = document.getElementsByName("regalo");
    var contador = 0;
    for (var i = 0; i < opciones.length; i++) {
        if (opciones[i].checked) {
            contador++;
        }
    }
    if (contador >= 2) {
        document.getElementById("carga").style.display = "block";
        //Hacer ajax
        $.ajax({
           url: 'algo.php',
           data: {latitude: "x", longitude: "x"},
           type: 'POST',
            dataType: 'json',
            success: function(resultado){
                document.getElementById("datos").innerHTML = resultado;
            },
            error: function(xhr, status){
                
            },
            complete: function(xhr, status){
                document.getElementById("carga").style.display = "none";
            }
        });
    } else {
        document.getElementById("error").style.display = "block";
        setTimeout(function () {
            document.getElementById("error").style.display = "none";
        }, "5000");
    }
}

function setCookie(cname, cvalue, exdays = 1) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    //Segundos
    //d.setTime(d.getTime() + (exdays  * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var claveYvalor = ca[i].split("=");
        while (claveYvalor[0].charAt(0) === ' ') {
            claveYvalor[0] = claveYvalor[0].substring(1);
        }
        if (claveYvalor[0] === cname) {
            return claveYvalor[1];
        }
    }
    return "";
}

function crearEstructura() {
    //document.body.innerHTML = "";
    var form = document.createElement("form");
    var idForm = document.createAttribute("id");
    idForm.value = "formulario";
    form.setAttributeNode(idForm);
    var input = document.createElement("input");
    input.setAttribute("type", "button");
    input.setAttribute("value", "Botón");
    form.appendChild(input);
    document.body.appendChild(form);

    var div = document.createElement("div");
    var p = document.createElement("p");
    var txt = document.createTextNode("Este es el texto del párrafo");
    p.appendChild(txt);
    div.appendChild(p);
    document.body.appendChild(div);
}