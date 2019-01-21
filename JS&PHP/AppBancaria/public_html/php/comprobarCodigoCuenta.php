<?php
$objetoRespuesta = new stdClass();

if (isset($_POST['cod_cuenta'])) {
    $codCuenta = $_POST['cod_cuenta'];
}
$selectCuenta = "SELECT cod_cuenta FROM cuentas WHERE cod_cuenta = '$codCuenta'";

require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}
//consulta
$result = $conex->query($selectCuenta);
$numRows = $result->fetchColumn();
if ($numRows) {
    $objetoRespuesta->existe = true;
} else {
    $objetoRespuesta->existe = false;
}
$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>