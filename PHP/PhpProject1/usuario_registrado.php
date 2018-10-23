<?php
include_once "header.php";
session_start();

//if(isset($_SESSION['nombre'])){
if (session_is_registered('nombre')) {
    $nombre = $_SESSION['nombre'];
    echo "Hola $nombre, cuanto tiempo";
} else {
    echo mb_convert_encoding('<h1>&#9760;', 'UTF-8', 'HTML-ENTITIES');
    echo ' No tienes acceso a esta pagina, <a href="registro_usuario.php">vuelve</a> por donde has venido';
    echo mb_convert_encoding('&#9760;', 'UTF-8', 'HTML-ENTITIES') . '</h1>';
}
?>