<?php
class Coche{
	protected $color;
	protected $tipo;
	protected $velocidad = 0;
	public static $ventas = 0;
	
	const DIESEL = 1;
	const GASOLINA = 2;
	const VMAXIMA = 120;
	const VMINIMA = 0;
	public function setColor($color){
		$this->color = $color;
	}
	public function getColor(){
		return $this->color;
	}
	public function setTipo($tipo){
		$this->tipo = $tipo;
	} 
	public function acelerar(){
	if($this->velocidad <=Coche::VMAXIMA){
			$this->velocidad += 20;
	}
	}
	public function frenar(){
		if($this->velocidad >=Coche::VMINIMA){
			$this->velocidad -= 20;
	}
	}
	
	public static function totalVentas(){
		
		return Coche::$ventas;
	}
}
$miCoche = new Coche();
$miCoche->setColor('rojo');
$miCoche->setTipo(Coche::DIESEL);
$miCoche::$ventas++;

?>