<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function test_email($email){
$patron = "/^[a-zA-Z0-9]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,3}$/" ;
if ( preg_match($patron , $email)) {
return true;
}
return false;
}

function test_fijoMadrid($telefono){
$patron = "/^91\d{7}$/" ;
if (preg_match($patron , $telefono)) {
return true;
}
return false;
}

function test_ip($ip){
$patron = "/^\(d{3}.){3}$/" ;
if (preg_match($patron , $ip)) {
return true;
}
return false;
}

function test_codigo($codigo){
$patron = "/^[A-Z]{3}-\d{3,5}$/";
if (preg_match($patron , $codigo)) {
return true;
}
return false;
}

function test_password($password){
$patron = "/^([a-zA-Z0-9]?)*$/";
if (preg_match($patron , $password)) {
return true;
}
return false;
}
//---------------- Se examina la validez de algunos correos
//
$correos = array( 'luis@ab.com' , 'luis.garcia@ab.jz.es' , 'luis.@ab.com' , 'x@ab.jz..es');
$telefonos = array('916080978', '686080978');
$ips = array();
$codigo = array('ZAZ-4567', 'POV-333', 'LOL-99956', 'RAR-32');
$passwords = array('contrasenA1');
for ($i=0;$i<count($correos);$i++) {
	if (test_email($correos[$i])) echo " el email $correos[$i] es correcto <br>";
	else echo " el email $correos[$i] es erroneo <br>";
}

for ($i=0;$i<count($telefonos);$i++) {
	if (test_fijoMadrid($telefonos[$i])) echo " el telefono $telefonos[$i] es correcto <br>";
	else echo " el telefono $telefonos[$i] es erroneo <br>";
}

for ($i=0;$i<count($codigo);$i++) {
	if (test_codigo($codigo[$i])) echo " el codigo $codigo[$i] es correcto <br>";
	else echo " el codigo $codigo[$i] es erroneo <br>";
}

for ($i=0;$i<count($passwords);$i++) {
	if (test_codigo($passwords[$i])) echo " la contraseña $passwords[$i] es correcta <br>";
	else echo " la contraseña $passwords[$i] es erronea <br>";
}


?>