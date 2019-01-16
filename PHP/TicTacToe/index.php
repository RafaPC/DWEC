<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>3 en raya</title>
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
        if (isset($_GET['nuevoJuego'])) {
            $_SESSION['tablero']->iniciar();
        }
        if (isset($_SESSION['juegoEmpezado'])) {
            $puntuacion1 = $_SESSION['jugador1']->getPuntos();
            $puntuacion2 = $_SESSION['jugador2']->getPuntos();
            $nombre1 = $_SESSION['jugador1']->getNombre();
            $nombre2 = $_SESSION['jugador2']->getNombre();
            echo "$nombre1: $puntuacion1  - $nombre2: $puntuacion2";

            $fichaActual = $_SESSION['tablero']->getFicha();

            if (isset($_GET['fila'])) {
                $fila = $_GET['fila'];
                $columna = $_GET['columna'];
                $_SESSION['tablero']->ponerFicha($fila, $columna);
            }

            $ganado = false;
            if (isset($_GET['fila'])) {
                $ganado = $_SESSION['tablero']->verificar($fila, $columna);
                if ($ganado) {
                    //Coger los huecos vacios y cambiar el a
                    $_SESSION['tablero']->rellenarEspacios();
                    //Si es el turno de la ficha del jugador1, le suma punto
                    //Si no, suma punto al jugador2
                    if ($_SESSION['tablero']->getFicha() == $_SESSION['jugador1']->getFicha()) {
                        $_SESSION['jugador1']->sumarPuntos();
                    } else {
                        $_SESSION['jugador2']->sumarPuntos();
                    }
                    if ($_SESSION['tablero']->getFicha() === $_SESSION['jugador1']->getFicha()) {
                        echo '<h1>Ha ganado ' . $_SESSION['jugador1']->getNombre() . '</h1>';
                    } else {
                        echo '<h1>Ha ganado ' . $_SESSION['jugador2']->getNombre() . '</h1>';
                    }
                    $_SESSION['tablero']->mostrar();
                    ?>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?nuevoJuego=x" ?>">Empezar otra partida</a>
                    <?php
                }
            }
            if (!$ganado) {
                $_SESSION['tablero']->cambioTurno();
                $nombreJugador = "";
                //Si es el turno de la ficha del jugador 1, el turno es del jugador 1, si no del jugador 2
                if ($_SESSION['jugador1']->getFicha() !== $fichaActual) {
                    $nombreJugador = $_SESSION['jugador1']->getNombre();
                } else {
                    $nombreJugador = $_SESSION['jugador2']->getNombre();
                }
                echo "<h1>Turno: $nombreJugador</h1>";

                $_SESSION['tablero']->mostrar();
                if ($_SESSION['tablero']->estaLleno()) {
                    echo '<h1>Enhorabuena, no ha ganado nadie</h1>';
                    ?>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?nuevoJuego=x" ?>">Empezar otra partida</a>
                    <?php
                }
            }
        } else {
            $todoCorrecto = false;
            if (isset($_POST['enviar'])) {
                //Todas las comprobaciones pertinentes
                //Si todo correcto
                $jugador1 = $_POST['jugador1'];
                $jugador2 = $_POST['jugador2'];
                $jugador1 = filtrado($jugador1);
                $jugador2 = filtrado($jugador2);               

                if ($jugador1 === null || $jugador2 === null) {
                    echo '<h1>Tienes que escribir el nombre de los jugadores</h1>';
                } else {
                    $todoCorrecto = true;
                }
            }
            if ($todoCorrecto) {
                //La imagen vendrá de más arriba porque puede cambiar depende de cual se haya seleccionado más arriba
                //Aqui se entra solo al principio de la partida
                $ficha1 = new Ficha("Se�or_cangrejo", "resources/foto1.jpg");
                $ficha2 = new Ficha("Ayudante_de_santaclaus", "resources/foto2.jpg");

                $tablero = new Tablero($ficha1, $ficha2);

                if ($_POST['ficha'] === 'ficha1') {
                    $jugador1 = new Jugador($_POST['jugador1'], $ficha1);
                    $jugador2 = new Jugador($_POST['jugador2'], $ficha2);
                } else {
                    $jugador1 = new Jugador($_POST['jugador1'], $ficha2);
                    $jugador2 = new Jugador($_POST['jugador2'], $ficha1);
                    $tablero->cambioTurno();
                }
                $_SESSION['jugador1'] = $jugador1;
                $_SESSION['jugador2'] = $jugador2;
                $tablero->iniciar();
                $_SESSION['tablero'] = $tablero;
                $_SESSION['juegoEmpezado'] = true;



                $fichaActual = $_SESSION['tablero']->getFicha();
                $nombreJugador = "";
                //Si es el turno de la ficha del jugador 1, el turno es del jugador 1, si no del jugador 2
                if ($_SESSION['jugador1']->getFicha() === $fichaActual) {
                    $nombreJugador = $_SESSION['jugador1']->getNombre();
                } else {
                    $nombreJugador = $_SESSION['jugador2']->getNombre();
                }
                echo "<h1>Turno: $nombreJugador</h1>";

                $_SESSION['tablero']->mostrar();
            } else {
                ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div>
                        <label>Jugador 1:</label>
                        <input type="text" name="jugador1" value="jugador1">

                        <label>Jugador 2:</label>
                        <input type="text" name="jugador2" value="jugador2">
                    </div>
                    <div>La foto elegida sera la del jugador1, la otra la del jugador2</div>
                    <div>
                        <img src="resources/foto1.jpg" alt="ficha1" height="150" width="150">
                        <input type="radio" name="ficha" value="ficha1" checked><label>Foto 1</label>

                        <img src="resources/foto2.jpg" alt="ficha2" height="150" width="150">
                        <input type="radio" name="ficha" value="ficha2"><label>Foto 2</label>
                    </div>
                    <input type="submit" name="enviar" value="Continuar">
                </form>
        <?php
    }
}
?>
    </body>
</html>