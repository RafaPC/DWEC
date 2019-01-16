'use strict';
window.onload = function(){
    /*var texto = 'loquesea';
    var obj_texto = document.createTextNode(texto);
    var obj_p = document.createElement('p');
    obj_p.appendChild(obj_texto);
    document.body.appendChild(obj_p);
    alert(document.getElementById('prueba').appendChild);
    alert(document.body.appendChild());*/
    
    var img = document.createElement('img');
    var src = document.createAttribute("src");
    src.value = "cepeda.JPG";
    img.setAttributeNode(src);
    document.body.appendChild(img);
};

function crearParrafo(){
    
}

function borrarParrafo(){
    
}