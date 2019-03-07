<?php

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

$conn = new mysqli('localhost', 'root', '1234');
if (!$conn) {
    die('No pudo conectarse: ');
}


$sql = "CREATE DATABASE banco";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
    $conn2 = new mysqli('localhost', 'root', '1234','banco');
} else {
    echo "Error creating database: " . $conn2->error;
}


//consulta
$conn2->query($crearTablaCliente);
$conn2->query($crearTablaCuentas);
$conn2->query($crearTablaMovimientos);

//cerrar conex
$conn2 = null;
?>