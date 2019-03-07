<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();
require_once 'fechas.php';

if (isset($_POST['cod_cuenta']) && isset($_POST['fecha1']) && isset($_POST['fecha2'])) {
    try {
        $objetoRespuesta->movimientos = [];
        $codCuenta = $_POST['cod_cuenta'];
        $fecha1 = convertirFecha($_POST['fecha1']);
        $fecha2 = convertirFecha($_POST['fecha2']);

        //Si se ha mandado el importe mínimo, se hace otra query
        if (isset($_POST['importeMinimo'])) {
            $minimo = $_POST['importeMinimo'];
            $maximo = $_POST['importeMaximo'];
            $sql = "SELECT * FROM `movimientos` WHERE (fecha BETWEEN '$fecha1' AND '$fecha2') AND (importe BETWEEN '$minimo' AND '$maximo') AND (cod_cuenta = '$codCuenta') order by fecha";
        } else {
            $sql = "SELECT * FROM `movimientos` WHERE (fecha BETWEEN '$fecha1' AND '$fecha2') AND (cod_cuenta = '$codCuenta') order by fecha";
        }
        require_once 'conexion.php';
        $conex = Conexion::getConex();
        //Consulta
        $result = $conex->query($sql);
        $objetoRespuesta->movimientos = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        escribirError($ex);
        die('{"cod_err":-5}');
    }
} else {
    die('{"cod_err":-5}');
}

$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;

//cerrar conex
$conex = null;
?>