/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = getListLines();

function loadDoc() {
    alert("entra");
    url = "https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php?idClient=WEB.SERV.rafitap.c@hotmail.com&passKey=84802663-D65C-4C6B-8372-0E8206AB6808&SelectDate=29/12/2018";
    urlxml = "https://servicios.emtmadrid.es:8443/bus/servicebus.asmx?op=GetListLines";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("prueba").innerHTML =
                    this.responseText;
        }
    };
    xhttp.open("POST", urlxml, true);
    xhttp.send();

}

function getListLines() {
    var fecha = new Date();
    var fechaActual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/' + fecha.getFullYear();

    $.ajax({
        // la URL para la peticion
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            SelectDate: fechaActual,
            //Lines: '14'
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            alert('Success');
            //$("#contenido").html(obj.dni);
            var listLines = resultado['resultValues'];
            var lineacero = listLines[0];

            for (i = 0; i < listLines.length; i++) {
                $("#selectLine").html($("#selectLine").html() + "<option value=\"" + listLines[i].label + "\">" + listLines[i].nameA + "</option>");

            }

        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            $("#contenido").html("No ha encontrado nada");
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
            alert('Peticion realizada');
            $("#imgload").css("display", "none");
        }
    });
}