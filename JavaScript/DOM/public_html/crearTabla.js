'use strict';
window.onload = function () {
    var filas = parseInt(prompt("Número de filas", 0));
    var columnas = parseInt(prompt("Número de columnas", 0));
    var table = document.createElement("table");

    document.body.appendChild(table);

    for (var i = 0; i < filas; i++) {
        var tr = document.createElement("tr");
        if (i === 0) {
            var thead = table.appendChild(document.createElement("thead"));
            table.appendChild(thead);
            thead.appendChild(tr);
        } else if(i === 1){
            var tbody = table.appendChild(document.createElement("tbody"));
            table.appendChild(tbody);
            tbody.appendChild(tr);
        }else{
            table.appendChild(tr);
        }
        for (var j = 0; j < columnas; j++) {
            var td = document.createElement("td");
            if (i === 0) {
                td = document.createElement("th");
            }

            var txt = document.createTextNode(prompt("Texto a introducir en la celdilla", ""));
            td.appendChild(txt);
            tr.appendChild(td);
        }
    }
};