<?php

$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    $codCuenta = $_POST['cod_cuenta'];
}

if (strlen($codCuenta) === 10) {
    $ultimoNumero = substr($codCuenta, 0, 9);
    for ($i = 0, $acum = 0; $i < strlen($codCuenta) - 1; $i++) {
        $acum += codCuenta[i];
    }
    if ($acum % 9 == $ultimoNumero) {
        $objetoRespuesta->cod_err = 1;
    } else {
        $objetoRespuesta->cod_err = -2;
    }
} else {
    $objetoRespuesta->cod_err = -1;
}
$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>