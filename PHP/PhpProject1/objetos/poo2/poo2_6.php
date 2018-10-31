<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Figura {

    protected $nombre;
    protected $color;
    protected $esRellena;

    public function __construct($nombre, $color, $esRellena) {
        $this->nombre = $nombre;
        $this->color = $color;
        $this->esRellena = $esRellena;
    }

    public function getNombre() {
        return $this->nombre;
    }

    final function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function estaRellena() {
        return $this->esRellena;
    }

    public function estaVacia() {
        if ($this->esRellena) {
            $vacia = false;
        } else {
            $vacia = true;
        }
        return $vacia;
    }

    public function showInfo() {
        echo 'Nombre: ' . $this->nombre . '<br>';
        echo 'Color: ' . $this->color . '<br>';
        echo 'Esta rellena: ' . $this->esRellena . '<br>';
    }

    abstract public function getArea();
}

class Circulo extends Figura {

    private $radio;

    public function getRadio() {
        return $this->radio;
    }

    public function setRadio($radio) {
        $this->radio = $radio;
    }

    public function getArea() {
        return (pi * pow($this->radio, 2));
    }

    public function getNombre() {
        //cambiar algo creo
        return 'circulo';
    }

    public function showInfo() {
        parent::showInfo();
        echo 'Radio: ' . $this->radio;
    }

    public function __construct($nombre, $color, $esRellena, $radio) {
        parent::__construct($nombre);
        $this->radio = $radio;
    }

}

class Cuadrado extends Figura implements Imprimible {

    private $lado;

    public function getLado() {
        return $this->lado;
    }

    public function setLado($lado) {
        $this->lado = $lado;
    }

    public function getArea() {
        return pow($this->lado, 2);
    }

    public function showInfo() {
        parent::showInfo();
        echo 'Lado: ' . $this->lado . '\n';
    }

    public function __construct($nombre, $color, $esRellena, $lado) {
        parent::__construct($nombre, $color, $esRellena);
        $this->lado = $lado;
    }

    public function imprime() {
        ?><div style="width:<?php echo $this->lado; ?>; height:<?php
        echo $this->lado;

        if ($this->esRellena) {
            ?>
                 ;background-color:<?php echo $this->color ?>">
                <?php
            } else {
                ?> ;border: 5px dotted <?php echo $this->color; ?>"> <?php
            }
            echo '</div>';
        }

    }

    class Rectangulo extends Figura {

        public function getArea() {
            
        }

    }

    interface Imprimible {

        public function imprime();
    }

    $cuadrado = new Cuadrado('cuadrado', 'purple', true, 200);
    $cuadrado->imprime();
    
    ?>