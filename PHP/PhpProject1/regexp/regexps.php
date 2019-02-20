<?php

function test_email($email) {
    $patron = "/^[a-zA-Z0-9]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,3}$/";
    if (preg_match($patron, $email)) {
        return true;
    }
    return false;
}

function test_fijoMadrid($telefono) {
    $patron = "/^91\d{7}$/";
    if (preg_match($patron, $telefono)) {
        return true;
    }
    return false;
}

function test_ip($ip) {
    $patron = "/^(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])([.](\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])){3}$/";
    if (preg_match($patron, $ip)) {
        return true;
    }
    return false;
}

function test_codigo($codigo) {
    $patron = "/^[A-Z]{3}-\d{3,5}$/";
    if (preg_match($patron, $codigo)) {
        return true;
    }
    return false;
}

function test_password($password) {
    $patron = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/";
    if (preg_match($patron, $password)) {
        return true;
    }
    return false;
}

//---------------- Se examina la validez de algunos correos
//
$correos = array('luis@ab.com', 'luis.garcia@ab.jz.es', 'luis.@ab.com', 'x@ab.jz..es');
$ips = array('192.168.102.3', '0.0.0.0', '10.50.65.35.45', '256.12.30.45', '196.6a.64.32');
$telefonos = array('916080978', '686080978');
$codigo = array('ZAZ-4567', 'POV-333', 'LOL-99956', 'RAR-32');
$passwords = array('1contrasenA', 'nohay2sin3');
for ($i = 0; $i < count($correos); $i++) {
    if (test_email($correos[$i]))
        echo " el email $correos[$i] es correcto <br>";
    else
        echo " el email $correos[$i] es erroneo <br>";
}

for ($i = 0; $i < count($ips); $i++) {
    if (test_email($ips[$i]))
        echo " la ip $ips[$i] es correcta <br>";
    else
        echo " la ip $ips[$i] es erronea <br>";
}

for ($i = 0; $i < count($telefonos); $i++) {
    if (test_fijoMadrid($telefonos[$i]))
        echo " el telefono $telefonos[$i] es correcto <br>";
    else
        echo " el telefono $telefonos[$i] es erroneo <br>";
}

for ($i = 0; $i < count($codigo); $i++) {
    if (test_codigo($codigo[$i]))
        echo " el codigo $codigo[$i] es correcto <br>";
    else
        echo " el codigo $codigo[$i] es erroneo <br>";
}

for ($i = 0; $i < count($passwords); $i++) {
    if (test_codigo($passwords[$i]))
        echo " la contraseÃ±a $passwords[$i] es correcta <br>";
    else
        echo " la contraseÃ±a $passwords[$i] es erronea <br>";
}
?>