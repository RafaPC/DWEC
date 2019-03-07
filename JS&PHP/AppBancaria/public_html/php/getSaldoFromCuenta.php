<?php

$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    $codCuenta = $_POST['cod_cuenta'];

    require_once 'conexion.php';
    $conex = Conexion::getConex();
    //consulta
    $selectCuenta = "SELECT saldo FROM cuentas WHERE cod_cuenta = '$codCuenta'";
    $result = $conex->query($selectCuenta);
    $resultado = $result->fetchColumn();
    $objetoRespuesta->saldo = intval($resultado);
} else {
    $objetoRespuesta->cod_err = -1;
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>