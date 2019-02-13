<?php

$objetoRespuesta = new stdClass();
$objetoRespuesta->movimientos = null;

$ncuenta = $_POST['numcuenta'];
$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];
if (isset($_POST['importeMinimo'])) {
    $minimo = $_POST['importeMinimo'];    
    $maximo = $_POST['importeMaximo'];
    $sql = "SELECT * FROM `movimientos` WHERE (fecha BETWEEN '$fecha1' AND '$fecha2') AND (importe BETWEEN '$minimo' AND '$maximo') AND (cod_cuenta = '$ncuenta') order by fecha";

} else {
    $sql = "SELECT * FROM `movimientos` WHERE (fecha BETWEEN '$fecha1' AND '$fecha2') AND (cod_cuenta = '$ncuenta') order by fecha";
}
require_once 'configuracion/constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}
//consulta
$result = $conex->query($sql);
$filas = array();
$result->setFetchMode(PDO::FETCH_ASSOC);
while ($r = $result->fetch()) {
    $filas[] = $r;
}
$objetoRespuesta->movimientos = $filas;
$objetoJSON = json_encode($objetoRespuesta);
header('Content-type: application/json; charset=utf-8');
echo $objetoJSON;

//cerrar conex
$conex = null;
?>