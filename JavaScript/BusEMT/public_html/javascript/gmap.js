/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var map;
var markers = [];
var infos = [];

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

    var marker1 = new google.maps.Marker({
        position: {lat: 40.4040200, lng: -3.6882300},
        map: map
                //icon: "resources/front-bus.png"
    });


    var infoWindow = new google.maps.InfoWindow({
        content: "retiro"
    });

    marker.addListener('click', function () {
        infoWindow.open(map, marker);
    });

    var infoWindow1 = new google.maps.InfoWindow({
        content: "atocha"
    });

    marker1.addListener('click', function () {
        infoWindow1.open(map, marker1);
    });

}

function loadStops(stopsLine) {
    var polyCoords = [];

    for (var i = 0; i < stopsLine.length; i++) {

        var stop = stopsLine[i];

        // Meto las coordenadas en array          
        polyCoords.push({lat: stop.latitude, lng: stop.longitude});

        var marker = new google.maps.Marker({
            position: {lat: stop.latitude, lng: stop.longitude},
            map: map,
            title: i
        });
        var infoWindow = new google.maps.InfoWindow({
            content: stop.name
        });

        markers[i] = marker;
        infos[i] = infoWindow;

        marker.addListener('click', function (event) {
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


function loadArrives(arrives){
    var llegada;
    $("#llegadas").html("");
    for (i = 0; i < arrives.length; i++) {
        var arrive = arrives[i];
        if(arrive.busTimeLeft === 999999){
            llegada = ' +20 minutos';
        }else if(arrive.busTimeLeft === 0){
            llegada = ' en parada';
        }else{
            var minutos = Math.round(arrive.busTimeLeft/60);
            llegada = ' ' + minutos + ' min';
        }
        $("#llegadas").html($("#llegadas").html() + "<div id=\"" + arrive.busId + "\" class=\"llegada\">" + "Bus " + arrive.busId + " - Línea" + arrive.lineId + " Tiempo: " + llegada + "</div>");
    }
}
/*function addMarker(props) {
 var marker = new google.maps.Marker({
 position: props.coords,
 map: map
 });
 
 if (props.iconImage) {
 marker.setIcon(props.iconImage);
 }
 }*/
