<?php

$objetoRespuesta = new stdClass();

if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
}
$selectCliente = "SELECT * FROM `clientes` WHERE dni = '$dni'";

require_once 'configuracion/constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}
//consulta
$result = $conex->query($selectCliente);

    $objetoRespuesta->existe = true;
    $cliente = new stdClass();
    foreach ($result as $row) {
        foreach ($row as $clave => $valor) {
            $cliente->$clave = $valor;
        }
    }
    $objetoRespuesta->cliente = $cliente;



$objetoJSON = json_encode($objetoRespuesta);
echo $objetoJSON;
//cerrar conex
$conex = null;
?>