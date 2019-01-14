<?php
$myObj->msg = 'eso no era';
$numCuenta = $_POST['numCuenta'];
if(isset($_POST['numCuenta'])){
	$myObj->msg = 'pues no se mete bien el post';
}
$selectCliente = "SELECT cl_ncuenta from clientes where cl_ncuenta = $ncuenta";

//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$result = $conex->real_query($selectCliente);
if($result){
	$myObj->existe = true;	
}else{
	$myObj->existe = false;
}
$myJSON = json_encode($myObj);
echo $myJSON;
//cerrar conex
$conex->close();
?>