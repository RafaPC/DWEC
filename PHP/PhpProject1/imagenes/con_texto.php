<?php
$captcha=  imagecreatetruecolor(240, 75);
$texto='JUEVES';
for($i=0;$i<strlen($texto);$i++) {
//Elegir un color
$color=imagecolorallocate($captcha,rand(0,255),rand(0,255),rand(0,255));
$ordenada=rand(25,75); //Elegir una ordenada
$abscisa=$i*40+rand(10,20); //Elegir una abscisa
$angulo=rand(-75,75); //Elegir un ángulo
//Escribir el carácter en la imagen
$letra= substr($texto,$i,1);
$fuente = dirname(__FILE__) . '/arial.ttf';
imagettftext($captcha, 24, $angulo,$abscisa,$ordenada,$color,$fuente, $letra);
}
header("Content-type:image/jpeg");
header("Content-Disposition:inline ; filename=captcha.jpg");
imagejpeg($captcha);
?>