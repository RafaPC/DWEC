'use strict';


//Número fijo de madrid
/*var cadena = "";
cadena = prompt("Introduce cadena: ",0);
var expreg = new RegExp(/^91[0-9]{7}$/g);
///var expreg = new RegExp("^91[0-9]{7}$","g");
if(expreg.test(cadena)){
    alert("Ha funcionado");
    document.write("Ha funcionado");
}*/

//DNI
//var cadena = "";
//var arrayCaracteres = ["T","R","W","A","G","M","Y","F","P","D","X","B","N","J","Z","S","Q","V","H","L","C","K","E"];
//cadena = prompt("Introduce cadena: ",0);
//var expregDni = new RegExp(/^\d{8}[A-Z]$/g);
/////var expreg = new RegExp("^91[0-9]{7}$","g");
//if(expreg.test(cadena)){
//    alert("Ha pasado la expresión regular");
//    
//    //Saco los numeros del dni
//    var numeros = cadena.substr(0,8);
//    //Calculo el resto para saber la posicion del array
//    var resto = numeros % 23;
//    //Saco la letra del dni
//    var letra = cadena.substr(8,1);
//    
//    //Comparo la letra del dni con la del array de carácteres
//    if(letra===arrayCaracteres[resto]){
//        alert("Cooooooorrectísimo");
//    }
//}else{
//    alert("No ha funcionado");
//}


//var expregDni = new RegExp(/\d{8}[A-Z]/g);
//var texto = "Mi dni es 67548768G mientras que el de mi hermano es 76865387T";
//var arrayDnis = texto.match(/\d{8}[A-Z]/g);
//texto.replace(expregDni,'DNI');
//document.write(texto);


alert(Math.floor(Math.random() * (25 - 7 + 1) + 7));




//Email
//var cadena = "";
//cadena = prompt("Introduce cadena: ",0);
//var expreg = new RegExp(/^(\w+\.){1,3}\w{1,15}@(\w{1-20}\.){1,2}\w{2,4}$/g);
//if(expreg.test(cadena)){
//    alert("Ha funcionado");
//    document.write("Ha funcionado");
//}

//{1-3}(@)\W(1-20)[1-2]$/g








/*var cadena = "";
cadena = prompt("Introduce cadena: ","");
for(var i = 0; i<cadena.length;i++){
    document.write(cadena.substr(i,1) + "<br>");
}*/