/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

document.addEventListener("readystatechange", function () {
    if (document.readyState === "complete") {
        var tamaño = getCookie("tamaño");
        if (tamaño !== "") {
            tamaño += "px";
            document.getElementsByTagName("img")[0].style.height = tamaño;
            document.getElementsByTagName("img")[0].style.width = tamaño;
        } else {
            document.getElementsByTagName("img")[0].style.height = "100px";
            document.getElementsByTagName("img")[0].style.width = "100px";
        }
        intervalo();
    }
});

function intervalo() {
    var botones = document.getElementsByName("tamaño");
    var tamaño = parseInt(document.getElementsByTagName("img")[0].style.width);
    if (botones[0].checked) {
        tamaño *= 2;
    } else if (botones[1].checked) {
        tamaño /= 2;
    }
    setCookie("tamaño", tamaño, 1);
    tamaño += "px";
    document.getElementsByTagName("img")[0].style.height = tamaño;
    document.getElementsByTagName("img")[0].style.width = tamaño;
    //Hacer random el tiempo
    var tiempo = "3000";
    setTimeout(intervalo, tiempo);
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