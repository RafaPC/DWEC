<?php
$insertCliente = "INSERT INTO 'clientes' ('cl_dni', 'cl_nombre', 'cl_dir', 'cl_tel', 'cl_email', 'cl_fnac', 'cl_fcl', 'cl_ncuenta', 'cl_sal') VALUES ('49099576G', 'Alberto Chicote', 'Fake Street 123', '607283200', 'therealchicote@tempmail.com', '5/5/1984', '15/2/2007', '0000000000', '2000');";
$insertCuenta = "INSERT INTO 'cuentas' ('cu_ncuenta', 'cu_dn1', 'cu_dn2', 'cu_sal') VALUES ('0000000000', '49099576G',NULL , '2000')";
$insertMovimiento = "INSERT INTO 'movimientos' ('mo_ncuenta', 'mo_fec', 'mo_hor', 'mo_descr', 'mo_importe') VALUES ('0000000000', '1/3/2007', '08:00', 'Importe horas extras', '359');";


//abrir conexion
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}
//consulta
$conex->query($insertCliente);
$conex->query($insertCuenta);
$conex->query($insertMovimiento);

//cerrar conex
$conex->close();
?>