<?php
//CUANDO HAGA LOS REGEXP EN JS MIRAR QUE LOS DNI'S PASAN LOS REGEX//
$insertTablaClientes = "INSERT INTO clientes VALUES('52787804P','Pau','Calle Estonia 15 1ºA','609876654','tempmail@tempmail.com','1983/7/31','2013/1/13',27,'3890');";
$insertTablaCuentas = "INSERT INTO cuentas VALUES(3,'52787804P','52787804P','3890');";
$insertTablaMovimientos = "DROP TABLE `movimientos`;";


//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$conex->query($insertTablaClientes);
$conex->query($insertTablaCuentas);
//$conex->query($insertTablaMovimientos);

//cerrar conex
$conex->close();
?>