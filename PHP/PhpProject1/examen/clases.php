<?php

class Carta {

    const OROS = 'OROS';
    const COPAS = 'COPAS';
    const ESPADAS = 'ESPADAS';
    const BASTOS = 'BASTOS';
    const ASS = 1;
    const TRES = 3;
    const SOTA = 10;
    const CABALLO = 11;
    const REY = 12;

    private $palo;
    private $valor;

    public function __construct($palo, $valor) {
        $this->palo = $palo;
        $this->valor = $valor;
    }

    public function imprime() {
        echo "Palo: $this->palo";
        echo "Valor: $this->valor";
    }

    public function puntos() {	
		if ($this->valor == self::ASS) {
            return 15;
        } else if ($this->valor == self::TRES) {
            return 13;
        } else {
            return $this->valor;
        }
    }

}

class Baraja {

    private $mazo = [];

    public function __construct() {
        $arrayPalos = [Carta::OROS, CARTA::COPAS, CARTA::ESPADAS, CARTA::BASTOS];

        for ($i = 0; $i < count($arrayPalos); $i++) {
            for ($j = 1; $j < 12; $j++) {
                $carta = new Carta($arrayPalos[$i], $j);
                array_push($this->mazo, $carta);
            }
        }
    }

    public function barajar() {
        shuffle($this->mazo);
    }

    public function sacarCarta() {
        return array_shift($this->mazo);
    }

    public function devolver(Carta $carta) {
        array_push($this->mazo, $carta);
    }

}
