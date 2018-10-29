<?php

class Coche {
	//propiedades
	protected $color;
	protected $tipo; //diesel o gasolina
	protected $velocidad = 0;
	public static $ventas =0;
	
	const DIESEL = 1;
	const GASOLINA= 2;
	
	//constructores
	//métodos
	public function setColor($color){
		$this->color = $color;
	}
	public function getColor(){
		return $this->color;
	}
	public function setTipo($tipo){
		 $this->tipo = $tipo;
	}
	public function getTipo(){
		return $this->tipo;
	}
	public function acelerar(){
		
	}
	public function frenar(){
		
	}
	//método estático
	public static  function totalVentas(){

		return Coche::$ventas;
	}
}
Coche::$ventas++;
echo "Los coches de GASOLINA son de tipo ". 
		Coche::GASOLINA;
		
echo "El total de ventas es: ". 
		Coche::totalVentas() . '<br>';

?>