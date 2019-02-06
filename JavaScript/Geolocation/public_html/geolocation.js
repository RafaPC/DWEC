'use strict';
window.onload = function(){
  
    navigator.geolocation.getCurrentPosition(guay,noguay);
};

function guay(position){
    for(var x in position.coords){
        alert(x + " - " + position.coords[x]);
    }
}
function noguay(location){
    
}

function loadMap() {
  var mapOptions = {
    center: new google.maps.LatLng(22.719840899999998, 75.8824308),
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById("sample"), mapOptions);
  console.log(map);
}
