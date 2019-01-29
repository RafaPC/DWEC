<?php

$objetoRespuesta = new stdClass();

require_once 'configuracion/constantes_bbdd.php';
try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}

	$sql = ' INSERT INTO clientes (dni,nombre,direccion,telefono,email,fecha_nacimiento,fecha_registro,numero_cuentas,saldo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ';
    $q = $conex->prepare($sql);
	

if(isset($_GET['existeCliente1']) && !$_GET['existeCliente1']) {
	$q->execute($_GET['cliente1']);
}
if(isset($_GET['cliente2']) && isset($_GET['existeCliente2']) &&  !$_GET['existeCliente2']){
	$q->execute($_GET['cliente2']);
}

$dni1 = $_GET['cliente1'][0];
$saldo = $_GET['saldo'];
$numCuenta = $_GET['numCuenta'];

if(isset($_GET['cliente2'])){
	$dni2 = $_GET['cliente2'][0];
	$insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dn1`, `dn2`, `saldo`) VALUES ('$numCuenta', '$dni1', '$dni2', '$saldo')";
}else{
	$insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dn1`, `dn2`, `saldo`) VALUES ('$numCuenta', '$dni1', NULL, '$saldo')";
}


$conex->query($insertCuenta);



 
//consulta

    $objetoRespuesta->mensaje = 'todo ok';



$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>