'use strict';
var myWindow;
for(var cosa in location){
    document.write(cosa + location[cosa] + "\n\
");
}
location.href = 'https://www.google.es'; 
function abrirVentana() {
    myWindow = window.open("", "MsgWindow", "width=200,height=100");
    myWindow.document.write("<head><script src=\"window.js\" type=\"text/javascript\"></script></head><body><input type=\"button\" value=\"Cerrar hija\" onclick=\"cerrarVentana();\">\n\</body>");
}
function cerrarHija(){
    myWindow.close();
}

function cerrarVentana(){
    var myWindow = window;
    myWindow.close();
}
function aumentarTamaño(){
    myWindow.resizeTo(myWindow.innerWidth + 100,myWindow.innerHeight + 100);
    myWindow.document.write("Width: " + myWindow.innerWidth + "Height: " + myWindow.innerHeight);
    myWindow.focus();
}