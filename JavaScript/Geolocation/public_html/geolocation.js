'use strict';
window.onload = function () {
    var opcionesGeo = {
        timeout: 3000
    };
    navigator.geolocation.getCurrentPosition(loadMap, noguay, opcionesGeo);
};

function noguay(location) {
    alert('algo salió mal');
}

function loadMap(position) {
    alert("Cargando mapa");
    var coordenadas = position.coords;
    var options = {
        zoom: 14,
        center: {lat: coordenadas.latitude, lng: coordenadas.longitude}
    };

    var map = new google.maps.Map(document.getElementById("map"), options);

  var marker = new google.maps.Marker({
            position: {lat: coordenadas.latitude, lng: coordenadas.longitude},
            map: map,
            title: 'Insti',
            label: 'Mi posicion'
        });
}
