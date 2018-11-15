<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="newCascadeStyleSheet.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        // put your code here
        session_start();
        require 'clases/Ficha.php';
        require 'clases/Jugador.php';
        require 'clases/Tablero.php';
        require 'filtrado.php';
        if (isset($_SESSION['juegoEmpezado'])) {
            echo 'aqui entra';
            if (isset($_POST['fila'])) {
                $fila = $_POST['fila'];
                $col = $_POST['col'];
                $fichaTurno = $_SESSION['tablero']->getFicha();
                $_SESSION['tablero'][$fila][$col] = $fichaTurno->etiquetaImg("imagen", 50, 50);
            }
        } else {
            $todoCorrecto = true;
            if (isset($_POST['jugador1'])) {
                //Todas las comprobaciones pertinentes
            }

            if ($todoCorrecto) {
                //La imagen vendrá de más arriba porque puede cambiar depende de cual se haya seleccionado más arriba
                //Aqui se entra solo al principio de la partida
                $ficha1 = new Ficha("Nombre1", "resources/foto1.jpg");
                $ficha2 = new Ficha("Nombre2", "resources/foto2.jpg");
                $tablero = new Tablero($ficha1, $ficha2);
                //var_dump($tablero->tablero);
                $_SESSION['tablero'] = $tablero;
                $_SESSION['juegoEmpezado'] = true;
            }
        }

        //La imagen vendrÃ¡ de mÃ¡s arriba porque puede cambiar depende de cual se haya seleccionado mÃ¡s arriba


        echo '<table>';
        for ($fila = 0; $fila < 3; $fila++) {
            echo '<tr>';
            for ($columna = 0; $columna < 3; $columna++) {
                echo '<td>';
                echo $_SESSION['tablero']->tablero[$fila][$columna];
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        ?>

        <!--form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Jugador 1:</label>
            <input type="text" name="jugador1" value="jugador1">

            <label>Jugador 2:</label>
            <input type="text" name="jugador2" value="jugador2">

            <img src="resources/foto1.png" alt="ficha1" height="150" width="150">
            <input type="radio" name="ficha" value="ficha1"><label>Foto 1</label>

            <img src="resources/foto1.png" alt="ficha1" height="150" width="150">
            <input type="radio" name="ficha" value="ficha2"><label>Foto 2</label>


            <input type="submit" name="enviar" value="procesar">
        </form-->
    </body>
</html>
