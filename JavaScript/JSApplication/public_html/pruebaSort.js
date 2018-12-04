'use strict';

var arrayFechas = [new Date(1999,11,17), new Date(1989,9,27), new Date(2002,6,24), new Date(1800,10,10)];
arrayFechas.sort(function(a,b){
    return b.getTime() - a.getTime();
});

alert(new Date().getFullYear() - arrayFechas[0].getFullYear());
alert(new Date().getFullYear()  - arrayFechas[1].getFullYear());
alert(new Date().getFullYear()  - arrayFechas[2].getFullYear());
alert(new Date().getFullYear()  - arrayFechas[3].getFullYear());