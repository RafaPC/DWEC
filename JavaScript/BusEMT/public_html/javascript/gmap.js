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

// 
function initMap() {
    // Map Options
    var options = {
        zoom: 15,
        center: {lat: 40.4167, lng: -3.70325}
    };

    // New map
    map = new google.maps.Map(document.getElementById('map'), options);

    // Listens for click on map
    google.maps.event.addListener(map, 'click', function (event) {
        addMarker({coords: event.latLng});
    });
}

// Receives a list of lines and loads them into the lines's dropdown
function loadList(listLines) {
    lines = listLines;
    for (i = 0; i < listLines.length; i++) {
        $("#myDropdown").html($("#myDropdown").html() + "<div id=\"" + lines[i].line + "\" class=\"linea\">" + "Línea " + lines[i].label + "<br>" + lines[i].nameA + " - " + lines[i].nameB + "</div>");
    }
}

// Receives a list of stops and creates a marker with name and coords for each of the stops
// Creates 3 listeners for each marker
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

        // Creates a listener that displays an infoWindow with the stop name when putting the mouse over the marker
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

        // Creates a listener that will remove the infoWindow created by the previous listener when taking out the mouse from the marker
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

        // Creates a listener that will display an infoWindow with the stop name that won't be deleted by the previous listener
        // It also calls make the arrives button dropdown appears with the name of the clicked stop
        // Changes the color of the marker to blue
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


    // Creates a polyline
    polyLine = new google.maps.Polyline({
        path: polyCoords,
        strokeColor: '#FF0000',
        strokeWieght: 5
    });

    polyLine.setMap(map);
}

// Receives a list of arrives and loads them into the arrive's dropdown with information 
// about the estimated time of arrival, bus id, line id and destination
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

            idArrive = arrive.lineId;

            var found = false;
            for (var j = 0; j < lines.length && !found; j++) {
                if (parseInt(idArrive) === parseInt(lines[j].line) || lines[j].label === idArrive) {
                    found = true;
                    nameA = formatText(lines[j].nameA);
                    nameB = formatText(lines[j].nameB);
                    destination = formatText(arrive.destination);
                    $("#llegadas").html($("#llegadas").html() + "<div id=\"" + arrive.busId + "\" class=\"llegada\">" + "Bus " + arrive.busId + "<br>Line: " + nameA + " - " + nameB + "<br>Towards: " + destination + "<br>Time: " + llegada + "</div>");
                }
            }
        }
    }
    stopLoading();
}


// When clicking on one of the listed lines, it calls 'getStopsLine' with the id of the clicked line as parameter
$(document).on("click", ".linea", function () {
    setLoading();
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    selectedLine = clickedBtnID;
    clearMarkers();
    getStopsLine(clickedBtnID);
});

// When clicking on the dropdown button of the arrives list, it calls 'getArrivesFromStop' and loads them into #arrives
$(document).on("click", "#btn-llegadas", function () {
    setLoading();
    getArrivesFromStop(idStop);
});

// When clicking on one of the listed arrives, it calls 'getArriveFromStop' with the id of the clicked arrive as parameter
// It also sets an interval to call that function every 4 seconds
$(document).on("click", ".llegada", function () {
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    idBus = clickedBtnID;
    getArriveFromStop(idStop, idBus);
    intervalBus = setInterval(function () {
        getArriveFromStop(idStop, idBus);
    }, 4000);
});

// When called, this function takes the arrive parameter and creates a marker with its coordinates
function putBusMarker(arrive) {
    //If there is already a bus marker it is deleted by just setting it's map to null
    if (markerBus !== null) {
        markerBus.setMap(null);
    }
    markerBus = new google.maps.Marker({
        position: {lat: arrive.latitude, lng: arrive.longitude},
        map: map,
        icon: 'resources/front-bus.png'
    });
}

// Clears th polyLine, the bus marker bus and it's interval and the stops markers
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

// Sets an interval to create a loading animation at the left bottom of the screen 
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
// This function converts uppercase text and returns the string in lowercase with the first capital letter
function formatText(string) {
    return string[0] + string.substr(1).toLowerCase();
}

// This function stops the interval that shows the loading animation and hide the div
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
