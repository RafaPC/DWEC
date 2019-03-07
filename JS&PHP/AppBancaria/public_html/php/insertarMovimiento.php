<?php

require_once 'errorLog.php';
$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta']) && isset($_POST['concepto']) && isset($_POST['importe'])) {
    try {
        $codCuenta = $_POST['cod_cuenta'];
        $descripcion = $_POST['concepto'];
        $importe = $_POST['importe'];
        $fecha = date("Y-m-d");
        //Creo hora en formato horas, minutos y segundos quitándole los dos (dos) puntos de separación
        $hora = str_replace(":", "", date("H:i:s"));
        require_once 'conexion.php';
        $conex = Conexion::getConex();
        //Consulta
        $insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('$codCuenta', '$fecha', '$hora', '$descripcion', $importe)";
        //Si devuelve 1 es que se ha insertado
        //La parte de sumar el saldo a la cuenta y a los clientes de esa cuenta
        // es de los triggers de la base de datos
        if ($conex->exec($insertMovimiento) === 1) {
            $objetoRespuesta->cod_err = 1;
        }else{
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