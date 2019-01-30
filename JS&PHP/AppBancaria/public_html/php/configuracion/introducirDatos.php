<?php
$insertCliente = "INSERT INTO `clientes` (`dni`, `nombre`, `direccion`, `telefono`, `email`, `fecha_nacimiento`, `fecha_registro`, `numero_cuentas`, `saldo`) VALUES ('49099576G', 'Chicote', 'fake street 123', '609786543', 'email@email.com', '2010-10-07', '2019-01-17', 0, 0)";
$insertCuenta = "INSERT INTO `cuentas` (`cod_cuenta`, `dni1`, `dni2`, `saldo`) VALUES ('0000000000', '49099576G', NULL, 0)";
$insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('0000000000','2018/01/01','08:00:00','descripcion',3000)";


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
$insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('0000000000','2017/01/01','12:00:00','Hipoteca',-500)";
$conex->query($insertMovimiento);
$insertMovimiento = "INSERT INTO `movimientos`(`cod_cuenta`, `fecha`, `hora`, `descripcion`, `importe`) VALUES ('0000000000','2017/12/23','12:00:00','Paga extra navidad',1200)";
$conex->query($insertMovimiento);

//cerrar conex
$conex = null;
?>