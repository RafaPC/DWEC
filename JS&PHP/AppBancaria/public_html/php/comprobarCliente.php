<?php

$objetoRespuesta = new stdClass();

if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];
}
$selectCliente = "SELECT * FROM `clientes` WHERE dni = '$dni'";

require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}
//consulta
$result = $conex->query($selectCliente);

if ($result) {
    $objetoRespuesta->existe = true;
    $cliente = new stdClass();
    foreach ($result as $row) {
        foreach ($row as $clave => $valor) {
            $cliente->$clave = $valor;
        }
    }
    $objetoRespuesta->cliente = $cliente;
} else {
    $objetoRespuesta->existe = false;
}


$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>