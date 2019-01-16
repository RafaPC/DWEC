<?php
$ncuenta = $_POST['ncuenta'];
$fecha1 = date("Y-m-d",strtotime($POST['fecha1']));
$fecha2 = date("Y-m-d",strtotime($POST['fecha2']));
$sql = "SELECT * FROM `movimientos` WHERE (mo_fec BETWEEN '$fecha1' AND '$fecha2')";
//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$result = $conex->query($sql);


//AQUI PONER QUE LO COJA COMO ASOCIATIVO Y ESO


$myJSON = json_encode($result);
echo $myJSON;

//cerrar conex
$conex->close();
?>