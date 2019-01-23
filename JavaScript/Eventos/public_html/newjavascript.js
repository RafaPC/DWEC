'use strict';
window.onload = function () {
    document.getElementById("abuelo").addEventListener("click", function (event) {
        alert("abuelo");
        alert(event.currentTarget.innerHTML);
    }, false);
    document.getElementById("padre").addEventListener("click", function (event) {
        alert("padre");
        alert(event.currentTarget.innerHTML); 
    }, false);
    document.getElementById("hijo").addEventListener("click", function (event) {
        alert("hijo");
        alert(event.currentTarget.innerHTML); 
//        event.cancelBubble = true;
    }, false);
};