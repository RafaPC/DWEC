<?php
function filtrado($cadena){
	$validado = false;
	$cadena = trim($cadena);
	$cadena = stripslashes($cadena);
	$cadena = htmlspecialchars($cadena);
	if(strlen($cadena)>0){
			$validado = true;
		}
		return $validado;
}

?>