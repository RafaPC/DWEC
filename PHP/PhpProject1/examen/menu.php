<?php
session_start();
if(isset($_GET['salir'])){
    session_destroy();
    header("Location: index.php");
}
if(isset($_GET['opcion'])){
   $opcion = $_GET['opcion'];
   
   $man = fopen('registro.log', 'a');
   $log = $_SESSION['login'] . '|' . date("j/n/Y-H:i:s") . '|' . $opcion . '
';
   fwrite($man, $log);
   fclose($man);
    
   header("Location: $opcion.php");
}

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    echo "<h1>Usuario: $login</h1>";
    ?>
    <a href="menu.php?opcion=juego">JUEGO DE CARTAS</a>
    <?php
    if ($_SESSION['tipo'] === 1)
        echo '<a href="menu.php?opcion=chat">CHAT</a>';
    ?>
    <a href="menu.php?opcion=salir">SALIR</a>



    <?php

    //Si se ha pulsado salir
}else {
    echo mb_convert_encoding('<h1>&#9760;', 'UTF-8', 'HTML-ENTITIES');
    echo ' No tienes acceso a esta pagina, <a href="index.php">vuelve</a> por donde has venido';
    echo mb_convert_encoding('&#9760;', 'UTF-8', 'HTML-ENTITIES') . '</h1>';
}
