<?php
$insertCliente = "INSERT INTO `clientes` (`dni`, `nombre`, `direccion`, `telefono`, `email`, `fecha_nacimiento`, `fecha_registro`, `numero_cuentas`, `saldo`) VALUES ('49099576G', 'Chicote', 'fake street 123', '609786543', 'email@email.com', '2010-10-07', '2019-01-17', '1', '2000')";
$insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dn1`, `dn2`, `saldo`) VALUES ('0000000000', '49099576G', NULL, '1000')";
$insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('0000000000','2018/01/01','0800','descripcion',3000)";


require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}
//consulta
$conex->query($insertCliente);
$conex->query($insertCuenta);
$conex->query($insertMovimiento);

//cerrar conex
$conex = null;
?>