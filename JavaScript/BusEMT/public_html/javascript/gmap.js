/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var lines = [];
var stops = [];
var markers = [];
var infos = [];
var idStop;
var idBus;
var polyLine = null;
var markerBus = null;
var intervalBus = null;
var selectedMarker = -1;
var selectedLine;
var loadInterval;

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
    if ($.isNumeric('N74')) {
        alert('pues entra');
    }
}

function loadList(listLines) {
    lines = listLines;
    for (i = 0; i < listLines.length; i++) {
        $("#myDropdown").html($("#myDropdown").html() + "<div id=\"" + lines[i].line + "\" class=\"linea\">" + "Línea " + lines[i].label + "<br>" + lines[i].nameA + " - " + lines[i].nameB + "</div>");
    }
}

function loadStops(stopsLine) {
    document.getElementById("dropdown-llegadas").style.display = "none";
    stops = stopsLine;
    var polyCoords = [];
    for (var i = 0; i < stopsLine.length; i++) {

        var stop = stopsLine[i];

        // Meto las coordenadas en array          
        polyCoords.push({lat: stop.latitude, lng: stop.longitude});

        var marker = new google.maps.Marker({
            position: {lat: stop.latitude, lng: stop.longitude},
            map: map,
            title: stop.stopId
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
            //Mantiene el infowindow si está seleccionado
            if (marker.getIcon() !== "resources/blue-icon.png") {
                infoWindow.close(map, marker);
            }
        });

        marker.addListener('click', function (event) {
            //Se donde ha clickado y se donde está cada marker
            var i, found;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            if (selectedMarker !== -1) {
                markers[selectedMarker].setIcon("");
                infos[selectedMarker].close();
            }
            i--;
            selectedMarker = i;
            document.getElementById("dropdown-llegadas").style.display = "inline-block";
            document.getElementById("btn-llegadas").innerHTML = "Llegadas " + stopsLine[selectedMarker].name;

            markers[selectedMarker].setIcon("resources/blue-icon.png");
            idStop = stopsLine[selectedMarker].stopId;
        });
        stopLoading();
    }


    // Opciones del polyline
    polyLine = new google.maps.Polyline({
        path: polyCoords,
        strokeColor: '#FF0000',
        strokeWieght: 5
    });

    polyLine.setMap(map);
}

function loadArrives(arrives) {
    var llegada;
    $("#llegadas").html("");
    if (arrives === undefined) {
        $("#llegadas").html("<div>No hay ningún bus disponible</div>");
    } else {
        for (var i = 0; i < arrives.length; i++) {
            //buses[arrives[i].busId] = arrives[i];
            var arrive = arrives[i];
            if (arrive.busTimeLeft === 999999) {
                llegada = ' +20 minutos';
            } else if (arrive.busTimeLeft === 0) {
                llegada = ' en parada';
            } else {
                var minutos = Math.round(arrive.busTimeLeft / 60);
                llegada = ' ' + minutos + ' min';
            }
            var nameA, nameB, idArrive;

            if ($.isNumeric(arrive.lineId)) {
                idArrive = parseInt(arrive.lineId);
            } else {
                var length = arrive.lineId.length;

                if (length === 1) {
                    idArrive = "00" + arrive.lineId;
                }
                if (length === 2) {
                    idArrive = "0" + arrive.lineId;
                } else {
                    idArrive = arrive.lineId;
                }
            }

            var found = false;
            for (var j = 0; j < lines.length && !found; j++) {
//                var singleDigitId = arrive.lineId;
//                var arriveLineId = arrive.lineId;
//                if ($.isNumeric(singleDigitId)) {
//                    arriveLineId = "";
//                    var length = singleDigitId.length;
//
//                    if (length === 1)
//                    {
//                        arriveLineId = "00" + singleDigitId;
//                    }
//                    if (length === 2)
//                    {
//                        arriveLineId = "0" + singleDigitId;
//                    }
//                    if (lines[i].line == arriveLineId) {
//                        nameA = lines[i].nameA;
//                        nameB = lines[i].nameB;
//                    }
//
//                } else {
//                    if (lines[i].label === arriveLineId) {
//                        nameA = lines[i].nameA;
//                        nameB = lines[i].nameB;
//                    }
//                }
                if (idArrive === parseInt(lines[j].line || lines[i].label === idArrive)) {
                    nameA = lines[j].nameA;
                    nameB = lines[j].nameB;
                    found = true;
                    nameA = nameA[0] + nameA.substr(1).toLowerCase();
                    nameB = nameB[0] + nameB.substr(1).toLowerCase();
                    $("#llegadas").html($("#llegadas").html() + "<div id=\"" + arrive.busId + "\" class=\"llegada\">" + "Bus " + arrive.busId + "<br>Línea " + nameA + " - " + nameB + "<br>Tiempo: " + llegada + "</div>");
                }

//                if (parseInt(lines[i].line) === idArrive || lines[i].label === idArrive){
//                    nameA = lines[i].nameA;
//                    nameB = lines[i].nameB;
//                }
            }
        }
    }
    stopLoading();
}

$(document).on("click", "#btn-llegadas", function () {
    setLoading();
    getArrivesStop(idStop);
});

$(document).on("click", ".linea", function () {
    setLoading();
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    selectedLine = clickedBtnID;
    clearMarkers();
    getStopsLine(clickedBtnID);
});

$(document).on("click", ".llegada", function () {
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    idBus = clickedBtnID;
    getArriveStop(idStop, idBus);
    intervalBus = setInterval(function () {
        getArriveStop(idStop, idBus);
    }, 4000);
});

function ponerBus(arrive) {
    //If there is already a bus marker it's deleted by just setting it's map to null
    if (markerBus !== null) {
        markerBus.setMap(null);
    }
    markerBus = new google.maps.Marker({
        position: {lat: arrive.latitude, lng: arrive.longitude},
        map: map,
        icon: 'resources/front-bus.png'
    });
}

function clearMarkers() {
    if (intervalBus !== null) {
        clearInterval(intervalBus);
    }
    if (markerBus !== null) {
        markerBus.setMap(null);
    }
    if (polyLine !== null) {
        polyLine.setMap(null);
    }
    if (markers.length !== 0) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
    }
}

function setLoading() {
    $("#loading-msg").css('display', 'block');
    loadInterval = window.setInterval(function () {
        $("#loading-msg").html('Loading.');
        window.setTimeout(function () {
            $("#loading-msg").html('Loading..');
        }, 500);
        window.setTimeout(function () {
            $("#loading-msg").html('Loading...');
        }, 800);
    }, 1300);
    $("#loading-msg").html('Loading.');
    window.setTimeout(function () {
        $("#loading-msg").html('Loading..');
    }, 500);
    window.setTimeout(function () {
        $("#loading-msg").html('Loading...');
    }, 800);

}

function stopLoading() {
    clearInterval(loadInterval);
    $("#loading-msg").css('display', 'none');
}

//function addMarker(props) {
//    var marker = new google.maps.Marker({
//        position: props.coords,
//        map: map
//    });
//
//    if (props.iconImage) {
//        marker.setIcon(props.iconImage);
//    }
//}
