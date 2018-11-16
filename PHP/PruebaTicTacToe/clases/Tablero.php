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

    public $tablero = [[], [], []];
    private $ficha1;
    private $ficha2;
    private $turno = 1;

    public function __construct(Ficha $ficha1, Ficha $ficha2) {
        $this->ficha1 = $ficha1;
        $this->ficha2 = $ficha2;
        for ($fila = 0; $fila < 3; $fila++) {
            for ($columna = 0; $columna < 3; $columna++) {
                $posicion = "?fila=".$fila."&col=".$columna;
                
                $this->tablero[$fila][$columna] = /* ?><!--a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="espacioBlanco"></a><?php ; */
                
                        //"<a href=\"". 'htmlspecialchars($_SERVER["PHP_SELF"])' ."\" class=\"espacioBlanco\">a</a>";
                "<a href=\"http://localhost/PruebaTicTacToe/index.php".$posicion."\"><img src=\"\" alt=\"\" class=\"espacioBlanco\"></a>";
            
                
                //Ahí arriba creo que se puede quitar la imagen vacia
                
            }
        }
    }

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
