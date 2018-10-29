<?php

class Coche {
	//propiedades
	protected $color;
	protected $tipo; //diesel o gasolina
	protected $velocidad = 0;
	public static $ventas =0;
	
	const DIESEL = 1;
	const GASOLINA= 2;
	const VMAXIMA = 250;
	const VMINIMA = 0;
	
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
	public function getVelocidad(){
		return $this->velocidad;
	}
	//Acelere de 10 en 10 sin que exceda 
	//de la	velocidad máxima.
	public function acelerar(){
		if ($this->velocidad <=Coche::VMAXIMA){
			$this->velocidad +=10;
		}
	}

	//Reducir la velocidad de 10 en 10 
	//sin que exceda de la	velocidad mínima.
	public function frenar(){
		if ($this->velocidad > Coche::VMINIMA){
			$this->velocidad -=10;
		}
	}
	//método estático
	public static  function totalVentas(){

		return Coche::$ventas;
	}
} //fin de la definición de la clase.


/*
* MI PROGRAMA
*/

define("VMAXIMA", 180);
echo VMAXIMA . '<br>';
echo Coche::VMAXIMA . '<br>';
$miCoche = new Coche();
$miCoche -> setColor("rojo");
$miCoche -> setTipo(Coche::DIESEL);
$miCoche -> frenar();
?><pre><?php
print_r($miCoche);
?></pre><?php
echo '<br>';

$miDeportivo = new Coche();
$miDeportivo -> setColor("verde");
$miDeportivo -> setTipo(Coche::GASOLINA);
while($miDeportivo->getVelocidad() < Coche::VMAXIMA){
	$miDeportivo->acelerar();
	echo "Mi deportivo va a ". $miDeportivo->getVelocidad(). "km/h<br>";
}
?><pre><?php
print_r($miDeportivo);
?></pre><?php


echo "<br>Se ha producido una venta<br>";
Coche::$ventas++;
echo "El total de ventas es: ". 
		Coche::totalVentas() . '<br>';


?>