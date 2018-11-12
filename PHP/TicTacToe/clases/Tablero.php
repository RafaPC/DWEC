<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tablero
 *
 * @author Daw2
 */
class Tablero {

    private $ficha1;
    private $ficha2;
    private $turno = 1;

    public function getFicha() {
        if ($this->turno == 1) {
            return $this->ficha1;
        } else {
            //Si no es turno 1 es turno 2
            return $this->ficha2;
        }
    }

    public function cambioTurno() {
        if ($this->turno === 1) {
            $this->turno = 2;
        } else {
            $this->turno = 1;
        }
    }

    public function iniciar() {
        //Poner el tablero a 0
    }

    public function mostrar() {
        
    }

    public function ponerFicha(Jugador $jugador, Ficha $ficha) {
        
    }

    public function verificar() {
        
    }

}
