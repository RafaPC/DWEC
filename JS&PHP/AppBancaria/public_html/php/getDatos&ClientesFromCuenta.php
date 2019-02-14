<?php

$objetoRespuesta = new stdClass();
require_once 'configuracion/constantes_bbdd.php';
try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}

//HACER UN PREPARE PARA LA QUERY DE CLIENTESO


$codigoCuenta = $_POST['numCuenta'];
$selectPrueba = "SELECT cuentas.*, clientes.* FROM `cuentas` JOIN `clientes` ON (cuentas.dni1 = clientes.dni or cuentas.dni2 = clientes.dni) WHERE cuentas.cod_cuenta = '0000000000'";
$selectCuenta = "SELECT dni1, dni2, saldo FROM `cuentas` WHERE cod_cuenta = '$codigoCuenta'";

$resultado = $conex->query($selectCuenta);
$cuenta = $resultado->fetchAll(PDO::FETCH_NUM);
$objetoRespuesta->cuenta = $cuenta[0];

$dni1 = $objetoRespuesta->cuenta[0];
$resultadoCliente1 = $conex->query("SELECT * FROM `clientes` WHERE dni = '$dni1'");
$cliente1 = $resultadoCliente1->fetchAll(PDO::FETCH_NUM);
$objetoRespuesta->cliente1 = $cliente1[0];

if ($objetoRespuesta->cuenta[1] !== NULL) {
    $dni2 = $objetoRespuesta->cuenta[1];
    $resultadoCliente2 = $conex->query("SELECT * FROM `clientes` WHERE dni = '$dni2'");
    $cliente2 = $resultadoCliente2->fetchAll(PDO::FETCH_NUM);
    $objetoRespuesta->cliente2 = $cliente2[0];
}
//consulta
$objetoRespuesta->mensaje = 'todo ok';


$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>