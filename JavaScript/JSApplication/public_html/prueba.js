'use strict';

var fecha1 = new Date(2016,2,3);
var fecha2 = new Date(2019,10,27);

var miliBetween = fecha2.getMilliseconds() - fecha1.getMilliseconds();
//alert(Math.floor(miliBetween/1000%60%60%24%365));

var milisRandom = Math.floor(Math.random() * (fecha2.getTime() - fecha1.getTime() + 1) + fecha1.getTime());
var fechaRandom = new Date(milisRandom);
alert(fecha1);
alert(fecha2);

alert(fechaRandom);
