 /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = getListLines();
var lines = [];
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
            SelectDate: fechaActual
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            lines = resultado['resultValues'];
            loadList(lines);
        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            return null;
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
        }
    });
}

function getLineInfo(line) {
    var fecha = new Date();
    var fechaActual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/' + fecha.getFullYear();
    var listLines;

    $.ajax({
        // la URL para la peticion
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            SelectDate: fechaActual,
            Lines: line
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            alert('Success');
            listLines = resultado['resultValues'];

            for (i = 0; i < listLines.length; i++) {
                $("#selectLine").html($("#selectLine").html() + "<option value=\"" + listLines[i].label + "\">" + listLines[i].nameA + "</option>");
            }

        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            listLines = null;
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
            alert('Peticion realizada');
        }
    });

    return listLines;
}

//function getLineInfo(line){
//    for(var i = 0; i < line.length; i++){
//        if(){
//            
//        }
//    }
//}
function getStopsLine(line) {

    $.ajax({
        // la URL para la peticion
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetStopsLine.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            line: line
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            stopsLine = resultado.stop;
            loadStops(stopsLine);
        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            listLines = null;
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
        }
    });

    return listLines;
}

function getArrivesStop(idStop) {

    $.ajax({
        // la URL para la peticion
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            idStop: idStop
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            arrives = resultado.arrives;
            loadArrives(arrives);
        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            listLines = null;
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
        }
    });

    return arrives;
}
function getArriveStop(idStop, idBus) {
    $.ajax({
        // la URL para la peticion
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php',

        // la informacion a enviar
        // (tambien es posible utilizar una cadena de datos)
        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            idStop: idStop
        },

        // especifica si sera una peticion POST o GET
        type: 'POST',

        // el tipo de informaciÃ³n que se espera de respuesta
        dataType: 'json',

        // codigo a ejecutar si la peticion es satisfactoria;
        // la respuesta es pasada como argumento a la funcion
        success: function (resultado) {
            arrives = resultado.arrives;
            var encontrado = false;
            var i;
            for (i = 0; i < arrives.length && encontrado === false; i++){
                if(arrives[i].busId === idBus){
                    encontrado = true;
                }
            }
            ponerBus(arrives[i]);        
        },

        // codigo a ejecutar si la peticion falla;
        // son pasados como argumentos a la funciÃ³n
        // el objeto de la peticion en crudo y codigo de estatus de la peticion
        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
            listLines = null;
        },

        // codigo a ejecutar sin importar si la peticion falla o no
        complete: function (xhr, status) {
        }
    });

    return arrives;
}

