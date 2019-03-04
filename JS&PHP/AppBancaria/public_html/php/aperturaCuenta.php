<?php

$objetoRespuesta = new stdClass();
require_once 'configuracion/constantes_bbdd.php';
require_once 'fechas.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}



$sql = 'INSERT INTO clientes (dni,nombre,direccion,telefono,email,fecha_nacimiento,fecha_registro,numero_cuentas,saldo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ';
$q = $conex->prepare($sql);

if ($_POST['existeCliente1'] === "false") {
    $_POST['cliente1'][5] = convertirFecha($_POST['cliente1'][5]);
    $_POST['cliente1'][6] = convertirFecha($_POST['cliente1'][6]);
    $q->execute($_POST['cliente1']);
}
if (isset($_POST['cliente2']) && $_POST['existeCliente2'] === "false") {
    $_POST['cliente2'][5] = convertirFecha($_POST['cliente2'][5]);
    $_POST['cliente2'][6] = convertirFecha($_POST['cliente2'][6]);
    $q->execute($_POST['cliente2']);
}

$dni1 = $_POST['cliente1'][0];
$saldo = $_POST['saldo'];
$numCuenta = $_POST['numCuenta'];

if (isset($_POST['cliente2'])) {
    $dni2 = $_POST['cliente2'][0];
    $insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dni1`, `dni2`, `saldo`) VALUES ('$numCuenta', '$dni1', '$dni2', 0)";
} else {
    $insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dni1`, `dni2`, `saldo`) VALUES ('$numCuenta', '$dni1', NULL, 0)";
}

$conex->query($insertCuenta);

$fecha = date("Y-m-d");
$hora = date("H:i:s");
$insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('$numCuenta','$fecha','$hora','Apertura de cuenta', $saldo)";
$conex->query($insertMovimiento);



//consulta
$objetoRespuesta->mensaje = 'todo ok';


$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>