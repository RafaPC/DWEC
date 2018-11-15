'use strict';

document.write("<input type=\"button\" value=\"daigual\" onclick=\"cambiarImagen();\"/>");
document.write("<img name=\"foto1\" alt=\"\" height=\"100\" width=\"100\" src=\"resources/kikazo2.png\"/>");
document.write("<img name=\"foto2\" alt=\"\" height=\"100\" width=\"100\" src=\"resources/fondeje.png\"/>");

function cambiarImagen(){
    var src1 = document.images['foto1'].src;
    var src2 = document.images['foto2'].src;
    document.images['foto1'].src = src2;
    document.images['foto2'].src = src1;
    
}
for (var clave in document.images[0]){
       document.write(clave + ".- " + document.images[0][clave]);
    }
    