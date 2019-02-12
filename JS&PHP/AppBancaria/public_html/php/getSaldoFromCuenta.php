<?php

$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    $codCuenta = $_POST['cod_cuenta'];
    require_once 'configuracion/constantes_bbdd.php';

    try {
        $conex = new PDO(DSN, USER, PASSWORD);
    } catch (PDOException $ex) {
        $objetoRespuesta->cod_err = -2;
        //Podría quitar el die para que si hay error de la base de datos lo pueda saber con el codigo de error
        die("Error!: " . $ex->getMessage() . "<br>");
    }
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