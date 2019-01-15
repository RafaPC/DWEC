'use strict';
window.onload = function(){
    var texto = 'loquesea';
    var obj_texto = document.createTextNode(texto);
    var obj_p = document.createElement('p');
    obj_p.appendChild(obj_texto);
    document.body.appendChild(obj_p);
//    alert(document.getElementById('prueba').appendChild);
//    alert(document.body.appendChild());
    
}; 