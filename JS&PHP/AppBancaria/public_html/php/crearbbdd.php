<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('head.html');
$crearTablaCliente = "CREATE TABLE clientes (
	cl_dni varchar(9) NOT NULL,
	cl_nombre varchar(50) NOT NULL,
	cl_dir varchar(60) NOT NULL,
	cl_tel varchar(9) NOT NULL,
	cl_email varchar(65) NOT NULL,
	cl_fnac date DEFAULT NULL,
	cl_fcl date NOT NULL,
	cl_ncuenta tinyint(2) NOT NULL,
	cl_sal int(8) NOT NULL,
	PRIMARY KEY (cl_dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$crearTablaCuentas ="CREATE TABLE cuentas(
	cu_ncuenta varchar(10) NOT NULL,
    cu_dn1 varchar(9) NOT NULL, 
    cu_dn2 varchar(9) DEFAULT NULL, 
    cu_sal int(8) NOT NULL,
    PRIMARY KEY (cu_ncuenta),
	FOREIGN KEY (cu_dn1) REFERENCES clientes(cl_dni),
	FOREIGN KEY (cu_dn2) REFERENCES clientes (cl_dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$crearTablaMovimientos = "CREATE TABLE movimientos (
	mo_ncuenta varchar(10) NOT NULL, 
	mo_fec date NOT NULL, 
    mo_hor varchar(6) NOT NULL, 
	mo_descr varchar(80) NOT NULL,
	mo_importe int(8) NOT NULL,
	PRIMARY KEY (mo_ncuenta, mo_fec, mo_hor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
		
// Conectar
$conex = new mysqli('localhost', 'root', '1234', 'banco');
// Comprobar conexión
if ($conex->connect_error) {
    die('La conexión ha fallado, error número ' . $conex->connect_errno . ': ' . $conex->connect_error);
} else {
    echo '<h1>Se ha conectado a la base de datos</h1>';
}


//consulta
$conex->query($crearTablaCliente);
$conex->query($crearTablaCuentas);
$conex->query($crearTablaMovimientos);

//cerrar conex
$conex->close();
?>
    </body>
</html>