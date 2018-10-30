<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CabeceraPagina {

    private $ladoCentrado;
    private $colorFondo;
    private $colorFuente;

    public function __construct($ladoCentrado, $colorFondo, $colorFuente) {
        $this->ladoCentrado = $ladoCentrado;
        $this->colorFondo = $colorFondo;
        $this->colorFuente = $colorFuente;
    }

    public function mostrarTitulo() {
        ?>
        <div style="
             background-color: <?php echo $this->colorFondo ?>;
             color: <?php echo $this->colorFuente ?>; 
             text-align: <?php echo $this->ladoCentrado ?>">Titulo</div>
        <?php
    }

}

class Tabla {

    private $numRows;
    private $numCols;
    private $dato;
    private $rowDato;
    private $colDato;
    private $colorDato;
    private $colorBackgroundDato;

}

$newCabecera = new CabeceraPagina('right', 'green', 'red');
?>
<!DOCTYPE>
<html lang="es">
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        echo $newCabecera->mostrarTitulo();
        ?>
    </body>
</html>


