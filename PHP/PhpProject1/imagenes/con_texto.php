<?php

session_start();
$arrayPalabras = ['cosa', 'willyrex', 'otracosa', 'yotramas'];
$texto = $arrayPalabras[random_int(0, 3)];
$_SESSION['palabra'] = $texto;
$captcha = imagecreatetruecolor(350, 75);
//if(isset($_SESSION['palabra'])){
//$texto = $_SESSION['palabra'];
//}else{
//$texto='nohaynada';
//}
for ($i = 0; $i < strlen($texto); $i++) {
//Elegir un color
    $color = imagecolorallocate($captcha, rand(0, 255), rand(0, 255), rand(0, 255));
    $ordenada = rand(25, 75); //Elegir una ordenada
    $abscisa = $i * 40 + rand(10, 20); //Elegir una abscisa
    $angulo = rand(-75, 75); //Elegir un ï¿½ngulo
//Escribir el carï¿½cter en la imagen
    $letra = substr($texto, $i, 1);
    $fuente = dirname(__FILE__) . '/arial.ttf';
    imagettftext($captcha, 24, $angulo, $abscisa, $ordenada, $color, $fuente, $letra);
}
$imagen = imagejpeg($captcha);
?>