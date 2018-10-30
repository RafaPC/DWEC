'use strict';
var myWindow;
function abrirVentana() {
    myWindow = window.open("", "MsgWindow", "width=200,height=100");
    myWindow.document.write("<head><script src=\"window.js\" type=\"text/javascript\"></script></head><body><input type=\"button\" value=\"Cerrar hija\" onclick=\"cerrarHija();\">\n\</body>");
}
function cerrarHija(){
    myWindow.close();
}

function cerrarVentana(){
    var myWindow = window;
    myWindow.close();
}
