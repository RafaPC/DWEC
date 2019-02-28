<?php

session_start();
header("Content-type: image/jpeg");
$imagen = imagecreatetruecolor(700, 100);
for ($i = 0; $i < 3; $i++) {
    $comienzo = $i * 200;
    $colorActual = 'color' . $i;
    $formaActual = 'forma' . $i;
    if ($_SESSION[$colorActual] === 'rojo') {
        $color = imagecolorallocate($imagen, 255, 0, 0);
    } else if ($_SESSION[$colorActual] === 'verde') {
        $color = imagecolorallocate($imagen, 0, 255, 0);
    } else if ($_SESSION[$colorActual] === 'azul') {
        $color = imagecolorallocate($imagen, 0, 0, 255);
    }

    if ($_SESSION[$formaActual] === 'cuadrado') {
        imagefilledrectangle($imagen, $comienzo, 0, $comienzo + 100, 100 , $color);
    } else if ($_SESSION[$formaActual] === 'rectangulo') {
        imagefilledrectangle($imagen, $comienzo, 0, $comienzo + 150, $comienzo + 100, $color);
    } else if ($_SESSION[$formaActual] === 'circulo') {
        imagefilledarc($imagen, $comienzo+50, 50, 100, 100, 0, 0, $color, IMG_ARC_PIE);
    }
}
imagejpeg($imagen);
imagedestroy($imagen);
?>