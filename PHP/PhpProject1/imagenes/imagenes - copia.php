<?php
header("Content-type: image/png");

//imagepng($imagen);
$img = imagecreatefromjpeg('php.jpg');
$rojo = imagecolorallocate($img,255,0,0);
imageflip($img,IMG_FLIP_VERTICAL);
imagepng($img);
imagedestroy($imagen);

?>