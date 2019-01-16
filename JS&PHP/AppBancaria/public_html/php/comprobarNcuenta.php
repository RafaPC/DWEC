<?php
require('conexion.php');
$conex = new conectaBD('banco');
$myObj = new stdClass();
$myObj->msg = 'eso no era';
$numCuenta;
if(isset($_POST['numCuenta'])){
	$numCuenta = $_POST['numCuenta'];
}else{
	$myObj->msg = 'pues no se mete bien el post';
}
$selectCuenta = "SELECT cu_ncuenta from cuentas where cu_ncuenta = '$numCuenta'";

//consulta
$row = $conex->consultaRow($selectCuenta);
if($row === 1){
	$myObj->existe = true;	
}else{
	$myObj->existe = false;
}
$myJSON = json_encode($myObj);
echo $myJSON;
//cerrar conex
$conex->close();
?>