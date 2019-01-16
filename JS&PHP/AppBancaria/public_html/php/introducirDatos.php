<?php
$insertCliente = "INSERT INTO `clientes` (`cl_dni`, `cl_nombre`, `cl_dir`, `cl_tel`, `cl_email`, `cl_fnac`, `cl_fcl`, `cl_ncuenta`, `cl_sal`) VALUES ('49099576G', 'Chicote', 'fake street 123', '609786543', 'email@email.com', '2010-10-07', '2019-01-17', '1', '2000')";
$insertCuenta = "INSERT INTO `cuentas` (`cu_ncuenta`, `cu_dn1`, `cu_dn2`, `cu_sal`) VALUES ('0000000000', '49099576G', NULL, '1000')";
$insertMovimiento = "INSERT INTO `movimientos`(`mo_ncuenta`, `mo_fec`, `mo_hor`, `mo_descr`, `mo_importe`) VALUES ('49099576G','2018/01/01','0800','descripcion',3000)";


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