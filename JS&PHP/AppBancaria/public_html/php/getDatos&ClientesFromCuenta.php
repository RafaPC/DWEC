<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    try {
        $codigoCuenta = $_POST['cod_cuenta'];

        require_once 'conexion.php';
        $conex = Conexion::getConex();

        $conex->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
        $selectCuenta = "SELECT dni1, dni2, saldo FROM `cuentas` WHERE cod_cuenta = '$codigoCuenta'";

        $resultado = $conex->query($selectCuenta);
        $cuenta = $resultado->fetchAll();
        $objetoRespuesta->cuenta = $cuenta[0];

        $dni1 = $objetoRespuesta->cuenta[0];
        $resultadoCliente1 = $conex->query("SELECT * FROM `clientes` WHERE dni = '$dni1'");
        $cliente1 = $resultadoCliente1->fetchAll();
        $objetoRespuesta->cliente1 = $cliente1[0];

        if ($objetoRespuesta->cuenta[1] !== null) {
            $dni2 = $objetoRespuesta->cuenta[1];
            $resultadoCliente2 = $conex->query("SELECT * FROM `clientes` WHERE dni = '$dni2'");
            $cliente2 = $resultadoCliente2->fetchAll();
            $objetoRespuesta->cliente2 = $cliente2[0];
        }
        $objetoRespuesta->saldo = $objetoRespuesta->cuenta[2];
    } catch (Exception $ex) {
        escribirError($ex);
        die('{"cod_err":-8}');
    }
} else {
    die('{"cod_err":-8}');
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>