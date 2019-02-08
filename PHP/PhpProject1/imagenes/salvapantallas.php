<?php

session_start();
//$_SESSION['posicionX'] = 0;
//$_SESSION['posicionY'] = 0;
$img = imagecreatetruecolor(800, 400);

// allocate some colors
$r = rand(0, 255);
$g = rand(0, 255);
$b = rand(0, 255);
$arrayColores = [];
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $arrayColores[$i][$j] = rand(0, 255);
    }
    $color = imagecolorallocate($img, $arrayColores[$i][0], $arrayColores[$i][1], $arrayColores[$i][2]);
    $arrayColores[$i] = $color;
}
$white = imagecolorallocate($img, $r, $g, $b);

//$red = imagecolorallocate($img, 255, 0, 0);
//$green = imagecolorallocate($img, 0, 255, 0);
//$blue = imagecolorallocate($img, 0, 0, 255);
//$color = imagecolorallocate($img, $arrayColores[0][0], $arrayColores[0][1], $arrayColores[0][2]);
/*
  // draw the head
  imagearc($img, 100, 100, 200, 200,  0, 360, $white);
  // mouth
  imagearc($img, 100, 100, 150, 150, 25, 155, $red);
  // left and then the right eye
  imagearc($img,  60,  75,  50,  50,  0, 360, $green);
  imagearc($img, 140,  75,  50,  50,  0, 360, $blue);
 */
function checkear() {
    $figuras = [];
    $comienzos = [];


    //Supuestamente esto sirve para checkear tantas posiciones y sumar como figuras haya
    global $figuras, $comienzos;
    for ($i = 0; $i < count($_SESSION['figuras']); $i++) {
        if (!isset($_SESSION['posiciones'][$i]['posicionX'])) {
            $_SESSION['posiciones'][$i]['posicionX'] = 1;
        }
        if (!isset($_SESSION['posiciones'][$i]['posicionY'])) {
            $_SESSION['posiciones'][$i]['posicionY'] = 1;
        }
        if (!isset($_SESSION['sumas'][$i]['sumaX'])) {
            $_SESSION['sumas'][$i]['sumaX'] = 3;
        }
        if (!isset($_SESSION['sumas'][$i]['sumaY'])) {
            $_SESSION['sumas'][$i]['sumaY'] = 3;
        }

        $comienzos[$i]['x'] = $_SESSION['posiciones'][$i]['x'];
        $comienzos[$i]['y'] = $_SESSION['posiciones'][$i]['y'];

        if (isset($_SESSION['posiciones'][$i]['x'])) {
            $_SESSION['posiciones'][$i]['x'] += $_SESSION['sumas'][$i]['x'];

            if ($_SESSION['posiciones'][$i]['x'] > 750) {
                $_SESSION['sumas'][$i]['x'] = -10;
            } else if ($_SESSION['posiciones'][$i]['x'] < 55) {
                $_SESSION['sumas'][$i]['x'] = 10;
            }
        }
        if (isset($_SESSION['posiciones'][$i]['y'])) {
            $_SESSION['posiciones'][$i]['y'] += $_SESSION['sumas'][$i]['y'];

            if ($_SESSION['posiciones'][$i]['y'] > 220) {
                $_SESSION['sumas'][$i]['y'] = -10;
            } else if ($_SESSION['posiciones'][$i]['y'] < 30) {
                $_SESSION['sumas'][$i]['y'] = 10;
            }
        }
    }
}

function crearFigura($comienzoX, $comienzoY, $arrayColores) {
    //MIRAR AQUI
    if(isset($_SESSION['comienzos'])){
        $_SESSION['comienzos'][0]['x'];
    }
    imagefilledarc($img, $comienzoX, $comienzoY, 50, 50, 180, 360, $arrayColores[0], IMG_ARC_PIE);
    imagefilledrectangle($img, $comienzoX - 24, $comienzoY, $comienzoX + 24, $comienzoY + 140, $arrayColores[1]);
    imagefilledarc($img, $comienzoX - 25, $comienzoY + 150, 50, 50, 0, 360, $arrayColores[2], IMG_ARC_PIE);
    imagefilledarc($img, $comienzoX + 25, $comienzoY + 150, 50, 50, 0, 360, $arrayColores[2], IMG_ARC_PIE);
    // output image in the browser
    header("Content-type: image/png");
    imagepng($img);
}

if (!isset($_SESSION['posicionX'])) {
    $_SESSION['posicionX'] = 1;
}
if (!isset($_SESSION['posicionY'])) {
    $_SESSION['posicionY'] = 1;
}
if (!isset($_SESSION['sumaX'])) {
    $_SESSION['sumaX'] = 3;
}
if (!isset($_SESSION['sumaY'])) {
    $_SESSION['sumaY'] = 3;
}
$comienzoX = $_SESSION['posicionX'];
$comienzoY = $_SESSION['posicionY'];

imagefilledarc($img, $comienzoX, $comienzoY, 50, 50, 180, 360, $arrayColores[0], IMG_ARC_PIE);
imagefilledrectangle($img, $comienzoX - 24, $comienzoY, $comienzoX + 24, $comienzoY + 140, $arrayColores[1]);
imagefilledarc($img, $comienzoX - 30, $comienzoY + 150, 60, 60, 0, 360, $arrayColores[2], IMG_ARC_PIE);
imagefilledarc($img, $comienzoX + 30, $comienzoY + 150, 60, 60, 0, 360, $arrayColores[2], IMG_ARC_PIE);
// output image in the browser
header("Content-type: image/png");
imagepng($img);

if (isset($_SESSION['posicionX'])) {
    $_SESSION['posicionX'] = $comienzoX + $_SESSION['sumaX'];

    if ($_SESSION['posicionX'] > 750) {
        $_SESSION['sumaX'] = -10;
    } else if ($_SESSION['posicionX'] < 55) {
        $_SESSION['sumaX'] = 10;
    }
}

if (isset($_SESSION['posicionY'])) {
    $_SESSION['posicionY'] = $comienzoY + $_SESSION['sumaY'];

    if ($_SESSION['posicionY'] > 220) {
        $_SESSION['sumaY'] = -10;
    } else if ($_SESSION['posicionY'] < 30) {
        $_SESSION['sumaY'] = 10;
    }
}

usleep(3000);
header("Refresh:0");
?>