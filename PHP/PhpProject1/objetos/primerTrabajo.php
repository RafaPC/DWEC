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

class Dato {

    private $dato;
    private $row;
    private $col;
    private $colorFuente;
    private $colorFondo;

    function __construct($dato, $rowDato, $colDato, $colorFuente, $colorFondo) {
        $this->dato = $dato;
        $this->rowDato = $rowDato;
        $this->colDato = $colDato;
        $this->colorFuente = $colorFuente;
        $this->colorFondo = $colorFondo;
    }
    
    function getDato() {
        return $this->dato;
    }

    function getRow() {
        return $this->row;
    }

    function getCol() {
        return $this->col;
    }

    function getColorFuente() {
        return $this->colorFuente;
    }

    function getColorFondo() {
        return $this->colorFondo;
    }

}

class Tabla {

    private $numRows;
    private $numCols;
    private $arrayDatos;

    public function __construct($numRows, $numCols) {
        $this->numRows = $numRows;
        $this->numCols = $numCols;
    }

    public function cargarDato($dato, $rowDato, $colDato, $colorFuente, $colorFondo) {
        $objetoDato = new Dato($dato, $rowDato, $colDato, $colorFuente, $colorFondo);
        array_push($this->arrayDatos, $objetoDato);
    }

    public function escribirTabla() {
        echo '<table>';
        for ($i = 0; $i < $this->numRows; $i++) {
            echo '<tr>';
            for ($j = 0; $j < $this->numCols; $j++) {
                //Recorrer datos
                for($k = 0; $k < count($this->arrayDatos); $k++){
                    $datoActual = $this->arrayDatos[$k];
                    if($datoActual -> getRow === $i  && $datoActual -> getCol === $j){
                      ?>
<p style="background-color: <?php echo $datoActual; ?>;color: <?php echo $this->colorDato; ?>"><?php echo $this->dato; ?></p>

                    }
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    }

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


