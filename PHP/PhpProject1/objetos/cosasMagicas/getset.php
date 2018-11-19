<?php

class Coche{
private $velocidad;
private $color;
private $propiedades = [];
public function controlVelocidad($valor){
	if($valor>0 && $valor <=200){
		$this->velocidad = $valor;
	}
}

public function __get($nombrePropiedad){
	
	$valor = null;
	
	if(array_key_exists($nombrePropiedad,$this->propiedades)){
	
		$valor = $this->propiedades[$nombrePropiedad];
	}
	return $valor;

}

public function __set($nombrePropiedad, $valorPropiedad){

	$existe = in_array($nombrePropiedad,get_class_vars("Coche"));
	
	if(!$existe){
	$propiedades[$nombrePropiedad] = $valorPropiedad;
	}
}

}



?>