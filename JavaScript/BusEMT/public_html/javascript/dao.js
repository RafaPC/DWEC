/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = getListLines();

var busLatitude = null;
var busLongitude = null;

function getListLines() {
    var date = new Date();
    var actualDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();

    $.ajax({
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php',

        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            SelectDate: actualDate
        },

        type: 'POST',

        dataType: 'json',

        success: function (result) {
            loadLines(result.resultValues);
        },

        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },

        complete: function (xhr, status) {
        }
    });
}

function getStopsLine(line) {

    $.ajax({
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetStopsLine.php',

        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            line: line
        },

        type: 'POST',

        dataType: 'json',

        success: function (result) {
            stopsLine = result.stop;
            loadStops(stopsLine);
        },

        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },

        complete: function (xhr, status) {
        }
    });
}

function getArrivalsFromStop(idStop) {
    $.ajax({
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php',

        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            idStop: idStop
        },

        type: 'POST',

        dataType: 'json',

        success: function (result) {
            arrivals = result.arrives;
            loadArrivals(arrivals);
        },

        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },

        complete: function (xhr, status) {
        }
    });
}

function getArrivalFromStop(idStop, idBus) {
    $.ajax({
        url: 'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php',

        data: {idClient: 'WEB.SERV.rafitap.c@hotmail.com',
            passKey: '84802663-D65C-4C6B-8372-0E8206AB6808',
            idStop: idStop
        },

        type: 'POST',

        dataType: 'json',

        success: function (result) {
            arrivals = result.arrives;
            var found = false;
            var i;
            for (i = 0; i < arrivals.length && !found; i++) {
                if (arrivals[i].busId === idBus) {
                    found = true;
                }
            }
            i--;

            // Only calls 'putBusMarker' if the bus has changed the position from the last time it was called
            if (!(busLatitude === arrivals[i].latitude && busLongitude === arrivals[i].longitude)) {
                busLatitude = arrivals[i].latitude;
                busLongitude = arrivals[i].longitude;
                putBusMarker(arrivals[i]);
            }
        },

        error: function (xhr, status) {
            alert('Disculpe, existia un problema');
        },

        complete: function (xhr, status) {
        }
    });
}

