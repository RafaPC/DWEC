<?php
//Si entra según se ha logeado, no lee la cookie
//Asi que si no la lee se recarga
if(!isset($_COOKIE['nombre'])){
    //A nadie le hace daó un refresh
    header('Refresh:0');
}
$nombre = $_COOKIE['nombre'];
echo "<h1>Bienvenido $nombre</h1>";
?>
<form method = "post" action = "<?php htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <input type = "submit" name="cerrarSesion" value = "salir">
</form>