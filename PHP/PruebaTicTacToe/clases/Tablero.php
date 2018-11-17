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
        for ($fila = 0; $fila < 3; $fila++) {
            for ($columna = 0; $columna < 3; $columna++) {
                $posicion = "?fila=" . $fila . "&col=" . $columna;

                $this->tablero[$fila][$columna] = /* ?><!--a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="espacioBlanco"></a><?php ; */

                        //"<a href=\"". 'htmlspecialchars($_SERVER["PHP_SELF"])' ."\" class=\"espacioBlanco\">a</a>";
                        "<a href=\"http://localhost/PruebaTicTacToe/index.php" . $posicion . "\"><img src=\"\" alt=\"\" class=\"espacioBlanco\"></a>";


                //Ahí arriba creo que se puede quitar la imagen vacia
            }
        }
    }

    public function mostrar() {
        
        echo '<table>';
        for ($fila = 0; $fila < 3; $fila++) {
            echo '<tr>';
            for ($columna = 0; $columna < 3; $columna++) {
                echo '<td>';
				
                    echo ($this->tablero[$fila][$columna]);
                
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    public function ponerFicha(Jugador $jugador, Ficha $ficha) {
        
    }

    public function verificar($fila, $columna) {

        $tresEnRaya = false;


        $tresEnRaya = $this->comprobarRow($fila);
        if ($tresEnRaya === false) {
            $tresEnRaya = $this->comprobarCol($columna);
        }
        if ($tresEnRaya === false) {
            $tresEnRaya = $this->comprobarDiagonal();
        }

        return $tresEnRaya;
    }

    private function comprobarRow($fila) {
        $tresEnRaya = true;
        $turno = $this->getFicha()->etiquetaImg("imagen", 100, 100);
        for ($y = 0; $y < 3 && $tresEnRaya; $y++) {
            if ($this->tablero[$fila][$y] !== $turno) {
                $tresEnRaya = false;
            }
        }

        return $tresEnRaya;
    }

    private function comprobarCol($columna) {
        $tresEnRaya = true;
        $turno = $this->getFicha()->etiquetaImg("imagen", 100, 100);
        for ($x = 0; $x < 3 && $tresEnRaya; $x++) {
            if ($this->tablero[$x][$columna] !== $turno) {
                $tresEnRaya = false;
            }
        }

        return $tresEnRaya;
    }

    private function comprobarDiagonal() {
        $tresEnRaya = false;
        $turno = $this->getFicha()->etiquetaImg("imagen", 100, 100);
        $tablero = $this->tablero;
        if ($tablero[0][0] === $turno) {
            if ($tablero[1][1] === $turno) {
                if ($tablero[2][2] === $turno) {
                    $tresEnRaya = true;
                }
            }
        } else if ($tablero[0][2] === $turno) {
            if ($tablero[1][1] === $turno) {
                if ($tablero[2][0] === $turno) {
                    $tresEnRaya = true;
                }
            }
        }
        return $tresEnRaya;
    }

}
