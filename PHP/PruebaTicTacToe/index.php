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
        require 'clases/Ficha.php';
        require 'clases/Jugador.php';
        require 'clases/Tablero.php';
        require 'filtrado.php';
        session_start();
        if (isset($_SESSION['juegoEmpezado'])) {
            if (isset($_GET['fila'])) {
                $fila = $_GET['fila'];
                $columna = $_GET['col'];
                $fichaTurno = $_SESSION['tablero']->getFicha();
                $_SESSION['tablero']->tablero[$fila][$columna] = $fichaTurno->etiquetaImg("imagen", 100, 100);
                //var_dump($_SESSION['tablero']);
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
                $tablero->iniciar();
                $_SESSION['tablero'] = $tablero;
                $_SESSION['juegoEmpezado'] = true;
            }
        }

        //La imagen vendrÃ¡ de mÃ¡s arriba porque puede cambiar depende de cual se haya seleccionado mÃ¡s arriba

        $_SESSION['tablero']->mostrar();
        if (isset($_GET['fila'])) {
            $ganado = $_SESSION['tablero']->verificar($fila, $columna);
            if ($ganado) {
                echo 'HAS GANADO';
            }
        }
        $_SESSION['tablero']->cambioTurno();
        ?>

        <!--form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);      ?>">
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
