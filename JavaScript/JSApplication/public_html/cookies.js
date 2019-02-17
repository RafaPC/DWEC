'use strict';

//document.addEventListener("readyStateChange",function(){
//   if(document.readyState === 'loaded'){
//       //Aqui se ponen cosas
//   } 
//});

document.onreadystatechange = function(){
  alert('ha cambiado el estado');
    if(document.readyState === 'complete'){
      alert('cargado');
  }  
};

function setCookie() {
    var cname = prompt("Nombre cookie");
    var cvalue = prompt("Valor cookie");
    var exdays = prompt("Duración en días");
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    //Segundos
    //d.setTime(d.getTime() + (exdays  * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie() {
    var cname = prompt("Nombre cookie","");
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            alert(c.substring(name.length));
        }
    }
    return "";
}

function deleteCookie() {
    var cname = prompt("Nombre cookie");
    var d = new Date();
    d.setTime(d.getTime() - 1);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";
}



//var contador = getCookie("contador");
//
//if (contador === "") {
//    contador = 1;
//} else {
//    contador++;
//}
//setCookie("contador", contador, 5);
//document.title = "Contador " + contador;