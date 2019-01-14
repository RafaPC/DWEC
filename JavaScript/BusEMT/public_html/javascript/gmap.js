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
var selectedMarker;
var selectedLine;
var loadInterval;

// Sets the map options and creates the map
function initMap() {
    // Map Options
    var options = {
        zoom: 14,
        center: {lat: 40.4167, lng: -3.70325}
    };

    // New map
    map = new google.maps.Map(document.getElementById('map'), options);
}

// Receives a list of lines and loads them into the lines's dropdown
function loadLines(listLines) {
    lines = listLines;
    for (i = 0; i < listLines.length; i++) {
        $("#lines").html($("#lines").html() + "<div id=\"" + lines[i].line + "\" class=\"line\">" + "<strong>Line " + lines[i].label + "</strong><br>" + lines[i].nameA + " - " + lines[i].nameB + "</div>");
    }
}

// Receives a list of stops and creates a marker with name and coords for each of the stops
// Creates 3 listeners for each marker
function loadStops(stopsLine) {
    document.getElementById("dropdown-arrivals").style.display = "none";
    stops = stopsLine;
    var polyCoords = [];
    for (var i = 0; i < stopsLine.length; i++) {

        var stop = stopsLine[i];

        // Put latlongs into the array         
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
            //I know where it has been clicked and where is each marker so i can track which marker was clicked
            var i;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            i--;               
            var marker = markers[i];
            var infoWindow = infos[i];
            infoWindow.open(map, marker);
        });

        // Creates a listener that will remove the infoWindow created by the previous listener when taking out the mouse from the marker
        marker.addListener('mouseout', function (event) {
            //I know where it has been clicked and where is each marker so i can track which marker was clicked
            var i;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            i--;
            var marker = markers[i];
            var infoWindow = infos[i];
            //Keeps the infowindow open if it's marker has been selected
            if (marker.getIcon() !== "resources/blue-icon.png") {
                infoWindow.close(map, marker);
            }
        });

        // Creates a listener that will display an infoWindow with the stop name that won't be deleted by the previous listener
        // It also calls make the arrivals button dropdown appears with the name of the clicked stop
        // Changes the color of the marker to blue
        marker.addListener('click', function (event) {
            //I know where it has been clicked and where is each marker so i can track which marker was clicked
            var i, found;
            for (i = 0, found = false; i < markers.length && found === false; i++) {
                if (event.latLng === markers[i].position) {
                    found = true;
                }
            }
            if (selectedMarker !== undefined) {
                markers[selectedMarker].setIcon("");
                infos[selectedMarker].close();
            }
            i--;
            selectedMarker = i;
            document.getElementById("dropdown-arrivals").style.display = "inline-block";
            document.getElementById("btn-arrivals").innerHTML = "Arrivals " + stopsLine[selectedMarker].name;

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

// Receives a list of arrivals and loads them into the arrivals dropdown with information 
// about the estimated time of arrival, bus id, line id and destination
function loadArrivals(arrivals) {
    var timeLeft;
    $("#arrivals").html("");
    if (arrivals === undefined) {
        $("#arrivals").html("<div>The are no buses availables</div>");
    } else {
        for (var i = 0; i < arrivals.length; i++) {
            var arrival = arrivals[i];
            if (arrival.busTimeLeft === 999999) {
                timeLeft = ' +20 minutos';
            } else if (arrival.busTimeLeft === 0) {
                timeLeft = ' on stop';
            } else {
                var minutos = Math.round(arrival.busTimeLeft / 60);
                timeLeft = ' ' + minutos + ' min';
            }
            var nameA, nameB, idArrival;

            idArrival = arrival.lineId;

            var found = false;
            for (var j = 0; j < lines.length && !found; j++) {
                if (parseInt(idArrival) === parseInt(lines[j].line) || lines[j].label === idArrival) {
                    found = true;
                    nameA = formatText(lines[j].nameA);
                    nameB = formatText(lines[j].nameB);
                    destination = formatText(arrival.destination);
                    $("#arrivals").html($("#arrivals").html() + "<div id=\"" + arrival.busId + "\" class=\"llegada\">" + "<strong>Bus " + arrival.busId + "</strong><br><strong>Line:</strong> " + nameA + " - " + nameB + "<br><strong>Towards:</strong> " + destination + "<br><strong>Time:</strong> " + timeLeft + "</div>");
                }
            }
        }
    }
    stopLoading();
}


// When clicking on one of the listed lines, it calls 'getStopsLine' with the id of the clicked line as parameter
$(document).on("click", ".line", function () {
    setLoading();
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    selectedLine = clickedBtnID;
    clearMarkers();
    getStopsLine(clickedBtnID);
    if (intervalBus !== null) {
        clearInterval(intervalBus);
    }
});

// When clicking on the dropdown button of the arrivals list, it calls 'getArrivalsFromStop' and loads them into #arrivals
$(document).on("click", "#btn-arrivals", function () {
    setLoading();
    getArrivalsFromStop(idStop);
});

// When clicking on one of the listed arrivals, it calls 'getArrivalFromStop' with the id of the clicked arrival as parameter
// It also sets an interval to call that function every 4 seconds
$(document).on("click", ".llegada", function () {
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    idBus = clickedBtnID;
    getArrivalFromStop(idStop, idBus);
    intervalBus = setInterval(function () {
        getArrivalFromStop(idStop, idBus);
    }, 4000);
});

// When called, this function takes the arrival parameter and creates a marker with its coordinates
function putBusMarker(arrival) {
    //If there is already a bus marker it is deleted by just setting it's map to null
    if (markerBus !== null) {
        markerBus.setMap(null);
    }
    markerBus = new google.maps.Marker({
        position: {lat: arrival.latitude, lng: arrival.longitude},
        map: map,
        icon: 'resources/front-bus.png'
    });
    map.setCenter(markerBus.getPosition());
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