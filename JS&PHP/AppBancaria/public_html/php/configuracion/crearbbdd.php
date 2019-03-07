<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('../head.html');
$crearTablaCliente = "CREATE TABLE clientes (
	dni varchar(9) NOT NULL,
	nombre varchar(50) NOT NULL,
	direccion varchar(60) NOT NULL,
	telefono varchar(9) NOT NULL,
	email varchar(65) NOT NULL,
	fecha_nacimiento date DEFAULT NULL,
	fecha_registro date NOT NULL,
	numero_cuentas tinyint(2) NOT NULL,
	saldo int(8) NOT NULL,
	PRIMARY KEY (dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$crearTablaCuentas = "CREATE TABLE cuentas(
	cod_cuenta varchar(10) NOT NULL,
        dni1 varchar(9) NOT NULL, 
        dni2 varchar(9) DEFAULT NULL, 
        saldo int(8) NOT NULL,
        PRIMARY KEY (cod_cuenta),
	FOREIGN KEY (dni1) REFERENCES clientes(dni),
	FOREIGN KEY (dni2) REFERENCES clientes (dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$crearTablaMovimientos = "CREATE TABLE movimientos (
	cod_cuenta varchar(10) NOT NULL, 
	fecha date NOT NULL, 
        hora varchar(6) NOT NULL, 
	descripcion varchar(80) NOT NULL,
	importe int(8) NOT NULL,
	PRIMARY KEY (cod_cuenta, fecha, hora)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

require_once 'constantes_bbdd.php';

try {
    $conex = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $ex) {
    die("Error!: " . $ex->getMessage() . "<br>");
}


//consulta
$conex->query($crearTablaCliente);
$conex->query($crearTablaCuentas);
$conex->query($crearTablaMovimientos);

//cerrar conex
$conex = null;
?>
</body>
</html>