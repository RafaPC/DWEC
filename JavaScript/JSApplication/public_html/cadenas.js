'use strict';

var cadena = "";
cadena = prompt("Introduce cadena: ",0);
var expreg = new RegExp(/^91[0-9]{7}$/g);
///var expreg = new RegExp("^91[0-9]{7}$","g");
if(expreg.test(cadena)){
    alert("Ha funcionado");
    document.write("Ha funcionado");
}


/*var cadena = "";
cadena = prompt("Introduce cadena: ","");
for(var i = 0; i<cadena.length;i++){
    document.write(cadena.substr(i,1) + "<br>");
}*/