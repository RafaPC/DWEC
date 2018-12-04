'use strict';

var arrayFormulario = [];

function rellenarForm() {

    document.forms[0].elements['cajaTexto'].value = getCookie("cajaTexto");
    document.forms[0].elements['radio1'].checked = getCookie("radio1");
    document.forms[0].elements['radio2'].checked = getCookie("radio2");
    document.forms[0].elements['radio3'].checked = getCookie("radio3");
    document.forms[0].elements['radio4'].checked = getCookie("radio4");
}

function validar() {

    setCookie("cajaTexto", document.forms[0].elements['cajaTexto'].value, 3);
    var radios = "";
    
    setCookie("radio1", document.forms[0].elements['radio1'].checked, 3);
    setCookie("radio1", document.forms[0].elements['radio1'].checked, 3);
    setCookie("radio2", document.forms[0].elements['radio2'].checked, 3);
    setCookie("radio3", document.forms[0].elements['radio3'].checked, 3);
    setCookie("radio4", document.forms[0].elements['radio4'].checked, 3);

}