<?php
$dropTablaClientes = "DROP TABLE `clientes`;";
$dropTablaCuentas = "DROP TABLE `cuentas`;";
$dropTablaMovimientos = "DROP TABLE `movimientos`;";


require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}

//consulta
$conex->query($dropTablaCuentas);
$conex->query($dropTablaClientes);
$conex->query($dropTablaMovimientos);

//cerrar conex
$conex = null;
?>