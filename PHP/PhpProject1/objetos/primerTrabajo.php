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

         public function __construct($dato, $row, $col, $colorFuente, $colorFondo) {
             $this->dato = $dato;
             $this->row = $row;
             $this->col = $col;
             $this->colorFuente = $colorFuente;
             $this->colorFondo = $colorFondo;
         }

         public function getDato() {
             return $this->dato;
         }

         public function getRow() {
             return $this->row;
         }

         public function getCol() {
             return $this->col;
         }

         public function getColorFuente() {
             return $this->colorFuente;
         }

         public function getColorFondo() {
             return $this->colorFondo;
         }

     }

     class Tabla {

         private $numRows;
         private $numCols;
         private $arrayDatos = [];

         public function __construct($numRows, $numCols) {
             $this->numRows = $numRows;
             $this->numCols = $numCols;
         }

         public function cargarDato($dato, $rowDato, $colDato, $colorFuente, $colorFondo) {
             $objetoDato = new Dato($dato, $rowDato, $colDato, $colorFuente, $colorFondo);
             array_push($this->arrayDatos, $objetoDato);
         }

         public function escribirTabla() {
             ?><table style="border: 1px solid black"><?php
        for ($i = 0; $i < $this->numRows; $i++) {
            echo '<tr>';
            for ($j = 0, $dato = false; $j < $this->numCols; $j++, $dato = false) {
                ?><td style="border: 1px solid black"><?php
                    //Recorrer datos
                    for ($k = 0; $k < count($this->arrayDatos); $k++) {
                        $datoActual = $this->arrayDatos[$k];
                        if ($datoActual->getRow() === $i && $datoActual->getCol() === $j) {
                            $dato = true;
                            ?>
                                <p style="background-color: <?php echo $datoActual->getColorFondo(); ?>;color: <?php echo $datoActual->getColorFuente(); ?>"> <?php echo $datoActual->getDato(); ?></p>
                                <?php
                            }
                        }
                        if (!$dato) {
                            echo 'x';
                        }
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }

        }

        class Menu {

            private $arrayOpciones = [];

            const VERTICAL = 'vertical';
            const HORIZONTAL = 'horizontal';

            private function mostrarVertical() {
                foreach($this->arrayOpciones as $valor){
                    echo "<a style=\"float:left; clear: left; margin-top: 8px\"href=\"#\">$valor</a>";
                }
            }

            private function mostrarHorizontal() {
                echo '<div>';
                foreach($this->arrayOpciones as $valor){
                    echo "<a style=\"margin-left: 8px\" href=\"#\">$valor</a>";
                }
                echo '</div>';
            }

            public function mostrar($orientacion) {
                //self::VERTICAL;
                if ($orientacion === self::VERTICAL) {
                    $this->mostrarVertical();
                } else if ($orientacion === self::HORIZONTAL) {
                    $this->mostrarHorizontal();
                }
            }
            
            public function añadirOpcion($opcion){
                array_push($this->arrayOpciones, $opcion);
            }

        }

        $newCabecera = new CabeceraPagina('right', 'green', 'red');
        $tabla = new Tabla(5, 5);
        $tabla->cargarDato('dato', 2, 2, 'red', 'black');
        
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
$tabla->escribirTabla();
echo $newCabecera->mostrarTitulo();
$menu = new Menu();
$menu->añadirOpcion('opcion1');
$menu->añadirOpcion('opcion2');
$menu->añadirOpcion('opcion3');
$menu->mostrar('horizontal');
$menu->mostrar('vertical');

?>
        </body>
    </html>