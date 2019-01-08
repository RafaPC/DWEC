/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var map;
var markers = [];
var infos = [];
var buses = [];
var idStop;
var idBus;
var markerBus = null;

function initMap() {
    // Map Options
    var options = {
        zoom: 15,
        center: {lat: 40.4167, lng: -3.70325}
    };

    // New map
    map = new google.maps.Map(document.getElementById('map'), options);

    // Listen for click on map
    google.maps.event.addListener(map, 'click', function (event) {
        addMarker({coords: event.latLng});
    });

    //Marcador
    var marker = new google.maps.Marker({
        position: {lat: 40.41349419, lng: -3.68133283},
        map: map
                //icon: "resources/front-bus.png"
    });

    var infoWindow = new google.maps.InfoWindow({
        content: "retiro"
    });

    marker.addListener('click', function () {
        infoWindow.open(map, marker);
    });


}

function loadStops(stopsLine) {
    var polyCoords = [];
    buses = stopsLine;
    for (var i = 0; i < stopsLine.length; i++) {

        var stop = stopsLine[i];

        // Meto las coordenadas en array          
        polyCoords.push({lat: stop.latitude, lng: stop.longitude});

        var marker = new google.maps.Marker({
            position: {lat: stop.latitude, lng: stop.longitude},
            map: map
        });
        var infoWindow = new google.maps.InfoWindow({
            content: stop.name
        });

        markers[i] = marker;
        infos[i] = infoWindow;

        if (i === 0 || i === stopsLine.length - 1) {
            infoWindow.open(map, marker);
        }

        marker.addListener('mouseover', function (event) {
            //Se donde ha clickado y se donde está cada marker
            var i;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            i--;
            //El for suma una ultima vez i antes de salir porque no cumple el condicional                
            var marker = markers[i];
            var infoWindow = infos[i];
            infoWindow.open(map, marker);
        });

        marker.addListener('mouseout', function (event) {
            //Se donde ha clickado y se donde está cada marker
            var i;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            i--;
            //El for suma una ultima vez i antes de salir porque no cumple el condicional                
            var marker = markers[i];
            var infoWindow = infos[i];
            //Pasa medio segundo
            infoWindow.close(map, marker);
        });

        marker.addListener('click', function (event) {
            //Se donde ha clickado y se donde está cada marker
            var i;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            i--;
            idStop = stopsLine[i].stopId;
            getArrivesStop(stopsLine[i].stopId);
        });
    }


    // Opciones del polyline
    var polyLine = new google.maps.Polyline({
        path: polyCoords,
        strokeColor: '#FF0000',
        strokeWieght: 5
    });

    polyLine.setMap(map);
}


function loadArrives(arrives) {
    var llegada;
    $("#llegadas").html("");
    for (i = 0; i < arrives.length; i++) {
        buses[arrives[i].busId] = arrives[i];
        var arrive = arrives[i];
        if (arrive.busTimeLeft === 999999) {
            llegada = ' +20 minutos';
        } else if (arrive.busTimeLeft === 0) {
            llegada = ' en parada';
        } else {
            var minutos = Math.round(arrive.busTimeLeft / 60);
            llegada = ' ' + minutos + ' min';
        }
        $("#llegadas").html($("#llegadas").html() + "<div id=\"" + arrive.busId + "\" class=\"llegada\">" + "Bus " + arrive.busId + " - Línea" + arrive.lineId + " Tiempo: " + llegada + "</div>");
    }
}


$(document).on("click", ".llegada", function () {
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    idBus = clickedBtnID;
    setInterval(getArriveStop(idStop, idBus), 6000);
    setInterval(function(){alert('va bene');}, 3000);
});

function ponerBus(arrive) {
    if (markerBus !== null) {
        map.removeMarker = markerBus;
    alert("se borra marker anterior");
    }
    alert('se pone marker');
    markerBus = new google.maps.Marker({
        position: {lat: arrive.latitude, lng: arrive.longitude},
        map: map,
        label: 'BUS'
    });

}
;
/*function addMarker(props) {
 var marker = new google.maps.Marker({
 position: props.coords,
 map: map
 });
 
 if (props.iconImage) {
 marker.setIcon(props.iconImage);
 }
 }*/
