<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 1</title>
    </head>
    <body>
        <?php
        session_start();
        $formas = ['cuadrado', 'rectangulo', 'circulo'];
        $colores = ['rojo', 'verde', 'azul'];
        for ($i = 0; $i < 3; $i++) {
            $_SESSION['forma' . $i] = $formas[rand(0, 2)];
            $_SESSION['color' . $i] = $colores[rand(0, 2)];
        }
        echo '<img src="imagen.php" alt="x" width="700" height="100">';
        if ($_SESSION['forma0'] === $_SESSION['forma1'] && $_SESSION['forma0'] === $_SESSION['forma2']) {
            if ($_SESSION['color0'] === $_SESSION['color1'] && $_SESSION['color0'] === $_SESSION['color2']) {
                echo '<div>100 PUNTOS</div>';
            } else {
                echo '<div>20 puntos</div>';
            }
        } else if ($_SESSION['color0'] === $_SESSION['color1'] && $_SESSION['color0'] === $_SESSION['color2']) {
            echo '<div>5 puntos</div>';
        }
        ?>
    </body>
</html>
