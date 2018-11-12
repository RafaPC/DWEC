<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jugador
 *
 * @author Daw2
 */

class Jugador {

    private $nombre;
    private $ficha;
    private $puntos = 0;

    public function getNombre() {
        return $this->nombre;
    }

    public function getFicha() {
        return $this->ficha;
    }

    public function getPuntos() {
        return $this->puntos;
    }

    public function sumarPuntos($puntos = 1){
        $this->puntos += $puntos;
    }
    
    public function __construct($nombre, $ficha) {
        $this->nombre = $nombre;
        $this->ficha = $ficha;
    }

}
