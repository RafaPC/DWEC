<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ficha
 *
 * @author Daw2
 */

class Ficha {

    private $nombre;
    private $imagen;

    function getNombre() {
        return $this->nombre;
    }

    function getImagen() {
        return $this->imagen;
    }

    public function __construct($nombre, $imagen) {
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }

    public function etiquetaImg($alt, $alto, $ancho, $imagen) {
        $etiqueta = "<img alt=\"$alt\" height=\"$alto\" width=\"$ancho\" src=\"$imagen\">";
        return $etiqueta;
    }

}
