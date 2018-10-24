<?php
function validar($username, $contraseña){
	$validado = false;
	
	//Elimina espacios antes y después del nombre
	$username = trim($username);
	
	$contraseña = trim ($contraseña);
	
	//Elimina los / 
	$username = stripslashes($username);
	$contraseña = stripslashes($contraseña);
	
	//Elimina caracteres raros
	$username = htmlspecialchars($username);
	$contraseña = htmlspecialchars($contraseña);
	
	if(strlen($username)>0 && strlen($contraseña)>0){
		$validado = true;
	}
	
return $validado;
}

function comprobarSesion(){
	session_start();
	if(!isset($_SESSION['usuario'])){
	//Redirección a la primera página
	header ('Location: '.'entrada.php');
	}
}

function mostrar_carrito(){

	$carrito = $_SESSION['carrito'];
	?>
	<table>
		<tr>
			<td>Artículo:</td>
			<td>Cantidad:</td>
	</tr>
	<?php
	foreach ($carrito as $articulo=>$cantidad){
	$numero = @$_SESSION['carrito'][$articulo] or $numero = 0;					
	echo "<tr><td>$articulo</td>";
	echo "<td>$numero</td></tr>";
	}
	
	echo '<table>';
}

function articulos(){
	?>
	
	<table>
		<tr>
			<td>Nombre</td>
			<td>Cantidad</td>
			<td>Precio</td>
		</tr>
		<tr>
			<td><a href="php/php/tienda/compra.php?articulo=Seboglu">Seboglu</a></td>
			<td>18</td>
			<td>4.3$</td>
		</tr>
		<tr>
			<td><a href="php/php/tienda/compra.php?articulo=BuzzCola">BuzzCola</a></td>
			<td>43</td>
			<td>6.76$</td>
		</tr>
		<tr>
			<td><a href="php/php/tienda/compra.php?articulo=Placa_BORT">Placa BORT</a></td>
			<td>0</td>
			<td>7$</td>
		</tr>
		<tr>
			<td><a href="php/php/tienda/compra.php?articulo=Mad_Magazine">Mad Magazine</a></td>
			<td>5</td>
			<td>2$</td>
		</tr>
	</table>
	<?php
}


?>