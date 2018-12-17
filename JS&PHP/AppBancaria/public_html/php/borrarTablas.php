<?php
$dropTablaClientes = "DROP TABLE `clientes`;";
$dropTablaCuentas = "DROP TABLE `cuentas`;";
$dropTablaMovimientos = "DROP TABLE `movimientos`;";


//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$conex->query($dropTablaCuentas);
$conex->query($dropTablaClientes);
$conex->query($dropTablaMovimientos);

//cerrar conex
$conex->close();
?>