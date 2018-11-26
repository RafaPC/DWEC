<?php
//abrir conexion
$conex = mysqli_connect("localhost","root","1234")
	or die("No se ha podido conectar...");

	mysqli_select_db($conex,"dwes")
		or die("No se ha podido seleccionar la base de datos");
//consulta
$consulta = mysqli_query($conex,"select * from usuarios where login = 'yo'");
$numFilas = mysqli_num_rows($consulta);
$filaActual = 0;
while($filaActual < $numFilas){
	$fila = mysqli_fetch_array($consulta);
	echo '<pre>';
	print_r ($fila);
	echo '</pre>';
	echo $numFilas;
	$filaActual++;
}
//cerrar conex
mysqli_close($conex);
?>