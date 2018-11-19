<?php

class Cadena{

	private $texto = "";
	private $metodosPermitidos = array ("strtoupper","str_split","str_repeat","crypt");
	
	public function getText(){
			return $this->texto;
	}
	public function setTexto($valor){
		$this->texto = $valor;
	}
	public function __call($nombreMetodo, $argumentos){
	$aux = null;
	array_unshift($argumentos, $this->texto);
	if(in_array($nombreMetodo, $this->metodosPermitidos)){
		$aux = call_user_func_array($nombreMetodo, $argumentos);
	}else{
		die ("El metodo $nombreMetodo no exisste");
	}
}

}

$c = new Cadena();
$c->setTexto("Hola-Mundo");
$nuevo_texto = $c->str_slplit();
echo "El texto obtenido con str_split es ";
print_r($nuevo_texto);
echo '<br>';

//Metodos que existenc
echo $c->strtoypper().' <br>';
echo $c->str_repeat(3).' <br>';
echo $c->crypt(1).' <br>';

//Metodos que no existen
echo $c->strlen();
echo '<pre>';
print_r($c);
echo '</pre>';
?>