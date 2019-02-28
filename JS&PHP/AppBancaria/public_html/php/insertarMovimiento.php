<?php

$objetoRespuesta = new stdClass();
$numCuenta = $_POST['numcuenta'];
$descripcion = $_POST['descripcion'];
$importe = $_POST['importe'];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
require_once 'configuracion/constantes_bbdd.php';
try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    $objetoRespuesta->cod_err = -1;
    require_once 'errorLog.php';
    escribirError($ex);
}
if (!isset($objetoRespuesta->cod_err)) {
//consulta
    $insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('$numCuenta', '$fecha', '$hora', '$descripcion', $importe)";
    $result = $conex->query($insertMovimiento);
    $objetoRespuesta->cod_err = 1;
    $conex = null;
}
$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;

//cerrar conex
?>