<?php

$myObj = new stdClass();

if (isset($_POST['numCuenta'])) {
    $numCuenta = $_POST['numCuenta'];
}
$selectCuenta = "SELECT cu_ncuenta from cuentas where cu_ncuenta = '$numCuenta'";

//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexiÃ³n
if ($conex->connect_error) {
    //die('La conexiÃ³n ha fallado, error nÃºmero ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    //echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$result = $conex->query($selectCuenta);
if (mysqli_num_rows($result) === 1) {
    $myObj->existe = true;
} else {
    $myObj->existe = false;
}
$myJSON = json_encode($myObj);
echo $myJSON;
//cerrar conex
$conex->close();
?>