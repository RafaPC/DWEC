<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    try {
        $codCuenta = $_POST['cod_cuenta'];
        require_once 'conexion.php';
        $conex = Conexion::getConex();
        //Consulta
        $deleteCuenta = "DELETE FROM cuentas WHERE cod_cuenta = '$codCuenta'";
        if ($conex->exec($deleteCuenta) === 1) {
            $objetoRespuesta->cod_err = 1;
        } else {
            $objetoRespuesta->cod_err = -1;
        }
    } catch (Exception $ex) {
        escribirError($ex);
        die('{"cod_err":-8}');
    }
} else {
    die('{"cod_err":-8}');
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;

//Cerrar conex
$conex = null;
?>