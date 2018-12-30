/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//window.onload = initMap();
//
//function initMap() {
//    // Map Options
//    var options = {
//        zoom: 15,
//        center: {lat: 40.4167, lng: -3.70325}
//    };
//    // New map
//    var map = new google.maps.Map(document.getElementById('map'), options);
//
//    //Marcadores
//    var marker = new google.maps.Marker({
//        position: {lat: 40.41349419, lng: -3.68133283},
//        map: map,
//        icon: "resources/front-bus.png"
//    });
//}


function loadList(listLines) {
    for (i = 0; i < listLines.length; i++) {
        $("#myDropdown").html($("#myDropdown").html() + "<div id=\"" + listLines[i].line + "\" class=\"linea\">" + "Línea " + listLines[i].label + " " + listLines[i].nameA + " - " + listLines[i].nameB + "</div>");
    }
}




/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};

$(document).on("click", ".linea", function () {
    var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
    getStopsLine(clickedBtnID);
});
