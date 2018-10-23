<!DOCTYPE html>
<html>
<?php
include_once "header.php";
?>

<?php
if($_SERVER ["REQUEST_METHOD"]=="POST"){

$nombre = $_POST('nombre');
$contra= $_POST('password');
$validado = true;

trim($nombre);
trim ($contra);
if(strlen($nombre)==0){
	echo 'Tienes que escribir el nombre';
	$validado = false;
}else if(strlen($contra)==0){
	echo 'Tienes que escribir la contraseña';
	$validado = false;
}

if($validado){
	session_start();
}

}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
<label>Nombre:</label>
<input type="text" name="username" value="">
<label>Contraseña:</label>
<input type="password" name="password" value="0">
<input type="submit" name="enviar" value="procesar">
</form>

<?php
if($_SESSION){
    
}
?>
</html>