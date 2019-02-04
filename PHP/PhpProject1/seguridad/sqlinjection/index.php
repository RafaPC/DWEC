<?php
require_once('head.html');
if(isset($_GET['enviar'])){
	$nombre = $_GET['nombre'];
	$contra = $_GET['contra'];
	require_once('conecta.php');
	$conn = new ConectaBD();
	
	$resultado = $conn->consulta2($nombre,$contra);
	if($resultado){
		echo '<h1>yas has entrado</h1>';
	}else{
		echo '<h1>nono hacker</h1>';
	}
}else{
?>
<form method="get" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="nombre" id="nombre">
	<label for="contra">Contra:</label>
	<input type="text" name="contra" value="contra" id="contra">

	<input type="submit" name="enviar" value="procesar">
</form>
<?php
	}
?>

</body>
</html>